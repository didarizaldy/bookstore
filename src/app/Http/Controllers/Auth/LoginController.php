<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Middleware\AuthenticateWithBasicAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;


class LoginController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:120',
            'password' => 'required|string|min:6|max:12',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Invalid Credentials'], 400);
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Check if the authenticated user has the 'user' role
            if (Auth::user()->hasRole('user')) {
                return response()->json(['success' => true], 200);
            } else {
                Auth::logout();
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
            }
        }

        return response()->json(['success' => false, 'message' => 'Invalid Credentials'], 401);
    }

    public function logout()
    {
        Session::flush();
        Auth::logout();

        return redirect()->back();
    }
}
