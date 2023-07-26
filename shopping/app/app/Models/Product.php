<?php

namespace App\Models;

use App\Models\category;
use App\Models\ProductColor;
use App\Models\ProductImage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $fillable = [
        'name',
        'slug',
        'status',
        'category_id',
        'brand',
        'small_description',
        'description',
        'original_price',
        'selling_price',
        'quantity',
        'trending',
        'status',
        'meta_title',
        'meta_description',
        'meta_keyword'
    ];
    public function category()
    {
        return $this->belongsTo(category::class, 'category_id', 'id');
    }
    public function protectImages()
    {
        return $this->hasMany(ProductImage::class, 'product_id', 'id');
    }
    public function productColors()
    {
        return $this->hasMany(ProductColor::class, 'product_id', 'id');
    }

}
