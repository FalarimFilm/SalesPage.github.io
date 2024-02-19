<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Psr\Http\Message\ServerRequestInterface as Request;

class CategoryController extends SearchableController
{

    private string $title = 'Category';


    function getQuery(): Builder|Relation
    {
        
        return Category::orderBy('code');
    }

    function filterByTerm(Builder|Relation $query, ?string $term) : Builder|Relation {
        if(!empty($term)) {
            foreach(\preg_split('/\s+/', \trim($term)) as $word) {
                $query->where(function(Builder|Relation $innerQuery) use ($word) {
                    $innerQuery
                        ->where('code', 'LIKE', "%{$word}%")
                        ->orWhere('name', 'LIKE', "%{$word}%");
                        
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
        session()->put('bookmark.category-view', $request->getUri());
        return view('categories.list', [
            'title' => "{$this->title} : List" ,
            'search' => $search,
            'categories' => $query->paginate(5),
        ]);
    }

    function show($categoryCode)
    {
        $category = $this->find($categoryCode);

        return view('categories.view', [
            'title' => "{$this->title} : View",
            'category' => $category,
        ]);
    }

    function createForm() 
    {
        return view('categories.create-form', [
            'title' => "{$this->title} : Create",
        ]);
    }
        
    function create(Request $request) 
    {  
        $category = Category::create($request->getParsedBody());
        
        return redirect()->route('category-list')
		->with('status', "Category {$category->code} was created.");
    }

    function updateForm($categoryCode) 
    {
        $category = $this->find($categoryCode);
        
        return view('categories.update-form', [
            'title' => "{$this->title} : Update",
            'category' => $category,
        ]);
    }

    function update(Request $request, $categoryCode) 
    {
        $category = $this->find($categoryCode);
        $category->fill($request->getParsedBody());
        $category->save();
        return redirect()->route('category-view', [
			'category' => $category->code,
		])->with('status', "Category {$category->code} was updated.");
    }

    function delete($categoryCode) 
    {
        $category = $this->find($categoryCode);
        $category->delete();
        return redirect(session()->get('bookmark.category-view', route('product-list')))
		->with('status', "Category {$category->code} was deleted.");
    }

    function showProduct(
        Request $request,
        ProductController $productController,
        $categoryCode
        ) {
        $category = $this->find($categoryCode);
        $search = $productController->prepareSearch($request->getQueryParams());
        $productQuery = $category->products();
        $productQuery = $productController->filterBySearch($productQuery, $search);
        session()->put('bookmark.product-view', $request->getUri());
        return view('categories.view-product', [
        'title' => "{$this->title} {$category->code} : Product",
        'category' => $category,
        'search' => $search,
        'products' => $productQuery->paginate(5),
        ]);
        }
        function addProductForm(
            Request $request,
            ProductController $productController,
            $categoryCode
        ){
            $category = $this->find($categoryCode);
    
            $productQuery = Product::orderBy('code')
                ->whereDoesntHave('category', function(Builder $innerQuery) use($category) {
                    return $innerQuery->where('code', $category->code);
    
                });
    
        $search = $productController->prepareSearch($request->getQueryParams());
        $query = $productController->filterBySearch($productQuery, $search);
        session()->put('bookmark.product-view', $request->getUri());
        return view('categories.add-product-form', [
            'title' => "{$this->title} {$category->code} : Add Product",
            'search' => $search,
            'category' => $category,
            'products' => $query->paginate(5),
        ]);
        }
        
        function addProduct(
            Request $request,
            $categoryCode
            ) {
                $category = $this->find($categoryCode);
                $data = $request->getParsedBody();
                $product = Product::whereDoesntHave('category', function(Builder $innerQuery) use($category) {
                return $innerQuery->where('code', $category->code);
                })->where('code', $data['product'])->firstOrFail();
                $category->products()->save($product);
                return redirect()->back()
		->with('status', "Product {$product->code} was added to Category {$category->code}.");
            }
        }
