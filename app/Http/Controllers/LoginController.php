<?php

namespace App\Http\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    function authenticate(Request $request) {
        $data = $request->getParsedBody();
        $credentials = [
        'email' => $data['email'],
        'password' => $data['password'],
        ];
        if (Auth::attempt($credentials)) {
            // regenerate the new session ID
            session()->regenerate();

            // redirect to the requested URL or
            // to route product-list if does not specify

            }
            return redirect()->intended(route('homePage'));
            return redirect()->back()->withErrors([
                'credentials' => 'The provided credentials do not match our records.',
                ]);
        }
    function loginForm() {
        return view('login-form');
    }
    function logout() {
        Auth::logout();

        session()->invalidate();

        // regenerate CSRF token
        session()->regenerateToken();

        return redirect()->route('login');
        }
}
