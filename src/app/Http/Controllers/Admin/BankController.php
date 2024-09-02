<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BankAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Colors\Rgb\Channels\Red;
use Yajra\DataTables\Facades\DataTables;

class BankController extends Controller
{
    public function view(Request $request)
    {
        if ($request->ajax()) {
            $bankAccounts = BankAccount::all();

            return DataTables::of($bankAccounts)
                ->addColumn('actions', function ($bankAccount) {
                    return '<a href="#"class="btn btn-sm btn-primary edit-button"><i class="fas fa-edit"></i></a> <a href="#" class="btn btn-sm btn-danger deactive-button"><i class="fas fa-times-circle"></i></a>';
                })
                ->rawColumns(['actions'])
                ->make(true);
        }

        return view('contents.admin.finance-bank');
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $bankAccount = BankAccount::create([
            'bank_code' => $request->bank_code,
            'bank_name' => ucwords($request->bank_name),
            'account_name' => ucwords(strtolower($request->account_name)),
            'account_code' => $request->account_code,
            'active' => (int)1,
            'created_by' => $user->username,
        ]);

        return response()->json(['message' => 'Berhasil ditambahkan']);
    }

    public function update(Request $request, $id)
    {
        try {
            $user = Auth::user();
            $bankAccount = BankAccount::findOrFail($id);

            $bankAccount->update([
                'bank_code' => $request->bank_code,
                'bank_name' => ucwords(strtolower($request->bank_name)),
                'account_name' => ucwords(strtolower($request->account_name)),
                'account_code' => $request->account_code,
                'active' => (int)1,
                'updated_by' => $user->username,
            ]);

            if (!$bankAccount) {
                return response()->json($bankAccount);
            }

            return response()->json(['message' => 'Berhasil diupdate']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal diupdate: ' . $e->getMessage()], 500);
        }
    }


    public function deactive($id)
    {
        try {
            $user = Auth::user();
            $bank = BankAccount::findOrFail($id);

            // Toggle the active status
            $newStatus = $bank->active == '1' ? '0' : '1';

            $bank->update([
                'active' => $newStatus,
                'updated_by' => $user->username,
            ]);

            return response()->json(['message' => $newStatus ? 'Berhasil diaktifkan' : 'Berhasil dinonaktifkan']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan', 'error' => $e->getMessage()], 500);
        }
    }
}
