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
}
