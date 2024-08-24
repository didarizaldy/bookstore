<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Delivery;
use App\Models\Paid;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class OrderController extends Controller
{
  public function viewOrder(Request $request)
  {
    if ($request->ajax()) {
      $orders = Paid::with(['user', 'bank', 'shipping', 'delivery']);

      // Search by id_payment, receiver_name, or receiver_phone
      if ($request->has('searchTerm')) {
        $searchTerm = $request->searchTerm;
        $orders->where(function ($query) use ($searchTerm) {
          $query->where('id_payment', 'LIKE', "%{$searchTerm}%")
            ->orWhereHas('delivery', function ($q) use ($searchTerm) {
              $q->where('receiver_name', 'LIKE', "%{$searchTerm}%")
                ->orWhere('receiver_phone', 'LIKE', "%{$searchTerm}%")
                ->orWhere('connote', 'LIKE', "%{$searchTerm}%");
            });
        });
      }

      // Filter by status
      if ($request->has('status') && $request->status != 'all') {
        $orders->whereHas('delivery', function ($query) use ($request) {
          $query->where('status', $request->status);
        });
      }

      return DataTables::of($orders)
        ->addColumn('id_payment', function ($order) {
          return $order->id_payment;
        })
        ->addColumn('type', function ($order) {
          return $order->delivery ? $order->delivery->type : 'N/A';
        })
        ->addColumn('status', function ($order) {
          return $order->status === 'paid' ? 'Paid' : 'Unpaid';
        })
        ->addColumn('connote', function ($order) {
          return $order->delivery ? $order->delivery->connote : 'N/A';
        })
        ->addColumn('logistic', function ($order) {
          return $order->delivery ? $order->delivery->logistic : 'N/A';
        })
        ->addColumn('total_pay', function ($order) {
          return $order->total_pay;
        })
        ->make(true);
    }

    return view('contents.admin.order-view');
  }

  public function viewDelivery(Request $request)
  {
    if ($request->ajax()) {
      $deliveries = Delivery::with(['paid'])
        ->whereHas('paid', function ($query) {
          $query->where('payment', 'BANK')
            ->whereNotNull('id_bankaccount');
        });

      // Search by id_payment, paid_name, paid_number_bank, paid_proof_link, connote
      if ($request->has('searchTerm')) {
        $searchTerm = $request->searchTerm;
        $deliveries->where(function ($query) use ($searchTerm) {
          $query->where('id_payment', 'LIKE', "%{$searchTerm}%")
            ->orWhereHas('paid', function ($q) use ($searchTerm) {
              $q->where('paid_name', 'LIKE', "%{$searchTerm}%")
                ->orWhere('paid_number_bank', 'LIKE', "%{$searchTerm}%")
                ->orWhere('paid_proof_link', 'LIKE', "%{$searchTerm}%");
            })
            ->orWhere('connote', 'LIKE', "%{$searchTerm}%");
        });
      }

      // Filter by payment status (paid/unpaid)
      if ($request->has('payment_status') && $request->payment_status != 'all') {
        $deliveries->whereHas('paid', function ($query) use ($request) {
          $query->where('status', $request->payment_status);
        });
      }

      // Filter by delivery status
      if ($request->has('delivery_status') && $request->delivery_status != 'all') {
        $deliveries->where('status', $request->delivery_status);
      }

      return DataTables::of($deliveries)
        ->addColumn('id_payment', function ($delivery) {
          return $delivery->id_payment;
        })
        ->addColumn('paid_number_bank', function ($delivery) {
          return $delivery->paid ? $delivery->paid->paid_number_bank : 'N/A';
        })
        ->addColumn('paid_proof_link', function ($delivery) {
          return $delivery->paid ? $delivery->paid->paid_proof_link : 'N/A';
        })
        ->addColumn('connote', function ($delivery) {
          return $delivery->connote;
        })
        ->addColumn('payment_status', function ($delivery) {
          return $delivery->paid && $delivery->paid->status === 'paid' ? 'Paid' : 'Unpaid';
        })
        ->addColumn('delivery_status', function ($delivery) {
          return $delivery->status;
        })
        ->make(true);
    }

    return view('contents.admin.order-delivery');
  }

  public function viewCancelled(Request $request)
  {
    if ($request->ajax()) {
      // Retrieve orders where delivery status is "dibatalkan"
      $deliveries = Delivery::with(['paid'])
        ->where('status', 'dibatalkan');

      // Search by id_payment and connote
      if ($request->has('searchTerm')) {
        $searchTerm = $request->searchTerm;
        $deliveries->where(function ($query) use ($searchTerm) {
          $query->where('id_payment', 'LIKE', "%{$searchTerm}%")
            ->orWhere('connote', 'LIKE', "%{$searchTerm}%");
        });
      }

      // Filter by logistic type (pick-up-order, cash-on-delivery, bank)
      if ($request->has('logistic') && $request->logistic != 'all') {
        $deliveries->where('type', $request->logistic);
      }

      return DataTables::of($deliveries)
        ->addColumn('id_payment', function ($delivery) {
          return $delivery->id_payment;
        })
        ->addColumn('connote', function ($delivery) {
          return $delivery->connote;
        })
        ->addColumn('logistic', function ($delivery) {
          return $delivery->logistic;
        })
        ->addColumn('status', function ($delivery) {
          return $delivery->status;
        })
        ->make(true);
    }

    return view('contents.admin.order-cancelled');
  }
}
