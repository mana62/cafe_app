<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use App\Http\Requests\ContactRequest;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact');
    }

    public function confirm(ContactRequest $request)
    {
        $contact = $request->only(['name', 'email', 'content']);
        return view('contact_confirm', compact('contact'));
    }

    public function store(ContactRequest $request)
    {
        Contact::create([
            'name' => $request->name,
            'email'=> $request->email,
            'content' => $request->content,
        ]);
        return redirect()->route('contact.thanks');
    }

    public function thanks()
    {
        return view('contact_thanks');
    }
}
