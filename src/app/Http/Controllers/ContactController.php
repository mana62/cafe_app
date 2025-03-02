<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index() {
        return view('contact');
    }

    public function create(Request $request) {
        $contact = $request->all();
        Contact::create($contact);
        return view('contact');
    }

    public function sore(Request $request) {
        $contact = $request->all();
        Contact::update($contact);
        return view('contact');
    } 
}
