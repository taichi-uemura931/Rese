<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\OwnerRegisterRequest;
use App\Models\User;

class AdminOwnerController extends Controller
{
    public function create()
    {
        return view('admin.owners.create');
    }

    public function store(OwnerRegisterRequest $request)
    {
        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'owner',
        ]);

        return redirect()->route('admin.dashboard')->with('success', '店舗代表者を登録しました');
    }
}
