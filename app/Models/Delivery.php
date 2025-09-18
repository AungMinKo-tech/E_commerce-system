<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    use HasFactory;

    protected $fillable = [
        "delivery_man_id",
        "user_id",
        "order_id",
        "status",
        "delivery_at"
    ];

    public function deliveryMan()
    {
        return $this->belongsTo(DeliveryMans::class, 'delivery_man_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
