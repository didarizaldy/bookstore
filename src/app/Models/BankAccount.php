<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'bank_code',
        'bank_name',
        'account_name',
        'account_code',
        'active',
        'created_by',
        'updated_by',
    ];
}
