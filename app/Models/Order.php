<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
protected $fillable = [
    'restaurant_table_id',
    'nama_customer',
    'jenis_pesanan',
    'total',
    'status',
    'payment_status',
    'queue_number',
    'nomor_meja_manual',
    'catatan',
    'snap_token',
    'payment_method',
    'subtotal',
    'discount_type',
    'discount_value',
    'discount_amount',
    'user_id',
];

public function table()
{
    return $this->belongsTo(RestaurantTable::class,
                            'restaurant_table_id');
}

public function items()
{
    return $this->hasMany(OrderItem::class);
}

public function user()
{
    return $this->belongsTo(User::class);
}
}