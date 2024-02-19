@extends('layouts.main')

@section('title',$title)

@section('content')
<form action="{{ route('product-update', ['product' => $product->code,]) }}" method="post">
    @csrf

    <label>Code
        <input type="text" name="code" value="{{ $product->code }}" />
    </label>
    <br />
    <label>Name
        <input type="text" name="name" value="{{ $product->name }}" />
    </label>
    <br />
    <label>Category </label>
    <select name="category" required>
        @foreach($categories as $category)
        <option value="{{ $category->code }}" @selected($product->category->code === $category->code)
            >[{{ $category->code }}] {{ $category->name }}</option>
        @endforeach
    </select>
    <br />
    <label>Price
        <input type="number" step="any" name="price" value="{{ $product->price }}" />
    </label>
    <br />
    <label>
        Description
        <textarea name="description" cols="80" rows="10">{{ $product->description }}</textarea>
    </label>
    <br />

    <button type="submit">Update</button>
</form>
@endsection