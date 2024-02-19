@extends('layouts.main')

@section('title', $title)

@section('content')
    <main></main>
        <form action="{{ route('product-list') }}" method="get" class="search-form">
            <label>
                Search
                <input type="text" name="term" value="{{ $search['term'] }}" />
            </label>
            <br />
            <button type="submit" class="primary">Search</button>
            <a href="{{ route('product-list') }}">
                <button type="button" class="accent">Clear</button>
            </a>
        </form>
        <nav class="nav-view">
            <ul>
            @auth
            @if(auth()->user()->role == 'ADMIN')
            <li>
            <a href="{{ route('product-create-form') }}">New Product</a>
            </li>
            @endif
            @endauth
            </ul>
            <div>{{ $products->withQueryString()->links() }}</div>
        </nav>
        <div class="productList">
        <table >
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
                </tr>
                @endforeach
            </tbody>
        </table>
        </div>
        <br />
        <br />

    </main>

@endsection

