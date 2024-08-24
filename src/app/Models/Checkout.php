<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checkout extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_user',
        'id_shipping', //untuk mendapatkan alamat user
        'invoice', //invoice yang dilampirkan ke user
        'id_payment', //id buat bayar harus sama untuk seluruh barang yg ada di basket sebelum dibayarin nantinya. Contoh : PAY20240726211220123
        'id_product', //id product boleh beda2
        'quantity', //jumlah barang
        'original_price', //harga original sebelum diskon
        'display_price', //harga diskon
        'total_price', //harga total setelah ada potongan diskon jika ada
        'fee_shipping',
        'fee_package',
        'discount_shipping',
        'discount_package',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'id_product');
    }

    public function paid()
    {
        return $this->belongsTo(Paid::class, 'id_payment', 'id_payment');
    }
}
