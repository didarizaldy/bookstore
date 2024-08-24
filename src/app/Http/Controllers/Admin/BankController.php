<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BankAccount;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class BankController extends Controller
{
    public function view(Request $request)
    {
        if ($request->ajax()) {
            $bankAccounts = BankAccount::all();

            return DataTables::of($bankAccounts)
                ->addColumn('actions', function ($bankAccount) {
                    return '<a href="#" class="btn btn-sm btn-primary">Edit</a> <a href="#" class="btn btn-sm btn-danger">Delete</a>';
                })
                ->rawColumns(['actions'])
                ->make(true);
        }

        return view('contents.admin.finance-bank');
    }
}
