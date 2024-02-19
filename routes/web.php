<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::controller(HomeController::class)->group(function(){
    Route::get('/home', 'showHome')->name('homePage');
});

Route::controller(ProductController::class)->group(function () {
    Route::get('/product', 'list')->name('product-list');
    Route::get('/product/create', 'createForm')->name('product-create-form');
    Route::post('/product/create', 'create')->name('product-create');
    Route::get('/product/{product}', 'show')->name('product-view');
    Route::get('/product/{product}/update', 'updateForm')->name('product-update-form');
    Route::post('/product/{product}/update', 'update')->name('product-update');
    Route::get('/product/{product}/delete', 'delete')->name('product-delete');

    Route::get('/product/{product}/shop', 'showShop')->name('product-view-shop');
    Route::get('/product/{product}/shop/add', 'addShopForm')->name('product-add-shop-form');
    Route::post('/product/{product}/shop/add', 'addShop')->name('product-add-shop');
    Route::get('/product/{product}/shop/{shop}/remove', 'removeShop')->name('product-remove-shop');
});

Route::controller(ShopController::class)->group(function () {
    Route::get('/shop', 'list')->name('shop-list');
    Route::get('/shop/create', 'createForm')->name('shop-create-form');
    Route::post('/shop/create', 'create')->name('shop-create');
    Route::get('/shop/{shop}', 'show')->name('shop-view');
    Route::get('/shop/{shop}/update', 'updateForm')->name('shop-update-form');
    Route::post('/shop/{shop}/update', 'update')->name('shop-update');
    Route::get('/shop/{shop}/delete', 'delete')->name('shop-delete');

    Route::get('/shop/{shop}/shop', 'showProduct')->name('shop-view-product');
    Route::get('/shop/{shop}/product/add', 'addProductForm')->name('shop-add-product-form');
    Route::post('/shop/{shop}/product/add', 'addProduct')->name('shop-add-product');
    Route::get('/shop/{shop}/product/{product}/remove', 'removeProduct')->name('shop-remove-product');
});

Route::controller(CategoryController::class)->group(function () {
    Route::get('/category', 'list')->name('category-list');
    Route::get('/category/create', 'createForm')->name('category-create-form');
    Route::post('/category/create', 'create')->name('category-create');
    Route::get('/category/{category}', 'show')->name('category-view');
    Route::get('/category/{category}/update', 'updateForm')->name('category-update-form');
    Route::post('/category/{category}/update', 'update')->name('category-update');
    Route::get('/category/{category}/delete', 'delete')->name('category-delete');
    Route::get('/category/{category}/category', 'showProduct')->name('category-view-product');
    Route::get('/category/{category}/product/add', 'addProductForm')->name('category-add-product-form');
    Route::post('/category/{category}/product/add', 'addProduct')->name('category-add-product');
    Route::get('/category/{category}/product/{product}/remove', 'removeProduct')->name('category-remove-product');
});

Route::controller(LoginController::class)->group(function() {
    Route::get('/auth/login', 'loginForm')
    ->name('login'); // name this route to login by default setting.
    Route::post('/auth/login', 'authenticate')->name('authenticate');
    Route::get('/auth/logout', 'logout')->name('logout');
    });

Route::controller(CartController::class)->group(function() {
    Route::get('/cart', 'list')->name('cart-list');
    Route::get('/cart/add/{product}', 'addProduct')->name('cart-add-product');
    Route::get('/cart/remove/{product}' , 'removeProduct')->name('cart-remove-product');
    Route::post('/cart/update', 'update')->name('cart-update');
});

Route::controller(UserController::class)->group(function() {
    Route::get('/user', 'list')->name('user-list');
    Route::get('/user/create', 'createForm')->name('user-create-form');
    Route::post('/user/create', 'create')->name('user-create');
    Route::get('/user/{user}', 'show')->name('user-view');
    Route::get('/user/{user}/update','updateForm')->name('user-update-form');
    Route::post('/user/{user}/update','update')->name('user-update');
    Route::get('/user/{user}/delete','delete')->name('user-delete');

});
