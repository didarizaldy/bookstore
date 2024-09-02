<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    protected function create()
    {
        return view('contents.public.register');
    }
    protected function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|unique:users,username|max:35',
            'fullname' => 'required|max:100',
            'email' => 'required|unique:users,email|email|max:120',
            'password' => 'required|min:6|confirmed',
            'captcha' => 'required|captcha'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ]);
        }

        $user = User::create([
            'username' => strtolower($request->username),
            'fullname' => ucwords(strtolower($request->fullname)),
            'email' => strtolower($request->email),
            'api_token' => Str::random(100),
            'password' => bcrypt($request->password),
            'active' => '1'
        ]);

        $user->assignRole('user');

        return response()->json(['success' => true, 'message' => 'success'], 200);
    }
}
