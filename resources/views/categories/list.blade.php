@extends('layouts.main')

@section('title', $title)

@section('content')
    <main>
    @auth
    <form action="{{ route('category-list') }}" method="get" class="search-form">
        <label>
            Search
            <input type="text" name="term" value="{{ $search['term'] }}" />
        </label>
        <br />
        <button type="submit" class="primary">Search</button>
            <a href="{{ route('category-list') }}">
                <button type="button" class="accent">Clear</button>
            </a>
    </form>

    <div>{{ $categories->withQueryString()->links() }}</div>
    <nav>
            <ul>
            @auth
            @if(auth()->user()->role == 'ADMIN')
                <li>
                    <a href="{{ route('category-create-form') }}">New Category</a>
                </li>
            @endif
            @endauth
            </ul>
        </nav>

        <div>{{ $categories->withQueryString()->links() }}</div>

        <div class="categoryList">
        <table>
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Name</th>
                    <th>No. of Products</th>
                </tr>
            </thead>

            <tbody>
                @foreach($categories as $category)
                <tr>
                    <td>
                        <a href="{{ route('category-view-product', ['category' => $category->code,]) }}"> {{ $category->code }}
                        </a>
                    </td>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->products_count }}</td>
                    <td><a href="{{ route('category-view',
                    ['category' => $category->code,]) }}">Detial</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
        </div>
        <br />
        <br />
        @endauth
    </main>
@endsection

