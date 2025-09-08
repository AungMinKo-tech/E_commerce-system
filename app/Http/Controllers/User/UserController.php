<?php

namespace App\Http\Controllers\User;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    //direct user home page
    public function home()
    {
        $categories = Category::all();

        $products = Product::select('products.*', 'categories.name as category_name')
                    ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
                    ->get();

        return view('user.home.list', compact('categories', 'products'));
    }
}
