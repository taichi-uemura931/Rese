<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\AdminNoticeMail;
use App\Models\User;

class AdminEmailController extends Controller
{
    public function form()
    {
        return view('admin.email.form');
    }

    public function send(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
        ]);

        $users = User::where('role', 'user')->get();

        foreach ($users as $user) {
            Mail::to($user->email)->send(new AdminNoticeMail($request->subject, $request->message));
        }

        return redirect()->route('admin.dashboard')->with('success', 'お知らせメールを送信しました');
    }
}

