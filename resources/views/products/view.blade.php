@extends('layouts.main')

@section('title', $title)

@section('content')
    <main>

        <nav class="nav-view">
            <ul>
                <li>
                    <a href="{{ route('shop-view', ['shop' => $product->shop->code]) }}">Show Shop</a>
                </li>
                @auth
                @if(auth()->user()->role == 'ADMIN')
                <li>
                    <a href="{{ route('product-update-form', ['product' => $product->code]) }}">Update</a>
                </li>
                <li>
                    <a href="{{ route('product-delete', ['product' => $product->code]) }}">Delete</a>
                </li>
                @endif
                @endauth
            </ul>
            <ul>
                <a href="{{session()->get('product-view', route('product-list', ['product' => $product->code,]))}}">&lt; Back</a>
            </ul>
        </nav>

        <div class="view">
            <div>
                <b>Code ::</b>
                <span>{{ $product->code }}</span>
                <br />
                <b>Name ::</b>
                <span>{{ $product->name }}</span>
                <br />
                <b>Category ::</b>
                <span>[{{ $product->category->code }}] <em>{{ $product->category->name }}</em></span>
                <br />
                <b>Price ::</b>
                <span>{{ number_format((float) $product->price, 2) }}</span>
                <br />
                <b>Description ::</b>
                <pre>{{ $product->description }}</pre>
                <br />
                <br />
            </div>
        </div>


            <button><a class="addToCard" href="{{ route('cart-add-product' , ['product' => $product->code,]) }}">Add To Cart</button>

    </main>

@endsection
