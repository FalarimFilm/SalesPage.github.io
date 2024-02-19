@extends('layouts.main')

@section('title',$title)

@section('content')

<form action="{{ route('user-update', ['user' => $user->email,]) }}" method="post">
@csrf

    <label>E-mail::
        <input type="text" name="email" value="{{old('email',$user->email)}}" />
    </label><br />

    <label>Name::
        <input type="text" name="name" value="{{old('name', $user->name)}}" />
    </label><br />

    <label>Password::
        <input type="text" name="password"
        placeholder="Leave blank if you don't need to edit" />
    </label><br />

    <label>Role::</label>
    <select id ='inp-user' name='role' required>
            @foreach($roles as $role)
            <option value="{{ $role }}"
                @selected( old('role', $user->role) === "$role")>
                [{{ $role }}]
            </option>
            @endforeach
    </select>
    <br />

    <button type="submit" class="updateB">Update</button>
</form>
@endsection
