<?php

namespace App\Http\Controllers;

use App\Models\Shipping;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
    public function viewSetting()
    {
        $shippings = Shipping::with('user')
            ->where('id_user', Auth::id())
            ->get();

        return view('contents.public.setting', compact(
            'shippings'
        ));
        // return response()->json($shipping->address);
    }
}
