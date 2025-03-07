<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Favorite;
use App\Models\Review;
use App\Models\Address;
use App\Http\Requests\AddressRequest;
use App\Http\Requests\Auth\LoginRequest;

class MyPageController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // ユーザーが取得できなかった場合、エラーページにリダイレクト
        if (!$user) {
            return redirect()->route('login')->with('error', 'ログインしてください');
        }

        $orders = Order::where('user_id', $user->id)->with('products')->get(); 
    $favorites = Favorite::where('user_id', $user->id)->with('product')->get();
    $reviews = Review::where('user_id', $user->id)->with('product')->get();
    $address = Address::where('user_id', $user->id)->first();

    return view('mypage', compact('user', 'orders', 'favorites', 'reviews', 'address'));
}

    // ユーザー情報の更新
    public function updateUser(LoginRequest $request, $id)
    {
        $user = Auth::user();

        if (!$user || $user->id != $id) {
            return redirect()->route('mypage')->with('error', '権限がありません');
        }

        // 更新処理
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('mypage')->with('success', 'ユーザー情報を更新しました');
    }

    // 🟢 配送先情報の更新
    public function updateAddress(AddressRequest $request, $id)
    {
        $user = Auth::user();

        if (!$user || $user->id != $id) {
            return redirect()->route('mypage')->with('error', '権限がありません');
        }

        // 既存の住所があるかチェック
        $address = Address::where('user_id', $user->id)->first();

        if ($address) {
            // 既存のデータを更新
            $address->update([
                'postal_code' => $request->postal_code,
                'address' => $request->address,
                'building' => $request->building,
            ]);
        } else {
            // 新規作成
            Address::create([
                'user_id' => $user->id,
                'postal_code' => $request->postal_code,
                'address' => $request->address,
                'building' => $request->building,
            ]);
        }

        return redirect()->route('mypage')->with('success', '配送先情報を更新しました');
    }
}
