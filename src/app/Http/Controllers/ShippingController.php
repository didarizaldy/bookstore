<?php

namespace App\Http\Controllers;

use App\Models\Shipping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShippingController extends Controller
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
    $user = Auth::user();

    // Check if the user already has 3 addresses
    if (Shipping::where('id_user', $user->id)->count() >= 3) {
      return back()->withErrors(['error' => 'You can only have up to 3 shipping addresses.']);
    }

    $request->validate([
      'receiver_name' => 'required|string|max:255',
      'tag' => 'nullable|string|max:255',
      'address' => 'required|string|max:255',
      'notes' => 'nullable|string|max:255',
      'maps' => 'nullable|string|max:255',
      'phone' => 'required|string|max:20',
    ]);

    Shipping::create([
      'id_user' => $user->id,
      'receiver_name' => $request->receiver_name,
      'tag' => $request->tag,
      'address' => $request->address,
      'notes' => $request->notes,
      'maps' => $request->maps,
      'phone' => $request->phone,
      'created_by' => $user->username
    ]);

    return back()->with('success', 'Sukses.');
  }

  /**
   * Display the specified resource.
   */
  public function show(string $id)
  {
    //
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
  public function update(Request $request, $id)
  {
    $shipping = Shipping::findOrFail($id);

    // Ensure the shipping address belongs to the authenticated user
    if ($shipping->id_user != Auth::id()) {
      return back()->withErrors(['error' => 'Unauthorized action.']);
    }

    $request->validate([
      'receiver_name' => 'required|string|max:255',
      'tag' => 'nullable|string|max:255',
      'address' => 'required|string|max:255',
      'notes' => 'nullable|string|max:255',
      'maps' => 'nullable|string|max:255',
      'phone' => 'required|string|max:20',
    ]);

    $shipping->update([
      'receiver_name' => $request->receiver_name,
      'tag' => $request->tag,
      'address' => $request->address,
      'notes' => $request->notes,
      'maps' => $request->maps,
      'phone' => $request->phone,
    ]);

    return back()->with('success', 'Sukses.');
  }

  public function primaryAddress(Request $request, $id)
  {
    $userId = Auth::id();

    // Set all the user's addresses to not be the primary address
    Shipping::where('id_user', $userId)->update(['is_default' => 0]);

    // Set the selected address as the primary address
    Shipping::where('id', $id)
      ->where('id_user', $userId)
      ->update(['is_default' => 1]);

    return back()->with('success', 'Alamat pengiriman utama berhasil diperbarui.');
  }

  // Delete a shipping address
  public function destroy($id)
  {
    $shipping = Shipping::findOrFail($id);

    // Ensure the shipping address belongs to the authenticated user
    if ($shipping->id_user != Auth::id()) {
      return back()->withErrors(['error' => 'Unauthorized action.']);
    }

    $shipping->delete();

    return back()->with('success', 'Shipping address deleted successfully.');
  }
}
