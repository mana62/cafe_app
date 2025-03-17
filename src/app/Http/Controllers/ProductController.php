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
        $products = Product::paginate(10);
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

        // 現在のユーザーが使ったことのある支払い方法 だけ取得
        $payment_methods = Payment::whereHas('order', function ($query) {
            $query->where('user_id', Auth::id());
        })->get();

        // Favorite テーブルから 現在のユーザーのお気に入りの product_id だけ 取得
        // pluck() は、コレクションやクエリの結果から特定のカラムだけを抜き出す ためのメソッド
        $favorites = $user ? Favorite::where('user_id', $user->id)->pluck('product_id')->toArray() : [];

        return view('product_detail', compact('product', 'payment_methods', 'favorites'));
    }

    public function search(Request $request)
    {
        $keyword = trim($request->input('product'));
        // 入力された検索キーワードを取得し、不要な空白を削除

        // キーワードが空ならエラーメッセージを表示してリダイレクト
        if (empty($keyword)) {
            return redirect()->route('product')->with('error', '検索ワードを入力してください');
        }

        // Product テーブルから、name に keyword が含まれる商品を取得
        // LIKE '%keyword%' は 部分一致検索
        $products = Product::where('name', 'LIKE', "%{$keyword}%")->get();

        return view('product', ['keyword' => $keyword, 'products' => $products]);
    }
}
