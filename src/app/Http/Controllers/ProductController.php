<?php

namespace App\Http\Controllers;

use App\Models\Basket;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($sku, $slug)
    {
        // Find the product by SKU and slug
        $product = Product::with('category')->where('sku', $sku)->where('slug', $slug)->firstOrFail();

        // Format product attributes
        $product->formatted_original_price = formatRupiah($product->original_price);
        $product->formatted_display_price = $product->discount ? formatRupiah($product->display_price) : null;
        $product->formatted_discount = $product->discount ? $product->discount . ' %' : null;

        // Return the view with product details
        return view('contents.public.detail', compact('product'));
    }



    public function search(Request $request)
    {
        // Get the query, sort, and price range from the request
        $query = $request->input('q');
        $sort = $request->input('sort', 'latest'); // Default to 'latest' if not provided
        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');

        // Start with a base query
        $productsQuery = Product::where('title', 'LIKE', '%' . $query . '%');

        // Apply price filtering if specified
        if ($minPrice) {
            $productsQuery->where('display_price', '>=', $minPrice);
        }

        if ($maxPrice) {
            $productsQuery->where('display_price', '<=', $maxPrice);
        }

        // Apply sorting
        switch ($sort) {
            case 'high-price':
                $productsQuery->orderBy('display_price', 'desc');
                break;
            case 'low-price':
                $productsQuery->orderBy('display_price', 'asc');
                break;
            case 'latest':
            default:
                $productsQuery->orderBy('created_at', 'desc');
                break;
        }

        // Paginate the results
        $products = $productsQuery->paginate(60);

        // Format prices
        $products->getCollection()->transform(function ($product) {
            $product->formatted_original_price = formatRupiah($product->original_price);
            $product->formatted_display_price = $product->discount ? formatRupiah($product->display_price) : null;
            $product->formatted_discount = $product->discount ? 'Diskon ' . $product->discount . ' %' : null;
            return $product;
        });

        // Return the view with the results
        return view('contents.public.search-results', [
            'products' => $products,
            'query' => $query,
            'sort' => $sort,
            'minPrice' => $minPrice,
            'maxPrice' => $maxPrice,
        ]);
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
