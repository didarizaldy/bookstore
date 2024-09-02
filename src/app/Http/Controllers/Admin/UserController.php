<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BankAccount;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function view(Request $request)
    {
        if ($request->ajax()) {
            $userView = User::all();

            return DataTables::of($userView)
                ->addColumn('actions', function ($userView) {
                    return '<a href="#"class="btn btn-sm btn-primary edit-button"><i class="fas fa-edit"></i></a> <a href="#" class="btn btn-sm btn-danger deactive-button"><i class="fas fa-times-circle"></i></a>';
                })
                ->rawColumns(['actions'])
                ->make(true);
        }

        return view('contents.admin.user');
    }

    public function store(Request $request)
    {
        try {
            // Validate the request data
            $request->validate([
                'username' => 'required|string|unique:users,username|max:35',
                'fullname' => 'required|string|max:100',
                'email' => 'required|string|email|unique:users,email|max:125',
                'password' => 'required|string|min:8',
            ]);

            // Create the user
            $user = User::create([
                'username' => strtolower($request->username),
                'fullname' => ucwords(strtolower($request->fullname)),
                'email' => $request->email,
                'api_token' => Str::random(100),
                'password' => bcrypt($request->password),
                'active' => '1',
            ]);

            // Assign role to the user
            $user->assignRole('admin');

            return response()->json([
                'success' => true,
                'message' => 'Berhasil menambahkan user'
            ], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            // Validate the request data
            $request->validate([
                'username' => 'required|string|max:35',
                'fullname' => 'required|string|max:100',
                'email' => 'required|string|max:125',
                'password' => 'required|string|min:8',
            ]);

            $user = User::findOrFail($id);

            $user->update([
                'username' => strtolower($request->username),
                'fullname' => ucwords(strtolower($request->fullname)),
                'email' => $request->email,
                'api_token' => Str::random(100),
                'password' => bcrypt($request->password),
                'active' => '1',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Berhasil update user'
            ], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function deactive($id)
    {
        try {
            $user = User::findOrFail($id);

            $userStatus = $user->active == '1' ? '0' : '1';

            $user->update([
                'active' => $userStatus
            ]);

            return response()->json([
                'success' => true,
                'message' => $userStatus == '1' ? 'User berhasil diaktifkan' : 'User berhasil dinonaktifkan',
                'user' => $user // Optionally return the updated user data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
