<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Shop;
use App\Models\User;
use App\Models\Cart;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Auth;
use Psr\Http\Message\ServerRequestInterface as Request;

class CartController extends Controller
{
    function list(Request $request)
    {
        $user = Auth::user();
        $cart = $user->cart;
        $products = $cart->products;

        return view('cart',[
            'products' => $products,
            'cart' => $cart,

        ]);
    }

    function addProduct($productCode){
        $product = Product::where('code',$productCode)->firstOrFail();

        $user = Auth::user();
        $cart = $user->cart;

        if(!$cart) {
            $cart = Cart::create([
                'user_id' => $user->id
            ]);
        }

        $exitproduct = $cart->products()->where('code',$product->code)->first();

        if ($exitproduct) {
            $amount = $exitproduct->pivot->amont+1;
            $cart->products()->updateExistingPivot(
            $exitproduct->id,
            [
                'amont' => $amount,
                'price' => $exitproduct->price * $amount,
            ]
            );
        }else{
            $cart->products()->attach([
                $product->id => [
                    'amont' => 1,
                    'price' => $product->price,
                ]
                ]);
        }

    $totalPrice = $cart->products->sum('pivot.total_price');
    $cart->update(['total_price' => $totalPrice]);

    return redirect()->route('cart-list');

    }

    function removeProduct($productCode)
    {
        $product = Product::where('code', $productCode)->firstOrFail();
        $user = Auth::user();
        $cart = $user->cart;

        $cart->products()->detach($product);

        $totalPrice = $cart->products->sum('pivot.price');
        $cart->update(['total_price' => $totalPrice]);
        return redirect()->back();
    }

    function update(request $request)
    {
        $data = $request->getParsedBody();
        $items = $data['items'];

        foreach($items as $index => $item){
            $items[$index]['price'] = $item['amont'] * $item['itemPrice'];
            unset($items[$index]['itemPrice']);
        }


        $user = Auth::user();
        $cart = $user->cart;

        $cart->products()->sync($items);

        $totalPrice = $cart->products->sum('pivot.price');
        $cart->update(['total_price' => $totalPrice]);

        return redirect()->back();
    }


}
