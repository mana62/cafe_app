<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;

class CartController extends Controller
{
    //カートの一覧を表示
    public function index()
    {
        // auth()->id() で、現在ログインしているユーザーのIDを取得
        // ログインユーザーのカートデータを取得
        $carts = Cart::where('user_id', auth()->id())->get();
        // 取得したカートデータを cart というビュー（画面）に渡す
        return view('cart', compact('carts'));
    }

    public function add(Request $request, $id)
    {
        // 追加する商品のidをProductデータベースから探す
        Product::find($id);

        // auth()->check() で、ログインしているか確認しログインしていなければログイン画面へ
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // ログインユーザーのIDを取得
        $userId = auth()->id();

        // 既にカートに商品があるかチェック
        $cartItem = Cart::where('user_id', $userId)->where('product_id', $id)->first();
        if ($cartItem) {
            // 既にカートにある場合は個数を増やして保存
            $cartItem->quantity += $request->quantity;
            $cartItem->save();
        } else {
            // ない場合、新しいカートデータを作成して保存
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
        // ログインしていなければログイン画面へリダイレクト
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // ログインユーザーのカートデータを取得
        $carts = Cart::where('user_id', auth()->id())->with('product')->get();

        return view('checkout', compact('carts'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        try {
            // Cartデータベースから$idを取得
            $cart = Cart::findOrFail($id);
            // 数量を変更して$cart->quantityに代入
            $cart->quantity = $request->quantity;
            $cart->save();
            return redirect()->route('cart')->with('success', '個数を変更しました');
        } catch (\Exception $e) {
            return redirect()->route('cart')->with('error', '個数の変更に失敗しました');
        }
    }

    public function destroy($id)
    {
        // Cartデータベースから$idを取得して削除
        Cart::findOrFail($id)->delete();
        return redirect()->route('cart')->with('success', '削除しました');
    }
}
