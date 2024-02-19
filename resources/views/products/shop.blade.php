@extends('layouts.main')

@section('title', $title)

@section('content')
    <main>
    <nav>
        <ul>
            @auth
            @if(auth()->user()->role == 'ADMIN')
            <li>
                <a href="{{ route('shop-view-product', ['shop' => $shop->code,]) }}">Show Product</a>
            </li>
            <li>
                <a href="{{ route('shop-update-form', ['shop' => $shop->code,]) }}">Update</a>
            </li>
            <li>
                <a href="{{ route('shop-delete', ['shop' => $shop->code,]) }}">Delete</a>
            </li>
            @endif
            @endauth
            <ul>
                <a href="{{session()->get('shops-view', route('shop-list', ['shop' => $shop->code,]))}}">&lt; Back</a>
            </ul>
        </ul>

    </nav>

    <div class="shopview">
        <b>Code ::</b>
        <span>{{ $shop->code }}</span>
        <br />
        <b>Name ::</b>
        <span>{{ $shop->name }}</span>
        <br />
        <b>Owner ::</b>
        <span>{{ $shop->owner }}</span>
        <br />
        <b>Location ::</b>
        <span>{{ $shop->latitude }} {{ $shop->longitude }}</span>
        <br />
        <b>Address ::</b>
        <span>{{ $shop->address }}</span>
        <br />
        <br />

    </div>
    </main>

@endsection
