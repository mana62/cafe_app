<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use App\Http\Requests\ContactRequest;

class ContactController extends Controller
{
    // 問い合わせページを表示
    public function index()
    {
        return view('contact');
    }

    public function confirm(ContactRequest $request)
    {
        // 問い合わせページから'name', 'email', 'content'部分を取得
        $contact = $request->only(['name', 'email', 'content']);

        // 問い合わせ確認ページに移動
        return view('contact_confirm', compact('contact'));
    }

    public function store(ContactRequest $request)
    {
        // Contactデータベースに保存
        Contact::create([
            'name' => $request->name,
            'email'=> $request->email,
            'content' => $request->content,
        ]);
        // contact.thanksのページに移動
        return redirect()->route('contact.thanks');
    }

     // contact.thanksのページを表示
    public function thanks()
    {
        return view('contact_thanks');
    }
}
