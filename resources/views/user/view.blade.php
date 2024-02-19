@extends('layouts.main')

@section('title',$title)

@section('content')

<nav class="">
    <ul>
    @auth
        <li>
            <a href="{{session()->get('bookmark.user-view', route('user-list')) }}">&lt; Back</a>
        </li>
        <li>
            <a href="{{ route('user-update-form', ['user' => $user->email,]) }}">Update</a>
        </li>
        <li>
            <a href="{{ route('user-delete', ['user' => $user->email,]) }}">Delete</a>
        </li>
    @endauth
    </ul>
</nav>

<table>
    <thead>
        <tr>
            <th><b>E-mail::</b></th>
            <td><span>{{ $user->email }}</span></td>
        </tr>
        <tr>
            <th><b>Name::</b></th>
            <td><span>{{ $user->name }}</span></td>
        </tr>
        <tr>
            <th><b>Role::</b></th>
            <td><span>{{ $user->role}}</span></td>
        </tr>
    </thead>
</table>

@endsection
