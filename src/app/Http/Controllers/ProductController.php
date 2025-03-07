<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Payment;
use App\Models\Favorite;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function show()
    {
        $products = Product::all();
        return view('product', compact('products'));
    }

    public function indexDetail($id)
    {
        $user = Auth::user();
        $product = Product::with('reviews')->findOrFail($id);

        if (!$product) {
            return redirect()->route('products.index')->with('error', '商品が見つかりませんでした');
        }

        $payment_methods = Payment::all();
        $payment_methods = Payment::whereHas('order', function ($query) {
            $query->where('user_id', Auth::id());
        })->get();

        $favorites = $user ? Favorite::where('user_id', $user->id)->pluck('product_id')->toArray() : [];

        return view('product_detail', compact('product', 'payment_methods', 'favorites'));
    }

    public function search(Request $request)
    {
        $keyword = trim($request->input('product'));

        if (empty($keyword)) {
            return redirect()->route('product')->with('error', '検索ワードを入力してください');
        }

        $products = Product::where('name', 'LIKE', "%{$keyword}%")->get();

        return view('product', ['keyword' => $keyword, 'products' => $products]);
    }
}
