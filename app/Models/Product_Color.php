<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product_Color extends Model
{
    use HasFactory;

    protected $fillable = [
        "product_id",
        "color_id",
        "stock"
    ];
}
