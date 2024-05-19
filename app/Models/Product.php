<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    public function productDetails()
    {
        return $this->hasMany(ProductDetail::class);
    }
    public function productImages()
    {
        return $this->hasMany(ProductImage::class);
    }
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
}
