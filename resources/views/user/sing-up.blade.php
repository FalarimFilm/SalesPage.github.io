<!DOCTYPE html>
<html lang="en">
    <head></head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>My-DB - @yield('title')</title>
        <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}" />
    </head>
<body>
    <div class="main-sign">
        <div class="left-sign">
            <img src="{{asset('/images/catalogue.svg')}}" class="left-sign-image" alt="Aatalogue">
            <main>
                <form action="{{ route('user-create') }}" method="post">
                    @csrf
                    <div class="center">
                        <h1>Sign In</h1>
                        <form method="post">

                            <div class="txt_field">
                            <input type="text" name="email" value="{{old('email')}}" required/>
                            <span></span>
                            <label>Email</label>
                            </div>

                            <div class="txt_field">
                            <input type="text" name="name" value="{{old('name')}}" required/>
                            <span></span>
                            <label>Name</label>
                            </div>

                            <div class="txt_field">
                            <input type="text" name="password" value="{{old('password')}}" required/>
                            <span></span>
                            <label>Password</label>
                            </div>


                            <label>Role:</label>
                            <select id='inp-user' name='role'>
                                <option>--Please select--</option>
                                @if(auth()->check() && auth()->user()->role == 'ADMIN')
                                    <!-- Admin can select any role -->
                                    <option value="USER" {{ old('role') == 'USER' ? 'selected' : '' }}>USER</option>
                                    <option value="ADMIN" {{ old('role') == 'ADMIN' ? 'selected' : '' }}>ADMIN</option>
                                @endif
                            </select>

                                <br />
                            <span></span>
                            </div>
                            <button type="submit" class="submit">Create</button>
                        </form>
                    </div>
                </form>
            </main>
        </div>
    </div>
</body>
</html>
