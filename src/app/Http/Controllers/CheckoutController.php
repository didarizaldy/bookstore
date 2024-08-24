<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use App\Models\Basket;
use App\Models\Checkout;
use App\Models\Delivery;
use App\Models\Paid;
use App\Models\Product;
use App\Models\Shipping;
use Carbon\Carbon;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }

  public function viewCheckout(Request $request)
  {
    $selectedItems = session()->get('selected_items');

    if (!$selectedItems) {
      return redirect()->route('public.cart.view');
    }

    $cartItems = Basket::with('product')
      ->where('id_user', Auth::id())
      ->whereIn('id_product', $selectedItems)
      ->get();

    $bankAccount = BankAccount::get();

    $countTotalitem = 0;

    foreach ($cartItems as $item) {
      $countTotalitem += $item['quantity'];
    }

    $totalPriceItems = 0;
    $deliveryPrice = $countTotalitem <= 15 ? 9000 : 9000 * floor($countTotalitem / 15);
    $packagePrice = $countTotalitem > 15 ? ($countTotalitem * 2000) : 0;
    $uniqueCodePayment = mt_rand(1, 99);

    foreach ($cartItems as $item) {
      $totalPriceItems += $item['quantity'] * $item['product']['display_price'];
    }

    $totalPay = $totalPriceItems + $deliveryPrice + $packagePrice + $uniqueCodePayment;

    $shippingAddress = Shipping::with('user')
      ->where('id_user', Auth::id())
      ->where('is_default', 1)
      ->first();

    return view('contents.public.checkout', compact(
      'cartItems',
      'countTotalitem',
      'selectedItems',
      'bankAccount',
      'shippingAddress',
      'totalPriceItems',
      'deliveryPrice',
      'packagePrice',
      'uniqueCodePayment',
      'totalPay'
    ));


    // return response()->json($countTotalitem);
  }

  public function store(Request $request)
  {
    DB::beginTransaction(); // Start a database transaction

    try {
      $cartItems = Basket::with('product')
        ->where('id_user', Auth::id())
        ->whereIn('id_product', json_decode($request->input('selectedItems'), true))
        ->get();

      $shippingAddress = Shipping::with('user')
        ->where('id_user', Auth::id())
        ->where('is_default', 1)
        ->first();

      $listToPay = Paid::with('user', 'delivery')
        ->where('id_user', Auth::id())
        ->where('status', 'unpaid')
        ->where('expired_at', '>=', now())
        ->whereNot('payment', 'cash-on-delivery')
        ->whereNot('payment', 'pick-up-order')
        ->whereNull('paid_at')
        ->first();

      $totalItems = 0;
      $totalPrice = 0;
      $uniqueCodeCO = (int)((microtime(true) * 1000) % 1000);

      $invoiceCode = 'INV/' . date('Ymd') . '/' . date('His') . '/' . $uniqueCodeCO;
      $paymentCode = 'PAY' . date('YmdHis') . $uniqueCodeCO;

      foreach ($cartItems as $item) {
        $totalItems += $item['quantity'];
      }

      $outOfStockProducts = []; // Initialize out-of-stock products array
      //   $totalFeeShipping = $totalItems <= 15 ? 9000 : 9000 * floor($totalItems / 15);
      $totalFeeShipping = $totalItems > 15 ? 9000 * floor($totalItems / 15) : 0;
      $totalFeePackage = $totalItems > 15 ? ($totalItems * 2000) : 0;

      foreach ($cartItems as $item) {
        $totalPrice += $item->quantity * $item->product->display_price;

        // Lock the product row for updating to avoid race conditions
        $product = Product::where('id', $item->product->id)->lockForUpdate()->firstOrFail();

        // Check if the product is out of stock
        if ($product->stocks < $item->quantity) {
          $outOfStockProducts[] = $product->title;
        }
      }

      if (!empty($outOfStockProducts)) {
        DB::rollBack(); // Roll back the transaction if any product is out of stock
        return response()->json([
          'success' => false,
          'errors' => $outOfStockProducts
        ], 400);
      }

      if (!$listToPay) {
        foreach ($cartItems as $item) {
          $product = Product::where('id', $item->product->id)->lockForUpdate()->firstOrFail();

          $product->stocks -= $item->quantity;
          $product->save();

          Checkout::create([
            'id_user' => auth()->id(),
            'id_shipping' => $shippingAddress->id,
            'invoice' => $invoiceCode,
            'id_payment' => $paymentCode,
            'id_product' => $item->product->id,
            'quantity' => $item->quantity,
            'original_price' => $item->product->original_price,
            'display_price' => $item->product->display_price,
            'total_price' => $item->quantity * $item->product->display_price,
            'fee_shipping' => ($totalItems > 15) ? 9000 : 0,
            'fee_package' => ($totalItems > 15) ? 2000 : 0
          ]);
        }

        Delivery::create([
          'id_payment' => $paymentCode,
          'receiver_name' => $shippingAddress->receiver_name,
          'receiver_address' => strpos($request->paymentMethod, 'bank-') === 0 ? $shippingAddress->address : NULL,
          'receiver_phone' => $shippingAddress->phone,
          'type' => strpos($request->paymentMethod, 'bank-') === 0 ? 'logistic' : $request->paymentMethod,
          'status' => strpos($request->paymentMethod, 'bank-') === 0 ? 'menunggu pembayaran' : 'diproses',
          'connote' => strpos($request->paymentMethod, 'bank-') === 0 ? 'JBDTB' . date('YmdHis') . $uniqueCodeCO : NULL,
          'logistic' => strpos($request->paymentMethod, 'bank-') === 0 ? 'Pengiriman Toko' : $request->paymentMethod
        ]);

        Paid::create([
          'id_user' => auth()->id(),
          'id_shipping' => $shippingAddress->id,
          'id_payment' => $paymentCode,
          'total_item' => $totalItems,
          'payment' => strpos($request->paymentMethod, 'bank-') === 0 ? 'BANK' : $request->paymentMethod,
          'id_bankaccount' => strpos($request->paymentMethod, 'bank-') === 0 ? substr($request->paymentMethod, 5) : null,
          'total_fee_shipping' => $totalFeeShipping,
          'total_fee_package' => $totalFeePackage,
          'total_price_item' => $totalPrice,
          'total_pay' => $totalFeePackage + $totalFeePackage + $totalPrice,
          'expired_at' => Carbon::now()->addHours(8)
        ]);

        // Clear cart items
        Basket::where('id_user', Auth::id())
          ->whereIn('id_product', json_decode($request->input('selectedItems'), true))
          ->delete();

        DB::commit(); // Commit the transaction

        return response()->json(['success' => true]);
      }

      DB::rollBack(); // Roll back the transaction if there's an unpaid transaction

      return response()->json([
        'success' => false,
        'errors' => ['Kamu masih ada pembayaran yang belum diselesaikan'],
      ], 503);
    } catch (\Exception $e) {
      DB::rollBack(); // Roll back the transaction in case of any error

      return response()->json([
        'success' => false,
        'errors' => [$e->getMessage()],
      ], 500);
    }
  }
}
