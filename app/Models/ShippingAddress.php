<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        "user_id",
        "name",
        "email",
        "address",
        "city",
        "phone",
        "order_code",
        "order_note"
    ];
}
