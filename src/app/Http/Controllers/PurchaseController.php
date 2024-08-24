<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use App\Models\Paid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{
  public function view()
  {
    $purchase = Paid::with('delivery', 'checkout.product')
      ->where('id_user', Auth::id())
      ->get();

    return view('contents.public.purchase', compact(
      'purchase'
    ));

    // return response()->json($purchase);
  }

  public function viewConfirmation()
  {
    $purchase = Paid::with('delivery', 'checkout.product')
      ->where('id_user', Auth::id())
      ->where('paids.status', 'paid')
      ->whereHas('delivery', function ($query) {
        $query->where('status', 'pembayaran diterima');
      })
      ->get();

    return view('contents.public.purchase-confirmation', compact(
      'purchase'
    ));

    // return response()->json($purchase);
  }

  public function viewProcessed()
  {
    $purchase = Paid::with('delivery', 'checkout.product')
      ->where('id_user', Auth::id())
      ->where('paids.status', 'paid')
      ->whereHas('delivery', function ($query) {
        $query->where('status', 'diproses');
      })
      ->get();

    return view('contents.public.purchase-processed', compact(
      'purchase'
    ));

    // return response()->json($purchase);
  }

  public function viewDelivery()
  {
    $purchase = Paid::with('delivery', 'checkout.product')
      ->where('id_user', Auth::id())
      ->where('paids.status', 'paid')
      ->whereHas('delivery', function ($query) {
        $query->where('status', 'dikirim');
      })
      ->get();

    return view('contents.public.purchase-delivery', compact(
      'purchase'
    ));

    // return response()->json($purchase);
  }

  public function viewArrive()
  {
    $purchase = Paid::with('delivery', 'checkout.product')
      ->where('id_user', Auth::id())
      ->where('paids.status', 'paid')
      ->whereHas('delivery', function ($query) {
        $query->where('status', 'sampai');
      })
      ->get();

    return view('contents.public.purchase-arrive', compact(
      'purchase'
    ));

    // return response()->json($purchase);
  }


  public function viewReturn()
  {
    $purchase = Paid::with('delivery', 'checkout.product')
      ->where('id_user', Auth::id())
      ->where('paids.status', 'paid')
      ->whereHas('delivery', function ($query) {
        $query->where('status', 'dikembalikan');
      })
      ->get();

    return view('contents.public.purchase-return', compact(
      'purchase'
    ));

    // return response()->json($purchase);
  }

  public function viewCancelled()
  {
    $purchase = Paid::with('delivery', 'checkout.product')
      ->where('id_user', Auth::id())
      ->where('paids.status', 'unpaid')
      ->whereHas('delivery', function ($query) {
        $query->where('status', 'dibatalkan');
      })
      ->get();

    return view('contents.public.purchase-cancelled', compact(
      'purchase'
    ));

    // return response()->json($purchase);
  }

  public function purchaseCancelled(Request $request)
  {
    $delivery = Delivery::where('id_payment', $request->payment_id);
    if ($delivery) {
      $delivery->update([
        'status' => 'dibatalkan'
      ]);

      return redirect()->route('public.cancelled.view');
    }

    return response()->json($delivery);
  }
}
