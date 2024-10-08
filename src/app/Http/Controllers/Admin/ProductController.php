<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function view(Request $request)
    {
        if ($request->ajax()) {
            $products = Product::with('category');

            // Filter by category
            if ($request->has('category') && $request->category != 'all') {
                $products->where('id_category', $request->category);
            }

            // Sorting by price, creation date, or title
            if ($request->has('sort')) {
                switch ($request->sort) {
                    case 'high_price':
                        $products->orderBy('display_price', 'desc');
                        break;
                    case 'low_price':
                        $products->orderBy('display_price', 'asc');
                        break;
                    case 'last_updated':
                        $products->orderBy('updated_at', 'desc');
                        break;
                    case 'last_created':
                        $products->orderBy('created_at', 'desc');
                        break;
                    case 'old_created':
                        $products->orderBy('created_at', 'asc');
                        break;
                    case 'alphabet_a_z':
                        $products->orderBy('title', 'asc');
                        break;
                    case 'alphabet_z_a':
                        $products->orderBy('title', 'desc');
                        break;
                }
            }

            return DataTables::of($products)
                ->addColumn('category', function ($product) {
                    return $product->category ? $product->category->name : 'N/A';
                })
                ->addColumn('actions', function ($product) {
                    return '<a href="#" class="btn btn-sm btn-primary">Edit</a> <a href="#" class="btn btn-sm btn-danger">Delete</a>';
                })
                ->rawColumns(['actions'])
                ->make(true);
        }

        $showCategories = ProductCategory::all();
        return view('contents.admin.product-view', compact('showCategories'));
    }

    public function create()
    {
        return view('contents.admin.product-add');
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        if ($request->hasFile('filename_img')) {
            $uploadFile = Str::slug($request->title) . $request->file('filename_img')->getClientOriginalExtension();

            // Upload image to custom directory
            $request->file('file_img')->move(public_path('assets/img/cover-book'), $uploadFile);
        }

        $product = Product::create([
            'sku' => ucwords($request->sku),
            'id_category' => $request->id_category,
            'title' => ucwords(strtolower($request->title)),
            'slug' => Str::slug(strtolower($request->title)),
            'filename_img' => $uploadFile,
            'author' => ucwords(strtolower($request->author)),
            'publisher' => ucwords(strtolower($request->publisher)),
            'original_price' => $request->original_price,
            'display_price' => $request->display_price,
            'discount' => $request->discount,
            'pages' => $request->pages,
            'release_at' => $request->release_at,
            'isbn' => $request->isbn,
            'lang' => $request->lang,
            'stocks' => $request->stocks,
            'available' => $request->available,
            'created_by' => $user->username,
        ]);

        return redirect()->route('admin.product.view');
        // return response()->json($product);
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $showCategories = ProductCategory::all();
        return view('contents.admin.product-edit', compact('product', 'showCategories'));
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $product = Product::findOrFail($id);

        if ($request->hasFile('filename_img')) {
            $uploadFile = Str::slug($request->title) . $request->file('filename_img')->getClientOriginalExtension();

            // Upload image to custom directory
            $request->file('file_img')->move(public_path('assets/img/cover-book'), $uploadFile);
        }



        $product->update([
            'sku' => ucwords($request->sku),
            'id_category' => $request->id_category,
            'title' => ucwords(strtolower($request->title)),
            'slug' => Str::slug(strtolower($request->title)),
            'filename_img' => $uploadFile,
            'author' => ucwords(strtolower($request->author)),
            'publisher' => ucwords(strtolower($request->publisher)),
            'original_price' => $request->original_price,
            'display_price' => $request->display_price,
            'discount' => $request->discount,
            'pages' => $request->pages,
            'release_at' => $request->release_at,
            'isbn' => $request->isbn,
            'lang' => $request->lang,
            'stocks' => $request->stocks,
            'updated_by' => $user->username,
        ]);

        return redirect()->route('admin.product.view');
        // return response()->json($product);
        // return response()->json(['message' => 'Product deleted successfully']);
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return response()->json(['message' => 'Product deleted successfully']);
    }

    public function archive(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->update([
            'available' => $request->available,

        ]);

        return redirect()->route('admin.product.view');
    }
}
