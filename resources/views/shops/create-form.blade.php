@extends('layouts.main')

@section('title',$title)

@section('content')
    <form action="{{ route('shop-create') }}" method="post">
        @csrf

        <label>Code <input type="text" name="code" /></label><br />
        <label>Name <input type="text" name="name" /></label><br />
        <label>Latitude <input type="number" step="any" name="latitude" /></label><br />
        <label>Longitude <input type="number" step="any"name="longitude" /></label><br />
        <label>
            Address
            <textarea name="address" cols="80" rows="10"></textarea>
        </label><br />

        <button type="submit">Create</button>
    </form>

@endsection