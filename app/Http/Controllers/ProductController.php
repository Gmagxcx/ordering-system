<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function showForm()
    {
        return view('profile');
    }

    public function submitForm(Request $request){

        $request->validate([
            'Firstname' => 'required',
            'Lastname' => 'required',
            'Email' => 'required|email',
            'Password' => 'required',
            'ConfirmPassword' => 'required',
        ]);

        $data = [
            'Firstname' => $request->input('Firstname'),
            'Lastname' => $request->input('Lastname'),
            'Email' => $request->input('Email'),
            'Password' => $request->input('Password'),
            'ConfirmPassword' => $request->input('ConfirmPassword'),
        ];
        return view('loginForm', $data);
    }

}
