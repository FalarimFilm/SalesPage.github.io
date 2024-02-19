@extends('layouts.main')

@section('title', $title)

@section('content')
<main>
    <form action="{{ route('shop-view-product', ['shop' => $shop->code,]) }}" method="get" class="search-form">
        <label>
            Search
            <input type="text" name="term" value="{{ $search['term'] }}" />
        </label>
        <br />
        <a href="{{ route('shop-view-product', ['shop' => $shop->code,]) }}">
            <button type="button" class="accent">Clear</button>
        </a>
    </form>
    <div>{{ $products->withQueryString()->links() }}</div>
    <nav class="nav-view">
        <ul>
            @auth
            @if(auth()->user()->role == 'ADMIN')
            <li><a href="{{ route('shop-add-product-form', ['shop' => $shop->code,]) }}">&lt; Add Product</a></li>
            @endif
            @endauth
            <ul>
                <li>
                    <a href="{{route('shop-view', ['shop' => $shop->code,])}}">&lt; Back </a>
                </li>
            </ul>
        </ul>

    </nav>
    <table>
        <thead>
            <tr>
                <th>Code</th>
                <th>Name</th>
                <th>Category</th>
                <th>Price</th>
            </tr>
        </thead>

        <tbody>
            @foreach($products as $product)
            <tr>
                <td>
                    <a href="{{ route('product-view', [
                        'product' => $product->code,])
                        }}"> {{ $product->code }}
                    </a>
                </td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->category->name }}</td>
                <td>{{ $product->price }}</td>
                @auth
                @if(auth()->user()->role == 'ADMIN')
                <td>
                        <a href="{{ route('product-remove-shop', [
                            'product' => $product->code,
                            'shop' => $shop->code,
                            ]) }}">Remove</a>
                    </td>
                @endif
                @endauth
            </tr>
            @endforeach
        </tbody>
    </table>
    <br />
    <br />
</main>

@endsection
