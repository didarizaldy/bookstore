<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($slug, Request $request)
    {
        // Get Categories
        $categories = ProductCategory::select('name')->get();

        // Find the category by generating the slug from name
        $category = ProductCategory::get()->filter(function ($category) use ($slug) {
            return generateSlug($category->name) === $slug;
        })->first();

        if (!$category) {
            // If category does not exist, redirect or show an error view
            abort(404);
        }

        // Handle sorting
        $sort = $request->query('sort', 'latest');
        $orderBy = 'release_at';
        $orderDirection = 'desc';

        if ($sort == 'high-price') {
            $orderBy = 'display_price';
            $orderDirection = 'desc';
        } elseif ($sort == 'low-price') {
            $orderBy = 'display_price';
            $orderDirection = 'asc';
        }

        // Get price range inputs
        $minPrice = $request->query('min_price');
        $maxPrice = $request->query('max_price');

        // Build the query to fetch products
        $query = Product::where('id_category', $category->id);

        // Apply price range filters if provided
        if ($minPrice) {
            $query->where('display_price', '>=', $minPrice);
        }
        if ($maxPrice) {
            $query->where('display_price', '<=', $maxPrice);
        }

        // Get products with pagination and sorting
        $products = $query->orderBy($orderBy, $orderDirection)->paginate(60)->onEachSide(0);

        // Format prices
        $products->getCollection()->transform(function ($product) {
            $product->formatted_original_price = formatRupiah($product->original_price);
            $product->formatted_display_price = $product->discount ? formatRupiah($product->display_price) : null;
            $product->formatted_discount = $product->discount ? 'Diskon ' . $product->discount . ' %' : null;
            return $product;
        });

        return view('contents.public.category', compact('category', 'products', 'categories', 'sort', 'minPrice', 'maxPrice'));
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
