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
        $products = Product::all();

        return view('user.home.list', compact('categories', 'products'));
    }
}
