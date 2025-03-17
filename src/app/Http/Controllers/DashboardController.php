<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;

class DashboardController extends Controller
{
    public function showUsers() {
        $users = User::all();
        return view('admin.users', compact('users'));
    }

    public function deleteUser($id) {
        User::findOrFail($id)->delete();
        return redirect()->route('admin.users')->with('message', 'ユーザーを削除しました');
    }

    public function showProducts() {
        $products = Product::all();
        return view('admin.products', compact('products'));
    }

    public function updateProduct($id) {
        $product = Product::findOrFail($id);
        $product->update();
    return redirect()->back()->with('message', '変更を保存しました');
    }

    public function storeProduct(Request $request) {
        Product::create($request->all());
    return redirect()->back()->with('message', '商品を追加しました');
    }

    public function deleteProduct($id) {
        Product::findOrFail($id)->delete();
        return redirect()->route('admin.products')->with('message', '削除しました');
    }

    public function showOrders() {
        $orders = Order::with('user', 'products')->paginate(10);
        return view('admin.orders', compact('orders'));
    }
}
