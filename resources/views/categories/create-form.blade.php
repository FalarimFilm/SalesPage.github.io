@extends('layouts.main')

@section('title',$title)

@section('content')
    <form action="{{ route('category-create') }}" method="post">
        @csrf

        <label>Code <input type="text" name="code" /></label><br />
        <label>Name <input type="text" name="name" /></label><br />
        <label> 
            Description
            <textarea name="description" cols="80" rows="10"></textarea>
        </label><br />
        
        <button type="submit">Create</button>
    </form>

@endsection