<?php

namespace App\Http\Controllers;

use App\Http\Controllers\API\ProductCategoryController;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    public function index()
    {
        // Get Categories
        $categories = ProductCategory::select('name')->get();

        // Products New Release
        $productsNew = Product::orderBy('release_at', 'desc')->take(6)->get()->map(function ($productNew) {
            // Format original price and display price to Rupiah
            $productNew->formatted_original_price = formatRupiah($productNew->original_price);
            $productNew->formatted_display_price = $productNew->discount ? formatRupiah($productNew->display_price) : null;
            $productNew->formatted_discount = $productNew->discount ? 'Diskon ' .  $productNew->discount . '%' : null;
            return $productNew;
        });

        // Products Religion New Release
        $productsReligion = Product::where('id_category', 1) // Use the category ID directly
            ->orderBy('release_at', 'desc')
            ->take(6)
            ->get()
            ->map(function ($productReligion) {
                // Format original price and display price to Rupiah
                $productReligion->formatted_original_price = formatRupiah($productReligion->original_price);
                $productReligion->formatted_display_price = $productReligion->discount ? formatRupiah($productReligion->display_price) : null;
                $productReligion->formatted_discount = $productReligion->discount ? 'Diskon ' .  $productReligion->discount . '%' : null;
                return $productReligion;
            });

        // Products Cook New Release
        $productsCook = Product::where('id_category', 31) // Use the category ID directly
            ->orderBy('release_at', 'desc')
            ->take(6)
            ->get()
            ->map(function ($productCook) {
                // Format original price and display price to Rupiah
                $productCook->formatted_original_price = formatRupiah($productCook->original_price);
                $productCook->formatted_display_price = $productCook->discount ? formatRupiah($productCook->display_price) : null;
                $productCook->formatted_discount = $productCook->discount ? 'Diskon ' .  $productCook->discount . '%' : null;
                return $productCook;
            });

        // Products Comic New Release
        $productsComic = Product::where('id_category', 13) // Use the category ID directly
            ->orderBy('release_at', 'desc')
            ->take(6)
            ->get()
            ->map(function ($productComic) {
                // Format original price and display price to Rupiah
                $productComic->formatted_original_price = formatRupiah($productComic->original_price);
                $productComic->formatted_display_price = $productComic->discount ? formatRupiah($productComic->display_price) : null;
                $productComic->formatted_discount = $productComic->discount ? 'Diskon ' .  $productComic->discount . '%' : null;
                return $productComic;
            });

        // Products Education New Release
        $productsEducation = Product::where('id_category', 19) // Use the category ID directly
            ->orderBy('release_at', 'desc')
            ->take(6)
            ->get()
            ->map(function ($productEducation) {
                // Format original price and display price to Rupiah
                $productEducation->formatted_original_price = formatRupiah($productEducation->original_price);
                $productEducation->formatted_display_price = $productEducation->discount ? formatRupiah($productEducation->display_price) : null;
                $productEducation->formatted_discount = $productEducation->discount ? 'Diskon ' .  $productEducation->discount . '%' : null;
                return $productEducation;
            });


        return view('contents.public.home', compact(
            'categories',
            'productsNew',
            'productsReligion',
            'productsCook',
            'productsComic',
            'productsEducation'
        ));

        // return response()->json($productsReligion);
    }
}
