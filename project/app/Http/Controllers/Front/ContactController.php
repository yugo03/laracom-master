<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Mail\InquiryMailable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index()
    {
        return view('front.contact');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:150',
            'iam' => 'required|string|max:50',
            'message' => 'required|string|max:2000',
        ]);

        Mail::to(config('shop.email'))->send(new InquiryMailable($data));

        return redirect()->route('contact')->with('message', 'お問い合わせを送信しました。担当者よりご連絡いたします。');
    }
}
