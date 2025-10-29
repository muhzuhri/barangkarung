<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'brand',
        'size',
        'description',
        'price',
        'original_price',
        'discount_percentage',
        'image',
        'stock',
        'is_active'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'original_price' => 'decimal:2',
        'is_active' => 'boolean'
    ];

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return null;
        }

        if (str_starts_with($this->image, 'img/')) {
            return asset($this->image);
        }

        return asset('storage/' . $this->image);
    }
}
