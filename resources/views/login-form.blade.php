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
        <div class="main-login">
            <div class="left-login">
                <img src="{{asset('/images/catalogue.svg')}}" class="left-login-image" alt="Aatalogue">
            <main>
                <form action="{{ route('authenticate') }}" method="post">
                    @csrf
                    <div class="center">
                        <h1>Login</h1>
                        <form method="post">

                            <div class="txt_field">
                            <input type="text" name="email" required />
                            <span></span>
                            <label>E-mail</label>
                            </div>

                            <div class="txt_field">
                            <input type="password" name="password" required />
                            <span></span>
                            <label>Password</label>
                            </div>

                        </form>

                        <input type="submit" value="Login"><br />
                </form>
            </main>
        </div>
    </body>
</html>
