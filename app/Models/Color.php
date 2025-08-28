<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

	public function products()
	{
		return $this->belongsToMany(Product::class, 'product__colors', 'color_id', 'product_id')
			->withPivot('stock')
			->withTimestamps();
	}
}
