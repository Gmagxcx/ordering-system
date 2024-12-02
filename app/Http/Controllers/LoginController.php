<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'The provided credentials do not match our records.']);
        }

        // Inside your LoginController after successful login:

        if (Hash::check($request->password, $user->password)) {
            Auth::login($user);
            Session::regenerate();

            Session::put('first_name', $user->first_name);
            Session::put('access', $user->access);

            if ($user->access === 'admin' || $user->access === 'employee') {
                return redirect()->route('home');  // Redirect admins and employees to home page
            } else {
                return redirect()->route('home');  // Redirect regular users to home page as well
            }
        }

        return back()->withErrors(['email' => 'The provided credentials do not match our records.']);
    }

    public function logout(Request $request)
    {
        // Clear the user's cart from the session
        $request->session()->forget('cart');

        // Debugging: Check if cart is still in session
        if ($request->session()->has('cart')) {
            dd('Cart still in session!');
        }

        // Log out the user
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('message', 'You have been logged out successfully.');
    }


}
