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
// DB → トランザクション処理（データの一括処理）に使用
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    // チェックアウトページを表示する
    public function index()
    {
        // ログインしていなければログインページへ
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // 現在のユーザーのカート情報を取得し、with('product') で、関連する商品の情報も取得（リレーション）
        $carts = Cart::where('user_id', Auth::id())->with('product')->get();
        // payments テーブルから、支払い方法を取得（distinct()で重複を除外）
        $payment_methods = Payment::select('payment_method')->distinct()->get();

        return view('checkout', compact('payment_methods', 'carts'));
    }

    public function stripe(Request $request, $order_id)
    {
        // order_id を使って注文データを取得し、関連する products（商品情報）も一緒に取得
        $order = Order::with('products')->findOrFail($order_id);

        // order に紐づく商品の合計金額を計算
        // * 100 しているのは、Stripeでは円単位ではなく「最小通貨単位（＝1円未満）」で金額を扱うため
        // max(..., 50) により、最低50円を設定
        $amount = max($order->products->sum(fn($product) => $product->price * $product->pivot->quantity) * 100, 50);

        // .env ファイルにある STRIPE_SECRET を使って、StripeのAPIキーをセット
        Stripe::setApiKey(env('STRIPE_SECRET'));

        // PaymentIntentの支払いを作成
        $paymentIntent = PaymentIntent::create([
            'amount' => $amount,
            'currency' => 'jpy',
            'metadata' => [
                'order_id' => $order_id,
                'user_id' => Auth::id(),
            ],
        ]);

        // payment_stripe というビュー（決済画面）に order（注文情報）と client_secret（Stripeの決済トークン）を渡して表示
        return view('payment_stripe', [
            'order' => $order,
            'client_secret' => $paymentIntent->client_secret,
        ]);
    }

    public function Payment(PaymentRequest $request, $order_id)
    {
        // ログインユーザーを表示
        $user = Auth::user();

        // Orderテーブルから、$order_idを取得しwithでproductsもリレーションで取得
        $order = Order::with('products')->findOrFail($order_id);

        // 注文に商品が含まれていない場合、エラーを返す
        if ($order->products->isEmpty()) {
            return response()->json(['succeeded' => false, 'message' => '商品情報が正しくありません'], 400);
        }

        // 支払い対象のアイテムが選択されていなければエラーを返す
        $selectedItems = $request->input('selected_items');
        if (empty($selectedItems)) {
            return response()->json(['succeeded' => false, 'message' => 'アイテムを選択してください'], 400);
        }

        // 選択された商品の合計金額を計算
        // sum() は 合計を計算 するためのメソッド
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

            $order = Order::create([
                'user_id' => $user->id,
                'status' => 'shipped',
            ]);

            // 支払い成功・保留の場合はカートのデータを削除
            if ($paymentStatus === 'succeeded' || $paymentStatus === 'pending') {
                Cart::where('user_id', Auth::id())->delete();
            }

            $request->session()->flash('paymentMethod', $request->payment_method);

            // 処理が成功したらデータを確定（commit） し、完了画面へリダイレクト
            DB::commit();
            return response()->json(['succeeded' => true, 'redirect_url' => route('thanks.buy')]);
        } catch (\Exception $e) {

            // エラーが発生した場合は処理を取り消す（rollback）
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