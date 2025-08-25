<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;

    protected $fillable = [
        'voucher_code',
        'voucher_price',
        'max_usage',
        'use_count',
        'status',
        'start_date',
        'end_date'
    ];
}
