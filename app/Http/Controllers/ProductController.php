<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of all products.
     */
    public function index()
    {
        // Fetch all products
        $products = Product::all();

        // Return products view with the products data
        return view('products', compact('products'));
    }


    public function showForm()
    {
        return view('profile');
    }


    public function submitForm(Request $request)
    {
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
