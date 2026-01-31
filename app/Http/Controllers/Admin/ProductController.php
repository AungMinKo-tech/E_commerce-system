<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\ProductColor;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class ProductController extends Controller
{
    // redirect product list page
    public function listProduct($action = 'default')
    {
        $products = Product::select('products.id as product_id', 'products.name as product_name', 'products.price', 'products.photo', 'products.description', 'products.detail', 'categories.id as category_id', 'categories.name as category_name', 'product_colors.id as product_color_id', 'product_colors.stock', 'colors.name as color_name', 'products.created_at', 'colors.id as color_id')
            ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
            ->leftJoin('product_colors', 'products.id', '=', 'product_colors.product_id')
            ->leftJoin('colors', 'product_colors.color_id', '=', 'colors.id')
            ->orderBy('products.created_at', 'desc')
            ->paginate(5);

        $categories = Category::get();

        return view('admin.product.list', compact('products', 'categories'));
    }

    // redirect add product page
    public function addProductPage()
    {
        $categories = Category::all();
        $colors = Color::all();

        return view('admin.product.add', compact('categories', 'colors'));
    }

    // create product
    public function createProduct(Request $request)
    {
        // dd($request->all());
        $this->checkProductValidate($request, 'createProduct');
        $data = $this->getData($request);

        $filename = uniqid().$request->file('photo')->getClientOriginalName();
        $request->file('photo')->move(public_path('product_image/'), $filename);
        $data['photo'] = $filename;

        $product = Product::create($data);

        foreach ($request->colors_id as $key => $color_id) {
            ProductColor::create([
                'product_id' => $product->id,
                'color_id' => $color_id,
                'stock' => $request->stocks[$key],
            ]);
        }

        Alert::success('Title', 'Product Created Successfully!');

        return back();
    }

    // delete product
    public function deleteProduct(Request $request)
    {
        // dd($request->all());
        $color = ProductColor::find($request->product_color_id);
        $product = Product::find($request->product_id);

        // check remaing color
        $remainingColors = ProductColor::where('product_id', $request->product_id)->count();

        $color->delete();

        // the last color delete the product
        if ($remainingColors == 1) {
            if ($request->photo && file_exists(public_path('product_image/'.$request->photo))) {
                unlink(public_path('product_image/'.$request->photo));
            }

            $product->delete();

            Alert::success('Title', 'Product Deleted Successfully!');

            return back();
        }

        Alert::success('Title', 'Product Deleted Successfully!');

        return back();
    }

    // edit page view
    public function editProduct($id)
    {
        $product = Product::where('products.id', $id)
            ->leftJoin('product_colors', 'products.id', '=', 'product_colors.product_id')
            ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
            ->leftJoin('colors', 'product_colors.color_id', '=', 'colors.id')
            ->select(
                'products.*',
                'categories.name as category_name',
                'colors.name as color_name',
                'product_colors.stock'
            )
            ->first();

        $categories = Category::all();
        $colors = Color::all();

        return view('admin.product.edit', compact('product', 'categories', 'colors'));
    }

    // update product
    public function updateProduct(Request $request)
    {
        // dd($request->all());

        // $this->checkProductValidate($request, 'updateProduct');

        $data = $this->getData($request);

        // Handle photo update
        if ($request->hasFile('photo')) {
            $oldImageName = $request->productImage; // old image name

            if ($oldImageName && file_exists(public_path('product_image/'.$oldImageName))) {
                unlink(public_path('product_image/'.$oldImageName));
            }

            $filename = uniqid().$request->file('photo')->getClientOriginalName();
            $request->file('photo')->move(public_path('product_image/'), $filename);
            $data['photo'] = $filename;
        } else {
            $data['photo'] = $request->productImage;
        }

        Product::where('id', $request->product_id)->update($data);

        // Update current product color
        $existingProductColor = ProductColor::where('product_id', $request->product_id)->first();

        if (! $existingProductColor) {
            // Update existing record with new color and stock
            $existingProductColor->update([
                'color_id' => $request->color_id,
                'stock' => $request->stock,
            ]);
        } else {
            $existingProductColor->update([
                'stock' => $request->stock,
            ]);
        }

        Alert::success('Title', 'Product Changed Successfully');

        return to_route('admin#productList');
    }

    // redirect details page
    public function detailsProduct($id, $colorId)
    {
        $product = ProductColor::where([
            ['product_id', '=', $id],
            ['color_id', '=', $colorId],
        ])
            ->leftJoin('products', 'product_colors.product_id', '=', 'products.id')
            ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
            ->leftJoin('colors', 'product_colors.color_id', '=', 'colors.id')
            ->select(
                'products.*',
                'categories.name as category_name',
                'colors.name as color_name',
                'product_colors.stock',
                'product_colors.color_id'
            )
            ->first();

        return view('admin.product.details', compact('product'));
    }

    // get data
    private function getData($request)
    {
        return [
            'name' => $request->name,
            'category_id' => $request->category_id,
            'price' => $request->price,
            'description' => $request->description,
            'detail' => $request->detail,
        ];
    }

    // check create product validation
    private function checkProductValidate($request, $action)
    {
        $rules = ([
            'name' => 'required|min:2|max:30|unique:products,name,'.$request->product_id,
            'price' => 'required|numeric',
            'description' => 'required|string',
            'detail' => 'required|string',
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
