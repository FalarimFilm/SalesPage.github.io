@extends('layouts.main')

@section('title',$title)

@section('content')
<form action="{{ route('shop-update', ['shop' => $shop->code,]) }}" method="post">
    @csrf
    <label>Code
        <input type="text" name="code" value="{{ $shop->code }}" />
    </label>
    <br />
    <label>Name
        <input type="text" name="name" value="{{ $shop->name }}" />
    </label>
    <br />
    <label>Latitude
        <input type="number" step="any" name="latitude" value="{{ $shop->latitude }}" />
    </label>
    <br />
    <label>Longitude
        <input type="number" step="any" name="longitude" value="{{ $shop->longitude }}" />
    </label>
    <br />
    <label>
        Address
        <textarea name="address" cols="80" rows="10">{{ $shop->address }}</textarea>
    </label>
    <br />

    <button type="submit">Update</button>
</form>
@endsection
