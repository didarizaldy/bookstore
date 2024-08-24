<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shipping extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id_user',
        'receiver_name',
        'tag',
        'address',
        'notes',
        'maps',
        'phone',
        'created_by',
        'edited_by',
        'is_default',
    ];

    // Relationship to Product
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
