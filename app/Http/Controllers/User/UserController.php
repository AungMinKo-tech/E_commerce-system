<?php

namespace App\Http\Controllers\User;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Category;
use App\Models\Wishlist;
use App\Models\ProductColor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    //direct user home page
    public function home()
    {
        $categories = Category::all();

        $products = Product::select('products.*', 'categories.name as category_name')
                    ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
                    ->get();

        $wishlistProductIds = [];

        if (Auth::check()) {
            $wishlistProductIds = Wishlist::where('user_id', Auth::id())
                ->pluck('product_id')
                ->toArray();
        }

        return view('user.home.list', compact('categories', 'products', 'wishlistProductIds'));
    }

    //wish list
    public function wishList(Request $request){

        $userId = Auth::user()->id;
        $productId = $request->product_id;

        //wish list has / not has
        $exists = Wishlist::where('user_id','=', $userId)
                ->where('product_id','=', $productId)
                ->exists();

        if($exists){
            Wishlist::where('user_id','=', $userId)
                ->where('product_id','=', $productId)
                ->delete();

            $status = 'removed';

        }else{
            Wishlist::create([
                'user_id' => $userId,
                'product_id' => $productId,
                'count'=> 1
            ]);
                $status = 'added';
        }

        $counts = Wishlist::where('user_id','=', $userId)->sum('count');

        return response()->json([
            'status' => $status,
            'count'=> $counts
        ]);
    }

    //view wish list
    public function viewWishList(){
        $userId = Auth::id();

        $wishlistItems = Wishlist::where('wishlists.user_id', $userId)
            ->join('products', 'wishlists.product_id', '=', 'products.id')
            ->select('products.*')
            ->get();

        $wishlistCount = Wishlist::where('user_id', $userId)->sum('count');

        return view('user.home.view_wishlist', compact('wishlistItems', 'wishlistCount'));
    }

    //view details product
    public function detailProduct($id){
        $product = Product::select('products.*', 'categories.name as category_name')
                ->leftJoin('categories','products.category_id','=', 'categories.id')
                ->where('products.id', $id)
                ->first();

        $colors = ProductColor::select('colors.id as color_id', 'colors.name as color_name', 'product_colors.stock')
                ->leftJoin('colors','product_colors.color_id','=','colors.id')
                ->where('product_colors.product_id', $id)
                ->get();

        $relatedProducts = Product::select('products.*', 'categories.name as category_name')
                ->leftJoin('categories','products.category_id','=', 'categories.id')
                ->where('products.category_id', $product->category_id)
                ->where('products.id', '!=', $id)
                ->get();

        return view('user.product.details', compact('product', 'relatedProducts', 'colors'));
    }

    //direct cart page
    public function cartPage(){
        $carts = Cart::select('carts.*', 'colors.name as color_name', 'products.name as product_name', 'products.price', 'products.photo')
                ->leftJoin('products','carts.product_id','=','products.id')
                ->leftJoin('colors','carts.color_id','=','colors.id')
                ->where('carts.user_id', Auth::user()->id)
                ->get();

        $totalPrice = 0;
        foreach ($carts as $cart) {
            $totalPrice += $cart->price * $cart->qty;
        }

        return view('user.cart.cart', compact('carts', 'totalPrice'));
    }

    //add to cart
    public function addToCart(Request $request){
        $productColor = ProductColor::where('product_id', $request->product_id)
                                    ->where('color_id', $request->color_id)
                                    ->first();

        if(!$productColor || $productColor->stock < $request->qty){
            Alert::error('Fail', 'Product stock not enough');
            return back();
        }

        $cartItem = Cart::where('user_id', $request->user_id)
                        ->where('product_id', $request->product_id)
                        ->where('color_id', $request->color_id)
                        ->first();

        if ($cartItem) {
            $cartItem->qty += $request->qty;
            $cartItem->save();
        } else {
            // Create a new cart item
            Cart::create([
                'user_id' => $request->user_id,
                'product_id' => $request->product_id,
                'color_id' => $request->color_id,
                'qty' => $request->qty
            ]);
        }

        Alert::success('Success', 'Product added to cart');

        return back();
    }
}
