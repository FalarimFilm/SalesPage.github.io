@extends('layouts.main')

@section('title', $title)

@section('content')
    <main>
        <form action="{{ route('category-add-product', ['category' => $category->code]) }}" method="get"
            class="search-form">
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

            <a href="{{ route('category-view-product', ['category' => $category->code]) }}">
                <button type="button" class="accent">Clear</button>
            </a>
            <div>{{ $products->withQueryString()->links() }}</div>
        </form>
        
        <form action="{{ route('category-add-product', [
            'category' => $category->code,
        ]) }}"
            method="post">
            @csrf
            <table>
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td>
                                <a
                                    href="{{ route('product-view', [
                                        'product' => $product->code,
                                    ]) }}">
                                    {{ $product->code }}
                                </a>
                            </td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->category->name }}</td>
                            <td>{{ $product->price }}</td>
                            <td>
                                <button type="submit" name="product" value="{{ $product->code }}">Add</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <br />
            <br />
    </main>
    <nav>
        <ul>
            <li><a href="{{ route('category-view-product', ['category' => $category->code]) }}">&lt; Back</a></li>
        </ul>
    </nav>

@endsection
