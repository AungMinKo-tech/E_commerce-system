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
    public function listProduct($action = "default")
    {
        $products = Product::select('products.id as product_id', 'products.name as product_name', 'products.price', 'products.photo', 'products.description', 'categories.id as category_id', 'categories.name as category_name', 'product_colors.id as product_color_id', 'product_colors.stock', 'colors.name as color_name', 'products.created_at')
            ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
            ->leftJoin('product_colors', 'products.id', '=', 'product_colors.product_id')
            ->leftJoin('colors', 'product_colors.color_id', '=', 'colors.id')
            ->orderBy('products.created_at', 'desc')
            ->paginate(5);

        $categories = Category::get();

        return view("admin.product.list", compact("products", 'categories'));
    }

    //redirect add product page
    public function addProductPage()
    {
        $categories = Category::all();
        $colors = Color::all();

        return view("admin.product.add", compact("categories", "colors"));
    }

    //create product
    public function createProduct(Request $request)
    {
        // dd($request->all());
        $this->checkProductValidate($request, 'createProduct');
        $data = $this->getData($request);

        $filename = uniqid() . $request->file('photo')->getClientOriginalName();
        $request->file('photo')->move(public_path('product_image/'), $filename);
        $data['photo'] = $filename;

        $product = Product::create( $data );

        foreach ($request->colors_id as $key => $color_id) {
            ProductColor::create([
                'product_id' => $product->id,
                'color_id' => $color_id,
                'stock' => $request->stocks[$key]
            ]);
        }

        Alert::success('Title', 'Product Created Successfully!');

        return back();
    }

    //delete product
    public function deleteProduct(Request $request)
    {
        // dd($request->all());
        $color = ProductColor::find($request->product_color_id);
        $product = Product::find($request->product_id);

        //check remaing color
        $remainingColors = ProductColor::where('product_id', $request->product_id)->count();

        $color->delete();

        // the last color delete the product
        if ($remainingColors == 1) {
            if ($request->photo && file_exists(public_path('product_image/' . $request->photo))) {
                unlink(public_path('product_image/' . $request->photo));
            }

            $product->delete();

            Alert::success('Title', 'Product Deleted Successfully!');

            return back();
        }

        Alert::success('Title', 'Product Deleted Successfully!');

        return back();

    }

    //edit page view
    public function editProduct($id)
    {
        $product = Product::select('products.id as product_id', 'products.name as product_name', 'products.price', 'products.photo', 'products.description', 'categories.id as category_id', 'categories.name as category_name', 'product_colors.id as product_color_id', 'product_colors.stock', 'colors.name as color_name', 'products.created_at')
            ->leftJoin('product_colors', 'products.id', '=', 'product_colors.product_id')
            ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
            ->leftJoin('colors', 'product_colors.color_id', '=', 'colors.id')
            ->first();

        $categories = Category::all();
        $colors = Color::all();

        return view('admin.product.edit', compact('product', 'categories', 'colors'));
    }

    //update product
    public function updateProduct(Request $request)
    {

        $this->checkProductValidate($request, 'updateProduct');

        $product = Product::find($request->product_id);
        $data = $this->getData($request);
        $remainProduct = ProductColor::where('product_id', $request->product_id)->count();

        if ($remainProduct != 1) {
            if ($request->hasFile('photo')) {
                $filename = uniqid() . $request->file("photo")->getClientOriginalName();
                $request->file("photo")->move(public_path('product_image/') , $filename);
                $data['photo'] = $filename;
            }else{
                $data['photo'] = $request->photo;
            }
        }else{
            //
        }

        dd($request->all());

    }

    //get data
    private function getData($request){
        return [
            'name' => $request->name,
            'category_id' => $request->categoryId,
            'price' => $request->price,
            'description' => $request->description,
        ];
    }

    //check create product validation
    private function checkProductValidate($request, $action)
    {
        $rules = ([
            'name' => 'required|min:2|max:30|unique:products,name,' . $request->product_id,
            'price' => 'required|numeric',
            'description' => 'required|string',
            'category_id' => 'required|integer|exists:categories,id',
            'colors_id' => 'required|array|min:1',
            'colors_id.*' => 'integer|exists:colors,id',
            'stocks' => 'required|array',
            'stocks.*' => 'integer|min:0',
        ]);

        $rules['photo'] = $action == 'createProduct' ? 'required|file|mimes:jpg,jpeg,png,webp,gif' : 'file|mimes:jpg,jpeg,png,webp,gif';

        $message = [];

        $request->validate($rules, $message);
    }

}
