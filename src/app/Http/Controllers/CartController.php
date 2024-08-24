<?php

namespace App\Http\Controllers;

use App\Models\Basket;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function addToCart(Request $request)
    {
        $user = Auth::user();
        $product = Product::find($request->product_id);

        if (!$product || $product->stocks < $request->quantity) {
            return response()->json(['error' => 'Product not available or insufficient stock'], 400);
        }

        $cartItem = Basket::updateOrCreate(
            [
                'id_user' => $user->id,
                'id_product' => $product->id
            ],
            [
                'quantity' => \DB::raw('quantity + ' . $request->quantity)
            ]
        );

        $newCartCount = Basket::where('id_user', Auth::id())->count();


        return response()->json(['success' => 'Product added to cart', 'newCartCount' => $newCartCount]);
    }

    public function viewCart()
    {
        if (Auth::check()) {
            $cartItems = Basket::with('product')
                ->where('id_user', Auth::id())
                ->get();

            return view('contents.public.cart', compact('cartItems'));
        } else {
            // Handle unauthenticated users (e.g., redirect to login)
            return redirect()->route('login');
        }
    }

    public function store(Request $request)
    {
        $selectedItems = json_decode($request->input('selectedItems'), true);
        session()->put('selected_items', $selectedItems);

        return redirect()->route('public.checkout.view')->with('success', 'Checkout successful!');
    }

    // In your CartController@deleteItem method
    public function deleteItem(Request $request, $id)
    {
        $item = Basket::where('id_user', Auth::id())
            ->where('id_product', $id)
            ->first();

        if ($item) {
            $item->delete();

            // Calculate the new cart count after deletion
            $newCartCount = Basket::where('id_user', Auth::id())->count();

            return response()->json(['success' => 'Item deleted', 'newCartCount' => $newCartCount]);
        }

        return response()->json(['error' => 'Item not found'], 404);
    }


    public function deleteAllItems(Request $request)
    {
        $user = Auth::user();

        Basket::where('id_user', $user->id)->delete();

        return response()->json(['success' => 'All items deleted']);
    }

    public function deleteSelectedItems(Request $request)
    {
        $selectedItems = $request->input('selectedItems');

        if (is_array($selectedItems)) {
            foreach ($selectedItems as $id) {
                $cartItem = Basket::where('id_user', auth()->id())
                    ->where('id_product', $id)
                    ->first();
                if ($cartItem) {
                    $cartItem->delete();
                }
            }
        }

        // Optionally return the new cart count or any other necessary data
        $newCartCount = Basket::where('id_user', auth()->id())->count();

        return response()->json([
            'message' => 'Selected items deleted successfully',
            'newCartCount' => $newCartCount
        ]);
    }
}
