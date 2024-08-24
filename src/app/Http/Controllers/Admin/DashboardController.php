<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Checkout;
use App\Models\Delivery;
use App\Models\Paid;
use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function view()
    {
        $paidYetCount = count(
            Paid::whereNotIn('payment', ['pick-up-order', 'cash-on-delivery'])
                ->whereNull('paid_at')
                ->where('expired_at', '>=', now())
                ->get()
        );

        $shippingNeedProcessCount = count(
            Paid::whereNotIn('payment', ['pick-up-order', 'cash-on-delivery'])
                ->whereNotNull('paid_at')
                ->where('status', 'paid')
                ->get()
        );

        $shippingProcessCount = count(
            Delivery::where('status', 'Diproses')
                ->groupBy(['id_payment', 'id'])
                ->get()
        );

        $shippingCancelCount = count(
            Delivery::where('status', 'Dibatalkan')
                ->groupBy(['id_payment', 'id'])->get()
        );

        $productCount = count(
            Product::where('available', 1)
                ->get()
        );

        $productAlmostEmptyCount = count(
            Product::where('available', 1)
                ->where('stocks', '<', 50)
                ->get()
        );

        $productEmptyCount = count(
            Product::where('available', 1)
                ->where('stocks', 0)
                ->get()
        );

        $productDiscount = count(
            Product::where('available', 1)
                ->where('discount', '>', 0)
                ->get()
        );


        return view('contents.admin.home', compact(
            'paidYetCount',
            'shippingNeedProcessCount',
            'shippingProcessCount',
            'shippingCancelCount',
            'productCount',
            'productAlmostEmptyCount',
            'productEmptyCount',
            'productDiscount'
        ));
    }
}
