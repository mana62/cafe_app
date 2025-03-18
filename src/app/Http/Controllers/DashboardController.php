<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;

class DashboardController extends Controller
{
    public function showDashboard()
    {
        $users = User::paginate(10);
        $products = Product::paginate(10);
        $orders = Order::with('user', 'products')->paginate(10);

        return view('admin.dashboard', compact('users', 'products', 'orders'));
    }

    public function deleteUser($id)
    {
        User::findOrFail($id)->delete();
        return redirect()->route('admin.dashboard')->with('message', 'ユーザーを削除しました');
    }

    public function updateProduct(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
        ]);

        $product->update([
            'name' => $request->name,
            'price' => $request->price,
        ]);

        return redirect()->back()->with('message', '商品情報を更新しました');
    }

    public function storeProduct(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // 画像保存
        $imagePath = $request->file('image')->store('images', 'public');

        // 商品作成
        Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'image_path' => $imagePath,
        ]);

        return redirect()->route('admin.dashboard')->with('message', '商品を追加しました');
    }


    public function deleteProduct($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('admin.dashboard')->with('message', '商品を削除しました');
    }

    public function showOrders()
    {
        $orders = Order::with('user', 'products')->paginate(10);
        return view('admin.orders', compact('orders'));
    }
}
