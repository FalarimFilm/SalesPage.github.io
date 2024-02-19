@extends('layouts.main')

@section('title', $title)

@section('content')
    <main>
    <form action="{{ route('shop-list') }}" method="get" class="search-form">
        <label>
            Search
            <input type="text" name="term" value="{{ $search['term'] }}" />
        </label>
        <br />
        <button type="submit" class="primary">Search</button>
            <a href="{{ route('shop-list') }}">
                <button type="button" class="accent">Clear</button>
            </a>
    </form>
    <div>{{ $shops->withQueryString()->links() }}</div>
    <nav>
        @auth
        @if(auth()->user()->role == 'ADMIN')
        <ul>
        <li>
        <a href="{{ route('shop-create-form') }}">New shop</a>
        </li>
        </ul>
        </nav>
        @endif
        @endauth

        <div class="shopList">
        <table>
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Name</th>
                    <th>No. of Products</th>
                </tr>
            </thead>

            <tbody>
                @foreach($shops as $shop)
                <tr>
                    <td>
                        <a href="{{ route('shop-view', [
                        'shop' => $shop->code,])
                        }}"> {{ $shop->code }}
                        </a>
                    </td>
                    <td>{{ $shop->name }}</td>
                    <td>{{ $shop->products_count }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        </div>
        <br />
        <br />
    </main>

@endsection

