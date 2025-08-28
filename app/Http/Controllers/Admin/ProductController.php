<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\Product_Color;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class ProductController extends Controller
{
    // //redirect product list page
    // public function listProduct(){
    //     return view("");
    // }

    //redirect add product page
    public function addProductPage(){
        $categories = Category::all();
        $colors = Color::all();

        return view("admin.product.add", compact("categories", "colors"));
    }

    //create product
    public function createProduct(Request $request){
        // dd($request->all());
        $this->checkProductValidate($request);

        $filename = uniqid() . $request->file('image')->getClientOriginalName();
        $request->file('image')->move(public_path('product_image/'), $filename);
        $request->image = $filename;

        $product = Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'photo' => $request->image,
            'description' => $request->description,
            'category_id' => $request->category_id,
        ]);

        foreach ($request->colors_id as $key => $color_id) {
            Product_Color::create([
                'product_id' => $product->id,
                'color_id'=> $color_id,
                'stock' => $request->stocks[$key]
            ]);
        }

        Alert::success('Title', 'Product Created Successfully!');

        return back();
    }

    //check create product validation
    private function checkProductValidate(Request $request){
        $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric',
            'image' => 'required|file|image',
            'description' => 'required|string',
            'category_id' => 'required|integer|exists:categories,id',
            'colors_id' => 'required|array|min:1',
            'colors_id.*' => 'integer|exists:colors,id',
            'stocks' => 'required|array',
            'stocks.*' => 'integer|min:0',
        ]);
    }

}
