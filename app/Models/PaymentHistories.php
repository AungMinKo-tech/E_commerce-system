<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentHistories extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'payment_name',
        'phone',
        'total_amount',
        'payslip_image',
        'payment_method',
        'order_code',
        'voucher_code'
    ];
}
