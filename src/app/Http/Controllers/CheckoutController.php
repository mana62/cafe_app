<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Payment;
use App\Models\Order;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use App\Http\Requests\PaymentRequest;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'ログインしてください');
        }

        $carts = Cart::where('user_id', Auth::id())->with('product')->get();
        $payment_methods = Payment::select('payment_method')->distinct()->get();

        return view('checkout', compact('payment_methods', 'carts'));
    }

    public function stripe(Request $request, $order_id)
    {
        $order = Order::with('products')->findOrFail($order_id);

        $amount = max($order->products->sum(fn($product) => $product->price * $product->pivot->quantity) * 100, 50);
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $paymentIntent = PaymentIntent::create([
            'amount' => $amount,
            'currency' => 'jpy',
            'metadata' => [
                'order_id' => $order_id,
                'user_id' => Auth::id(),
            ],
        ]);

        return view('payment_stripe', [
            'order' => $order,
            'client_secret' => $paymentIntent->client_secret,
        ]);
    }

    public function Payment(PaymentRequest $request, $order_id)
    {
        $user = Auth::user();
        $order = Order::with('products')->findOrFail($order_id);

        if ($order->products->isEmpty()) {
            return response()->json(['succeeded' => false, 'message' => '商品情報が正しくありません'], 400);
        }

        $selectedItems = $request->input('selected_items');
        if (empty($selectedItems)) {
            return response()->json(['succeeded' => false, 'message' => 'アイテムを選択してください'], 400);
        }

        $totalAmount = $order->products->whereIn('id', $selectedItems)->sum(fn($product) => $product->price * $product->pivot->quantity);

        $paymentStatus = ($request->payment_method === 'クレジットカード') ? 'succeeded' : 'pending';
        $paymentIntentId = $request->input('payment_intent_id');

        if ($request->payment_method === 'クレジットカード' && !$paymentIntentId) {
            return response()->json(['succeeded' => false, 'message' => '支払い処理に失敗しました'], 400);
        } elseif ($request->payment_method === 'コンビニ払い') {
            $paymentIntentId = uniqid('conveni_');
        }

        DB::beginTransaction();
        try {
            Payment::create([
                'user_id' => $user->id,
                'order_id' => $order->id,
                'payment_intent_id' => $paymentIntentId,
                'amount' => $totalAmount,
                'currency' => 'jpy',
                'status' => $paymentStatus,
                'payment_method' => $request->payment_method,
            ]);

            if ($paymentStatus === 'succeeded' || $paymentStatus === 'pending') {
                Cart::where('user_id', Auth::id())->delete();
            }

            $request->session()->flash('paymentMethod', $request->payment_method);
            DB::commit();
            return response()->json(['succeeded' => true, 'redirect_url' => route('thanks.buy')]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'succeeded' => false,
                'message' => '支払い処理に失敗しました',
                'error_details' => $e->getMessage(),
            ], 500);
        }
    }

    public function thanksBuy()
    {
        return view('thanks_buy');
    }
}