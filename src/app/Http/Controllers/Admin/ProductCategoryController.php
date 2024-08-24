<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ProductCategoryController extends Controller
{
    public function view(Request $request)
    {
        if ($request->ajax()) {
            $categories = ProductCategory::all();

            return DataTables::of($categories)
                ->addColumn('actions', function ($category) {
                    return '<a href="#" class="btn btn-sm btn-primary">Edit</a> <a href="#" class="btn btn-sm btn-danger">Delete</a>';
                })
                ->rawColumns(['actions'])
                ->make(true);
        }

        return view('contents.admin.product-category');
    }
}
