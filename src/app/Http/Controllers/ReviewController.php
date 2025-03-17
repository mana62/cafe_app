<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ReviewRequest;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    //レビューを保存
    public function store(ReviewRequest $request, $id)
    {
        // ログイン済みかチェックし、ログインしていなければログインページに移動
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Reviewデータベースに保存
        Review::create([
            'product_id' => $id,
            'user_id' => auth()->id(),
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'レビューを投稿しました');
    }
}
