<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My-db - @yield('title')</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}" />
</head>
<body>
    <header>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <div class="container bg">

    <div class="menu">

        <nav>
            <ul>
                <li>
                    <a href="{{ route('homePage') }}">Home</a>
                </li>
                @auth
                @if(auth()->user()->role == 'ADMIN' || 'User')
                <li>
                    <a href="{{ route('product-list') }}">Product</a>
                </li>
                <li>
                    <a href="{{ route('shop-list') }}">Shop</a>
                </li>
                <li>
                    <a href="{{ route('category-list') }}">Category</a>
                </li>
                <li>
                    <a href="{{ route('cart-list') }}">Cart</a>
                </li>
                @endif
                @if(auth()->user()->role == 'ADMIN')
                <li>
                    <a href="{{ route('user-list') }}">User</a>
                </li>
                @endif
                <li>
                    <a href="{{ route('logout') }}">Logout</a>
                </li>
                <li>
                    <nav class="user-panel">
                    {{ \Auth::user()->name }}
                    </nav>
                </li>
                @endauth
                @guest
                <li>
                    <a href="{{ route('login') }}">Login</a>
                </li>
                @endguest
            </ul>
        </nav>
    </header>
    @if(session()->has('status'))
    <div class="status">
    <span class="info">{{ session()->get('status') }}</span>
    </div>
    @endif

                <div class="content">
                    @yield('content')
                </div>
                <footer class="footer">
                    &#xA9; Siraphob Inthajak 642110204
                </footer>

    </body>
    </html>
