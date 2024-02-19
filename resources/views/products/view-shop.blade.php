@extends('layouts.main')

@section('title', $title)

@section('content')
    <main>
    <form action="{{ route('product-view-shop', ['product' => $product->code,]) }}" method="get" class="search-form">
        <label>
            Term
            <input type="text" name="term" value="{{ $search['term'] }}" />
        </label>

        <a href="{{ route('product-view-shop', ['product' => $product->code,]) }}">
            <button type="button" class="accent">Clear</button>
        </a>
    </form>
    <div>{{ $shops->withQueryString()->links() }}</div>
    <nav class="nav-view">
        <ul>
            <li>
                <a href="{{session()->get('product-view', route('product-view', ['product' => $product->code,]))}}">&lt; Back</a>
            </li>
        </ul>
    </nav>
        <table>
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Name</th>
                    <th>Owner</th>
                </tr>
            </thead>

            <tbody>
                @foreach($shops as $shop)
            <tr>
                <th>
                    <a href="{{ route('shop-view', 
                    ['shop' => $shop->code,]) }}">
                    {{ $shop->code }}
                    </a>
                </th>
                <td>{{ $shop->name }}</td>
                <td>{{ $shop->owner }}</td>
                <td>
                    <a href="{{ route('product-remove-shop', [
                    'product' => $product->code,
                    'shop' => $shop->code,
                    ]) }}">Remove</a>
                </td>
            </tr>
                @endforeach
            </tbody>
        </table>
    </main>
@endsection

