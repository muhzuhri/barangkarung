<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_code',
        'shipping_address',
        'phone',
        'shipping_method',
        'payment_method',
        'notes',
        'subtotal',
        'shipping_cost',
        'service_fee',
        'discount',
        'total',
        'status',
    ];



    protected $casts = [
        'order_date' => 'datetime',
    ];
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}