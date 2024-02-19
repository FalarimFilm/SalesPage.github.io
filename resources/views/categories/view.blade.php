@extends('layouts.main')

@section('title', $title)

@section('content')
    <main>


    <nav>

        <ul>
            <li>
                <a href="{{ route('category-view-product', ['category' => $category->code,]) }}">Show Product</a>
            </li>
            @auth
            @if(auth()->user()->role == 'ADMIN')
            <li>
                <a href="{{ route('category-update-form', ['category' => $category->code,]) }}">Update</a>
            </li>
            <li>
                <a href="{{ route('category-delete', ['category' => $category->code,]) }}">Delete</a>
            </li>
            @endif
            @endauth
        </ul>
        <ul>
            <li>
                <a href="{{session()->get('category-view',  route('category-list', ['category' => $category->code,]))}}">&lt; Back</a>
            </li>
        </ul>
    </nav>

    <div class="shopview">
        <b>Code ::</b>
        <span>{{ $category->code }}</span>
        <br />
        <b>Name ::</b>
        <span>{{ $category->name }}</span>
        <br />
        <b>Description ::</b>
        <span>{{ $category->description }}</span>
        <br />
        <br />

    </div>
    </main>

@endsection
