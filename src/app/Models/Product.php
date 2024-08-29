<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'sku',
        'id_category',
        'title',
        'slug',
        'filename_img',
        'author',
        'publisher',
        'original_price',
        'display_price',
        'discount',
        'pages',
        'release_at',
        'isbn',
        'lang',
        'stocks',
        'available',
        'created_by',
        'updated_by',
    ];

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'id_category');
    }
}
