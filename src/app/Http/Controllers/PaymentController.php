<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use App\Models\Basket;
use App\Models\Checkout;
use App\Models\Paid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function view()
    {
        $payment = Paid::with('user', 'bank', 'shipping', 'delivery')
            ->where('id_user', Auth::id())
            ->where('status', 'unpaid')
            ->where('expired_at', '>=', now())
            ->whereNull('paid_at')
            ->whereHas('delivery', function ($query) {
                $query->whereNot('status', 'dibatalkan');
            })
            ->first();

        $listItem = Checkout::with('user', 'paid', 'product')
            ->whereHas('paid', function ($query) {
                $query->where('status', 'unpaid')
                    ->whereNull('paid_at')
                    ->where('expired_at', '>=', now());
            })
            ->where('id_user', Auth::id())
            ->get();

        $priceItem = 0;
        foreach ($listItem as $item) {
            $priceItem += $item['display_price'];
        }

        if (!$payment) {
            return redirect()->route('public.cart.view');
        }

        return view('contents.public.payment', compact(
            'payment',
            'priceItem',
            'listItem'
        ));

        // return response()->json($listItem);
    }

    public function confirmPayment(Request $request, $id)
    {
        $paid = Paid::where('id_payment', '=', $id)->firstOrFail();

        $paid->update([
            'paid_name' => $request->paid_name,
            'paid_code_bank' => $request->paid_code_bank,
            'paid_number_bank' => $request->paid_number_bank,
            'paid_proof_link' => $request->paid_proof_link
        ]);

        // return response()->json('wow');


        return redirect()->route('public.home');
    }
}
