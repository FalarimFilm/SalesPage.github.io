<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Shop;
use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Psr\Http\Message\ServerRequestInterface as Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends SearchableController
{
    private string $title = 'Product';

    public function __construct()
{
    $this->middleware('auth')->only('list');
}

    function getQuery(): Builder|Relation
    {
        return Product::orderBy('code');
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

    function filterBySearch(Builder|Relation $query, array $search): Builder|Relation
    {
        $query = parent::filterBySearch($query, $search);
        $query = $this->filterByPrice(
            $query,
            ($search['minPrice'] === null)? null : (float) $search['minPrice'],
            ($search['maxPrice'] === null)? null : (float) $search['maxPrice'],
        );

        return $query;
    }

    function list(Request $request)
    {
        $search = $this->prepareSearch($request->getQueryParams());
        $query = $this->search($search);
        session()->put('bookmark.product-view', $request->getUri());
        return view('products.list', [
            'title' => "{$this->title} : List" ,
            'search' => $search,
            'products' => $query->paginate(5),
        ]);
    }

    function show($productCode)
    {
        $product = $this->find($productCode);

        return view('products.view', [
            'title' => "{$this->title} : View",
            'product' => $product,
        ]);
    }

    function createForm()
    {
        $categories = Category::orderBy('code')->get();

        return view('products.create-form', [
            'title' => "{$this->title} : Create",
            'categories' =>$categories,

        ]);
    }

    function create(Request $request, CategoryController $categoryController)
    {

        $product = new Product();
        $data = $request->getParsedBody();
        $product = Product::create([
            'code' => $data['code'],
            'name' => $data['name'],
            'category_id' => $data['category'],
            'price' => $data['price'],
            'description' => $data['description'],
            'shop_id' => Auth::user()->shop->id
        ]);
        return redirect()->route('product-list')
        ->with('status', "Product {$product->code} was created.");
    }

    function updateForm($productCode)
    {
        $product = $this->find($productCode);
        $categories = Category::orderBy('code')->get();

        return view('products.update-form', [
            'title' => "{$this->title} : Update",
            'product' => $product,
            'categories' =>$categories,

        ]);
    }

    function update(Request $request, $productCode, CategoryController $categoryController)
    {
        $product = $this->find($productCode);
        $data = $request->getParsedBody();
        $product->fill($data);

        $category = $categoryController->find($data['category']);
        $product->category()->associate($category);
        $product->save();

        return redirect()->route('product-view', [
            'product' => $product->code,
        ])
        ->with('status', "Product {$product->code} was updated.");
    }

    function delete($productCode)
    {
        $product = $this->find($productCode);
        $product->delete();

        return redirect(session()->get('bookmark.product-view', route('product-list')))
        ->with('status', "Product {$product->code} was deleted.");
    }

    function showShop(
        Request $request,
        ShopController $shopController,
        $productCode
    ) {
        $product = $this->find($productCode);
        $search = $shopController->prepareSearch($request->getQueryParams());
        $shopQuery = $product->shops();
        $shopQuery = $shopController->filterBySearch($shopQuery, $search);
        session()->put('bookmark.shop-view', $request->getUri());
        return view('products.view-shop', [
        'title' => "{$this->title} {$product->code} : Shop",
        'product' => $product,
        'search' => $search,
        'shops' => $shopQuery->paginate(5),
        ]);
    }

    function addShopForm(
        Request $request,
        ShopController $shopController,
        $productCode
    ){
        $product = $this->find($productCode);
        $shopQuery = Shop::orderBy('code')
            ->whereDoesntHave('products', function(Builder $innerQuery) use($product) {
                return $innerQuery->where('code', $product->code);
            });
    $search = $shopController->prepareSearch($request->getQueryParams());
    $query = $shopController->filterBySearch($shopQuery, $search);
    session()->put('bookmark.shop-view', $request->getUri());
    return view('products.add-shop-form', [
        'title' => "{$this->title} {$product->code} : Add Shop",
        'search' => $search,
        'product' => $product,
        'shops' => $query->paginate(5),
    ]);
    }

    function addShop(
        Request $request,
        $productCode
        ) {
            $product = $this->find($productCode);
            $data = $request->getParsedBody();
            $shop = Shop::whereDoesntHave('products', function(Builder $innerQuery) use($product) {
            return $innerQuery->where('code', $product->code);
            })->where('code', $data['shop'])->firstOrFail();
            $product->shops()->attach($shop);
            return redirect()->back()
            ->with('status', "Shop {$shop->code} was added to Product {$product->code}.");
        }

    function removeShop($productCode, $shopCode)
        {
            $product = $this->find($productCode);
            $shop = $product->shops()->where('code', $shopCode)->firstOrFail();
            $product->shops()->detach($shop);

            return redirect()->back()->with('status', "Shop {$shop->code} was removed to Product {$product->code}.");
        }

        function filterByTerm(Builder|Relation $query, ?string $term) : Builder|Relation {
            if(!empty($term)) {
                foreach(\preg_split('/\s+/', \trim($term)) as $word) {
                    $query->where(function(Builder|Relation $innerQuery) use ($word) {
                        $innerQuery
                            ->where('code', 'LIKE', "%{$word}%")
                            ->orWhere('name', 'LIKE', "%{$word}%")
                            ->orWhereHas('category', function (Builder $catQuery) use ($word) {
                                $catQuery->where('name', 'LIKE', "%{$word}%");
                            });
                    });

                }
            }

            return $query;
        }


    }

