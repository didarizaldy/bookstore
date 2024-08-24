<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function view()
    {
        return view('contents.admin.login');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:120',
            'password' => 'required|string|min:6|max:12'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Invalid Credentials'], 400);
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            if (Auth::user()->hasRole('opsweb') | Auth::user()->hasRole('admin')) {
                return response()->json(['success' => true], 200);
            } else {
                Auth::logout();
                return response()->json(['success' => false, 'message' => 'Wah ini bukan ranah kamu ya :D'], 401);
            }
        }

        return response()->json(['success' => false, 'message' => 'Invalid Credentials'], 401);
    }

    public function logout()
    {
        Session::flush();
        Auth::logout();

        return redirect()->route('admin.login')->with('success', 'Checkout successful!');
    }
}
