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
    public function store(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'ログインしてください');
        }

        $productIds = $request->input('product_ids');
        $quantities = $request->input('quantities');
        $paymentMethod = $request->input('payment_method');

        if (empty($productIds) || empty($quantities)) {
            return redirect()->route('cart')->with('error', '購入する商品が選択されていません');
        }

        $totalAmount = 0;
        $orderIds = [];

        // 注文を作成
        foreach ($productIds as $index => $productId) {
            $product = Product::find($productId);
            if (!$product) {
                return redirect()->route('cart')->with('error', '商品が見つかりませんでした');
            }

            $order = Order::create([
                'user_id' => $user->id,
                'status' => 'pending',
            ]);

            $orderIds[] = $order->id;
            $totalAmount += $product->price * $quantities[$index];
        }

        // カートの商品を注文に関連付け
        foreach ($orderIds as $orderId) {
            $order = Order::find($orderId);
            $carts = Cart::where('user_id', $user->id)->get();
            foreach ($carts as $cart) {
                $order->products()->attach($cart->product_id, ['quantity' => $cart->quantity]);
            }
        }

        // 支払い処理
        if ($paymentMethod === 'コンビニ払い') {
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

            Cart::where('user_id', $user->id)->delete();

            // コンビニ払いのリダイレクト
            return redirect()->route('thanks.buy')->with('paymentMethod', $paymentMethod);
        } else {
            return redirect()->route('payment', ['order_id' => $orderIds[0]]);
        }
    }
}
