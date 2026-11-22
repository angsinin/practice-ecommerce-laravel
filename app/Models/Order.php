<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'customer_id',
        'shipping_method',
        'shipping_fee',
        'discount',
        'payment_method',
        'subtotal',
        'grand_total',
        'order_status',
        'payment_status',
    ];

    protected $casts = [
        'shipping_fee' => 'decimal:2',
        'discount' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'grand_total' => 'decimal:2',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
