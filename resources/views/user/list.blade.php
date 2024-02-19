@extends('layouts.main')

@section('title',$title)

@section('content')

<form action="{{ route('user-list') }}" method="get" class="search-form">
    <label class="SF-body"><a class="SF-head">Search :: </a>
        <input type="text" name="term" value="{{ $search['term'] }}" />
    </label><br />

    <button type="submit" class="primary">Search</button>
    <a href="{{ route('user-list') }}">
        <button type="button" class="accent">Clear</button>
    </a>
</form>

<nav>
    <ul>
        @can('create', \App\Models\User::class)
            <li>
                <a href="{{ route('user-create-form') }}">New User</a>
            </li>
        @endcan
    </ul>
</nav>

<div>{{ $users->withQueryString()->links() }}</div>
<table>
    <thead>
        <tr>
            <th>E-mail</th>
            <th>Name</th>
            <th>Role</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
        <tr>
            <td>
                <a href="{{ route('user-view', [
                    'user' => $user->email,]) }}">
                    {{ $user['email'] }}
                </a>
            </td>
            <td>{{ $user['name'] }}</td>
            <td>{{ $user->role}}</td>
        </tr>
        @endforeach
    </tbody>
</table>
<a href="{{ route('user-create') }}" class="btn btn-primary">Create New Member</a>
@endsection
