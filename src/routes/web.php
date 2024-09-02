<?php

use App\Http\Controllers\Admin\Auth\LoginController as AuthLoginController;
use App\Http\Controllers\Admin\BankController as AdminBankController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductCategoryController as AdminProductCategoryController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\ShippingController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\checkLogin;
use App\Http\Middleware\checkLoginAdmin;
use Illuminate\Support\Facades\Route;


// Util
Route::get('captcha-refresh', function () {
    return response()->json(['captcha' => captcha_img()]);
})->name('captcha.refresh');

// Route Publik Bisa Akses
Route::prefix('/')->name('public.')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('search', [ProductController::class, 'search'])->name('products.search');
    Route::get('c/{slug}', [ProductCategoryController::class, 'show'])->name('category.show');
    Route::get('p/{sku}/{slug}', [ProductController::class, 'show'])->name('product.detail');

    Route::post('masuk/verifikasi', [LoginController::class, 'login'])->name('login');
    Route::post('keluar', [LoginController::class, 'logout'])->name('logout');

    Route::get('registrasi', [RegisterController::class, 'create'])->name('register');
    Route::post('registrasi/simpan', [RegisterController::class, 'store'])->name('register.post');
});


// Route Publik Verifikasi Login
Route::prefix('/')->name('public.')->middleware('auth', checkLogin::class)->group(function () {
    Route::get('keranjang', [CartController::class, 'viewCart'])->name('cart.view');
    Route::post('keranjang/simpan', [CartController::class, 'store'])->name('cart.save');
    Route::post('keranjang/tambah', [CartController::class, 'addToCart'])->name('cart.add');
    Route::post('keranjang/hapus-semua', [CartController::class, 'deleteAllItems'])->name('cart.delete.all');
    Route::post('keranjang/hapus-item/{id}', [CartController::class, 'deleteItem'])->name('cart.delete.item');
    Route::post('keranjang/hapus-terpilih', [CartController::class, 'deleteSelectedItems'])->name('cart.delete.selected');


    Route::get('checkout', [CheckoutController::class, 'viewCheckout'])->name('checkout.view');
    Route::post('checkout/bayar', [CheckoutController::class, 'store'])->name('checkout.store');

    Route::get('pembayaran', [PaymentController::class, 'view'])->name('payment.view');
    Route::put('pembayaran/konfirmasi/{id}', [PaymentController::class, 'confirmPayment'])->name('payment.update');

    Route::get('pembelian', [PurchaseController::class, 'view'])->name('purchase.view');
    Route::get('pembelian/konfirmasi', [PurchaseController::class, 'viewConfirmation'])->name('confirmation.view');
    Route::get('pembelian/diproses', [PurchaseController::class, 'viewProcessed'])->name('processed.view');
    Route::get('pembelian/dikirim', [PurchaseController::class, 'viewDelivery'])->name('delivery.view');
    Route::get('pembelian/sampai', [PurchaseController::class, 'viewArrive'])->name('arrive.view');
    Route::get('pembelian/dikembalikan', [PurchaseController::class, 'viewReturn'])->name('return.view');
    Route::get('pembelian/dibatalkan', [PurchaseController::class, 'viewCancelled'])->name('cancelled.view');
    Route::post('pembelian/dibatalkan/submit', [PurchaseController::class, 'purchaseCancelled'])->name('cancelled.post');


    Route::get('user/setting', [SettingController::class, 'viewSetting'])->name('user.setting');
    Route::post('user/setting/profile/update', [UserController::class, 'updateProfile'])->name('user.profile.update');
    Route::post('user/setting/password/update', [UserController::class, 'updatePassword'])->name('user.password.update');
    Route::put('user/setting/shipping/update/{id}', [ShippingController::class, 'update'])->name('user.shipping.update');
    Route::delete('user/setting/shipping/delete/{id}', [ShippingController::class, 'destroy'])->name('user.shipping.destroy');
    Route::post('user/setting/shipping/store', [ShippingController::class, 'store'])->name('user.shipping.store');
    Route::post('user/setting/shipping/primary/{id}', [ShippingController::class, 'primaryAddress'])->name('user.shipping.primary');
});


// Route Admin Standar
Route::prefix('/admin/')->name('admin.')->group(function () {
    Route::get('masuk', [AuthLoginController::class, 'view'])->name('login.view');
    Route::post('masuk/verifikasi', [AuthLoginController::class, 'login'])->name('login');
    Route::post('keluar', [AuthLoginController::class, 'logout'])->name('logout');
});


// Route Admin Verifikasi Login
Route::prefix('/admin/')->name('admin.')->middleware('auth', checkLoginAdmin::class)->group(function () {
    Route::get('dashboard', [AdminDashboardController::class, 'view'])->name('home');

    Route::get('pesanan', [AdminOrderController::class, 'viewOrder'])->name('order.view');
    Route::get('pesanan/pengiriman', [AdminOrderController::class, 'viewDelivery'])->name('order.delivery.view');
    Route::get('pesanan/batal', [AdminOrderController::class, 'viewCancelled'])->name('order.cancel.view');

    Route::get('bank', [AdminBankController::class, 'view'])->name('bank.view');
    Route::post('bank', [AdminBankController::class, 'store'])->name('bank.store');
    Route::put('bank/edit/simpan/{id}', [AdminBankController::class, 'update'])->name('bank.update');
    Route::post('bank/nonaktif/{id}', [AdminBankController::class, 'deactive'])->name('bank.deactive');

    Route::get('c', [AdminProductCategoryController::class, 'view'])->name('category.view');

    Route::get('p', [AdminProductController::class, 'view'])->name('product.view');
    Route::get('p/daftar', [AdminProductController::class, 'create'])->name('product.add');
    Route::post('p/daftar/simpan', [AdminProductController::class, 'store'])->name('product.store');
    Route::get('p/edit/{id}', [AdminProductController::class, 'edit'])->name('product.edit');
    Route::put('p/edit/simpan/{id}', [AdminProductController::class, 'update'])->name('product.update');
    Route::delete('p/hapus/{id}', [AdminProductController::class, 'destroy'])->name('product.delete');

    Route::get('user', [AdminUserController::class, 'view'])->name('user.view');
    Route::post('user/daftar/simpan', [AdminUserController::class, 'store'])->name('user.store');
    Route::put('user/edit/simpan/{id}', [AdminUserController::class, 'update'])->name('user.update');
    Route::post('user/nonaktif/simpan/{id}', [AdminUserController::class, 'deactive'])->name('user.deactive');
});
