@extends('layouts.main')

@section('title', $title)

@section('content')
<main>
    <form action="{{ route('shop-add-product', ['shop' => $shop->code,]) }}" method="get" class="search-form">
        <label>
            Search
            <input type="text" name="term" value="{{ $search['term'] }}" />
        </label>
        <br />
        <label>
            Min Price
            <input type="number" name="minPrice" value="{{ $search['minPrice'] }}" step="any" />
        </label>
        <br />
        <label>
            Max Price
            <input type="number" name="maxPrice" value="{{ $search['maxPrice'] }}" step="any" />
        </label>
        <br />
        <button type="submit" class="primary">Search</button>

        <a href="{{ route('shop-view-product', ['shop' => $shop->code,]) }}">
            <button type="button" class="accent">Clear</button>
        </a>
    </form>
    <div>{{ $products->withQueryString()->links() }}</div>
    <nav>
        <ul>
            <li><a href="{{ route('shop-view-product', [
                'shop' => $shop->code,
                ]) }}">&lt; Back</a></li>
        </ul>
        </nav>
    <form action="{{ route('shop-add-product', [
            'shop' => $shop->code,
            ]) }}" method="post">
        @csrf
    <table>
        <thead>
            <tr>
                <th>Code</th>
                <th>Name</th>
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
                <td>{{ $product->price }}</td>
                <td>
                        <button type="submit" name="product" value="{{ $product->code}}">Add</button>
                    </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    </form>
    <br />
    <br />
</main>

@endsection