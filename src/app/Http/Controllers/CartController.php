<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use Illuminate\Support\Facades\Session;
use Illuminate\View\Component;

class CartController extends Controller
{
    public function index()
    {
        $carts = Cart::where('user_id', auth()->id())->get();
        return view('cart', compact('carts'));
    }
    public function add(Request $request, $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return redirect()->route('product')->with('error', '商品が見つかりませんでした');
        }

        // 🟢 ユーザーがログインしているか確認
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'カートに追加するにはログインしてください');
        }

        $userId = auth()->id();

        // 🟢 すでにカートにあるかチェック
        $cartItem = Cart::where('user_id', $userId)->where('product_id', $id)->first();
        if ($cartItem) {
            // 🟢 既にカートにある場合は数量を増やす
            $cartItem->quantity += $request->quantity;
            $cartItem->save();
        } else {
            // 🟢 カートに新しく追加
            Cart::create([
                'user_id' => $userId,
                'product_id' => $id,
                'quantity' => $request->quantity,
            ]);
        }
        return redirect()->route('product.detail', ['id' => $id])->with('success', 'カートに追加しました');
    }

    public function checkout()
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', '購入するにはログインしてください');
        }

        $carts = Cart::where('user_id', auth()->id())->with('product')->get();

        if ($carts->isEmpty()) {
            return redirect()->route('cart')->with('error', 'カートが空です');
        }

        return view('checkout', compact('carts'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        try {
        $cart = Cart::findOrFail($id);
        $cart->quantity = $request->quantity;
        $cart->save();
        return redirect()->route('cart')->with('success', '個数を変更しました');
    } catch (\Exception $e) {
        return redirect()->route('cart')->with('error', '個数の変更に失敗しました');
    }
}

    public function destroy($id)
    {
        Cart::findOrFail($id)->delete();
        return redirect()->route('cart')->with('success', '削除しました');
    }
}
