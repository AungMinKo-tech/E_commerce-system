<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\Product_Color;
use App\Models\ProductColor;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class ProductController extends Controller
{
    //redirect product list page
    public function listProduct(){
        $products = Product::select('products.id','products.name as product_name', 'products.price', 'products.photo', 'products.description', 'categories.id as category_id', 'categories.name as category_name', 'product_colors.id as product_color_id', 'product_colors.stock', 'colors.name as color_name', 'products.created_at')
                 ->leftJoin('categories','products.category_id','=','categories.id')
                 ->leftJoin('product_colors','products.id','=','product_colors.product_id')
                 ->leftJoin('colors','product_colors.color_id','=','colors.id')
                 ->orderBy('products.created_at','desc')
                 ->paginate(5);

        $categories = Category::get();

        return view("admin.product.list", compact("products", 'categories'));
    }

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
            ProductColor::create([
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
