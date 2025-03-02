<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index() {
        return view('home');
    }

    public function show() {
        $products = Product::all();
        return view('product', compact('products'));
    }

    public function contact() {
        return view('contact');
    }
}
