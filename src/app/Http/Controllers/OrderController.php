<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Cart;
use App\Models\Payment;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // 注文を作成する
    public function store(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        // フォームから送信された 商品ID、数量、支払い方法 を取得
        $productIds = $request->input('product_ids');
        $quantities = $request->input('quantities');
        $paymentMethod = $request->input('payment_method');

        // 商品が選択されていない場合、カートにリダイレクト
        if (empty($productIds) || empty($quantities)) {
            return redirect()->route('cart')->with('error', '購入する商品が選択されていません');
        }

        // 合計金額を計算する変数
        $totalAmount = 0;
        // 注文のIDを保存する配列
        $orderIds = [];

        // 注文を作成
        foreach ($productIds as $index => $productId) {
            // 指定された product_id の商品を取得
            $product = Product::find($productId);
            // 商品が存在しない場合はエラーを出す
            if (!$product) {
                return redirect()->route('cart')->with('error', '商品が見つかりませんでした');
            }

            // 注文データを作成
            $order = Order::create([
                'user_id' => $user->id,
                'status' => 'confirmed',
            ]);

            // 注文IDを保存
            $orderIds[] = $order->id;
            // 合計金額を計算
            $totalAmount += $product->price * $quantities[$index];
        }

        // カートの商品を注文に関連付け
        foreach ($orderIds as $orderId) {
            $order = Order::find($orderId);
            // カート内の商品を注文に紐付ける
            $carts = Cart::where('user_id', $user->id)->get();
            foreach ($carts as $cart) {
                // attach() で 注文IDごとに商品を結びつける（pivot テーブル(中間テーブル)を更新）
                $order->products()->attach($cart->product_id, ['quantity' => $cart->quantity]);
            }
        }

        // 支払い処理
        if ($paymentMethod === 'コンビニ払い') {
            // コンビニ払いの場合、支払いIDを作成（uniqid() で一意のIDを生成）
            $paymentIntentId = uniqid('conveni_');

            // 支払いデータ保存
            Payment::create([
                'user_id' => $user->id,
                'order_id' => $orderIds[0],
                'payment_intent_id' => $paymentIntentId,
                'amount' => $totalAmount,
                'currency' => 'jpy',
                'status' => 'pending',
                'payment_method' => 'コンビニ払い',
            ]);

            $order = Order::create([
                'user_id' => $user->id,
                'status' => 'shipped',
            ]);

            // カートを空にする
            Cart::where('user_id', $user->id)->delete();

            // コンビニ払いのリダイレクト
            return redirect()->route('thanks.buy')->with('paymentMethod', $paymentMethod);
        } else {
            // クレジットカード払いの場合は支払いページへ移動
            return redirect()->route('payment', ['order_id' => $orderIds[0]]);
        }
    }
}
