<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_payment',
        'receiver_name', // nama penerima
        'receiver_address', //alamat penerima
        'receiver_phone', //nomor penerima
        'type', //pick-up-delivery, cash-on-delivery, bank
        'status', //menunggu pembayaran, pembayaran diterima, diproses, dikirim, diterima, dibatalkan, ditolak
        'connote', //no resi xxxxxxx
        'logistic', //jasa kirim xxxxxxxx
    ];

    public function paid()
    {
        return $this->belongsTo(Paid::class, 'id_payment', 'id_payment');
    }
}
