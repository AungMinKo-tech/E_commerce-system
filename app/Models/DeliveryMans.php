<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryMans extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'document_cv',
        'license',
        'vehicle',
        'delivery_zone',
        'work_time'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function deliveries()
    {
        return $this->hasMany(Delivery::class, 'delivery_man_id');
    }
}
