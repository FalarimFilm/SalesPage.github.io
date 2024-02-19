<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Shop;
use GuzzleHttp\Handler\Proxy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Psr\Http\Message\ServerRequestInterface as Request;
use Illuminate\Support\Facades\Auth;

class ShopController extends SearchableController
{

    private string $title = 'Shop';


    function getQuery(): Builder|Relation
    {
        return Shop::orderBy('code');
    }

    function filterByTerm(Builder|Relation $query, ?string $term) : Builder|Relation {
        if(!empty($term)) {
            foreach(\preg_split('/\s+/', \trim($term)) as $word) {
                $query->where(function(Builder|Relation $innerQuery) use ($word) {
                    $innerQuery
                        ->where('code', 'LIKE', "%{$word}%")
                        ->orWhere('name', 'LIKE', "%{$word}%")
                        ->orWhere('owner', 'LIKE', "%{$word}%");
                });
                
            }
        }
        
        return $query;
    }

    function filterByPrice(
        Builder|Relation $query, 
        ?float $minPrice, 
        ?float $maxPrice
    ) : Builder|Relation
    {
        if($minPrice !== null) {
            $query->where('price', '>=', $minPrice);
        }
        
        if($maxPrice !== null) {
            $query->where('price', '<=', $maxPrice);
        }
        
        return $query;
    }

    function prepareSearch(array $search) : array 
    {
        $search = parent::prepareSearch($search);
        $search = \array_merge([
            'minPrice' => null,
            'maxPrice' => null,
        ], $search);
        
        return $search;
    }


    function filterBySearch(Builder|Relation $query, array $search) : Builder|Relation
    {
        $query = parent::filterBySearch($query, $search);
        $query = $this->filterByPrice($query,
        ($search['minPrice'] === null)? null : (float) $search['minPrice'],
        ($search['maxPrice'] === null)? null : (float) $search['maxPrice'],
        );
        return $query;
        }

    function list(Request $request) 
    {
        $search = $this->prepareSearch($request->getQueryParams());
        $query = $this->search($search)->withCount('products');
        session()->put('bookmark.shop-view', $request->getUri());
        return view('shops.list', [
            'title' => "{$this->title} : List" ,
            'search' => $search,
            'shops' => $query->paginate(5),
        ]);
    }

    function show($shopCode)
    {
        $shop = $this->find($shopCode);

        return view('shops.view', [
            'title' => "{$this->title} : View",
            'shop' => $shop,
        ]);
    }

    function createForm() 
    {

        return view('shops.create-form', [
            'title' => "{$this->title} : Create",
        ]);
    }
        
    function create(Request $request) 
    {  

        $data = $request->getParsedBody();
        $shop = Shop::create([
            'code' => $data['code'],
            'name' => $data['name'],
            'latitude' => $data['latitude'],
            'longitude' => $data['longitude'],
            'address' => $data['address'],
            'user_id' => Auth::user()->id
        ]);
        
        return redirect()->route('shop-list')
        ->with('status', "Shop {$shop->code} was created.");
    }

    function updateForm($shopCode) 
    {
        $shop = $this->find($shopCode);
        
        return view('shops.update-form', [
            'title' => "{$this->title} : Update",
            'shop' => $shop,
        ]);
    }

    function update(Request $request, $shopCode) 
    {
        $shop = $this->find($shopCode);
        $shop->fill($request->getParsedBody());
        $shop->save();
        
        return redirect()->route('shop-view', [
            'shop' => $shop->code,
        ])
        ->with('status', "Shop {$shop->code} was updated.");
    }

    function delete($shopCode) 
    {
        $shop = $this->find($shopCode);
        $shop->delete();
        
        return redirect(session()->get('bookmark.shop-view', route('shop-list')))
        ->with('status', "Shop {$shop->code} was deleted.");
    }

    function showProduct(
        Request $request,
        ProductController $productController,
        $shopCode
        ) {
        $shop = $this->find($shopCode);
        $search = $productController->prepareSearch($request->getQueryParams());
        $productQuery = $shop->products();
        $productQuery = $productController->filterBySearch($productQuery, $search);
        session()->put('bookmark.product-view', $request->getUri());
        return view('shops.view-product', [
        'title' => "{$this->title} {$shop->code} : Product",
        'shop' => $shop,
        'search' => $search,
        'products' => $productQuery->paginate(5),
        ]);
        }
    
        function addProductForm(
            Request $request,
            ProductController $productController,
            $shopCode
        ){
            $shop = $this->find($shopCode);
            $productQuery = Product::orderBy('code')
                ->whereDoesntHave('shop', function(Builder $innerQuery) use($shop) {
                    return $innerQuery->where('code', $shop->code);
                });
        session()->put('bookmark.product-view', $request->getUri());
        $search = $productController->prepareSearch($request->getQueryParams());
        $query = $productController->filterBySearch($productQuery, $search);
        return view('shops.add-product-form', [
            'title' => "{$this->title} {$shop->code} : Add Product",
            'search' => $search,
            'shop' => $shop,
            'products' => $query->paginate(5),
        ]);
        }
        
        function addProduct(
            Request $request,
            $shopCode
            ) {
                $shop = $this->find($shopCode);
                $data = $request->getParsedBody();
                $product = Product::whereDoesntHave('shop', function(Builder $innerQuery) use($shop) {
                    return $innerQuery->where('code', $shop->code);
                })->where('code', $data['product'])->firstOrFail();  
                $shop->products()->attach($product);
                return redirect()->back()
                ->with('status', "Product {$product->code} was added to Shop {$shop->code}.");
            }
    
        function removeProduct($shopCode, $productCode) 
            {
                $shop = $this->find($shopCode);
                $product = $shop->products()->where('code', $productCode)->firstOrFail();
                $shop->products()->detach($product);
                return redirect()->back()->with('status', "Product {$product->code} was removed to Shop {$shop->code}.");
            }
}