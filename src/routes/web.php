<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\MyPageController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

// 認証ページを表示
Route::get('/auth', function () {
    return view('auth.auth');
})->name('auth');

// 新規登録
Route::post('/register', [RegisteredUserController::class, 'store'])->name('register');

// ログイン
Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login');

// ログアウト
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// マイページ（認証＆メール認証済みユーザー）
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/mypage', [MyPageController::class, 'index'])->name('mypage');
    Route::put('/mypage/{id}/user/update', [MyPageController::class, 'updateUser'])->name('user.update');
    Route::put('/mypage/{id}/address/update', [MyPageController::class, 'updateAddress'])->name('address.update');
});

// メール認証関連
Route::middleware('auth')->group(function () {
    Route::get('/email/verify', function () {
        return view('auth.verify-email');
    })->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
        return redirect('/mypage');
    })->middleware(['signed'])->name('verification.verify');

    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('message', '確認メールを再送しました');
    })->name('verification.send');
});

// 商品関連
Route::get('/home', [ProductController::class, 'index'])->name('home');
Route::get('/product', [ProductController::class, 'show'])->name('product');
Route::get('/product/{id}/detail', [ProductController::class, 'indexDetail'])->name('product.detail');
Route::get('/product/search', [ProductController::class, 'search'])->name('product.search');

// カート＆チェックアウト
Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::post('/order', [OrderController::class, 'store'])->name('order.store');
Route::put( '/cart/{id}/update', [CartController::class, 'update'])->name('cart.update');
Route::delete( '/cart/{id}/delete', [CartController::class, 'destroy'])->name('cart.delete');

Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
Route::get('/payment/{order_id}', [CheckoutController::class, 'stripe'])->name('payment.get');
Route::post('/payment/{order_id}', [CheckoutController::class, 'Payment'])->name('payment');
Route::get('/thanks-buy', [CheckoutController::class, 'thanksBuy'])->name('thanks.buy');

// レビューpayment
Route::post('/reviews/store/{id}', [ReviewController::class, 'store'])->name('reviews.store');

// お気に入り
Route::post('/favorites/{product}', [FavoriteController::class, 'toggle'])->name('favorites.toggle');

// お問合せ
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact/confirm', [ContactController::class, 'confirm'])->name('contact.confirm');
Route::post('/contact/store', [ContactController::class, 'store'])->name('contact.store');
Route::get('/contact/thanks', [ContactController::class, 'thanks'])->name('contact.thanks');

require __DIR__.'/auth.php';
