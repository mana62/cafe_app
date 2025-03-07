<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Favorite;
use App\Models\Product;

class FavoriteController extends Controller
{
    public function toggle(Request $request, Product $product)
    {
        // ①ユーザーを取得
        $user = Auth::user();

        // ②すでにお気に入りに入れているか確認
        $favorite = Favorite::where('user_id', $user->id)->where('product_id', $product->id)->first();

        if ($favorite) {
            // ③すでにお気に入りなら削除
            $favorite->delete();
            $isLiked = false;
        } else {

            // ④新しくデータベースに保存
            Favorite::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
            ]);
            $isLiked = true;
        }

        // ⑤ジェーソンで返す
        return response()->json([
            'liked' => $isLiked,
            'likesCount' => $product->favoritedBy()->count(),
        ]);
    }
}

