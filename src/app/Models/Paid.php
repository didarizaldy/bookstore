<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paid extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_user',
        'id_payment',
        'id_shipping',
        'total_item',
        'status',
        'payment',
        'id_bankaccount',
        'total_fee_shipping',
        'total_fee_package',
        'total_price_item',
        'total_pay',
        'paid_name',
        'paid_code_bank',
        'paid_number_bank',
        'paid_proof_link',
        'paid_at',
        'expired_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function bank()
    {
        return $this->belongsTo(BankAccount::class, 'id_bankaccount');
    }

    public function shipping()
    {
        return $this->belongsTo(Shipping::class, 'id_shipping');
    }

    public function delivery()
    {
        return $this->belongsTo(Delivery::class, 'id_payment', 'id_payment');
    }

    public function checkout()
    {
        return $this->hasMany(Checkout::class, 'id_payment', 'id_payment');
    }
}
