<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'sku', //sudah
        'id_category', //sudah
        'title', //sudah
        'slug', //sudah
        'filename_img', //sudah
        'author',
        'publisher',
        'original_price', //sudah
        'display_price', //sudah
        'discount', //sudah
        'pages', //sudah
        'release_at',
        'isbn', //sudah
        'lang', //sudah
        'stocks', //sudah
        'available',
        'created_by',
        'updated_by',
    ];

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'id_category');
    }
}
