<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Basket extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_user',
        'id_product',
        'quantity'
    ];

    // Relationship to User
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    // Relationship to Product
    public function product()
    {
        return $this->belongsTo(Product::class, 'id_product');
    }
}
