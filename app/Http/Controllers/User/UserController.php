<?php

namespace App\Http\Controllers\User;

use App\Models\Cart;
use App\Models\Order;
use App\Models\PaymentHistories;
use App\Models\Rating;
use App\Models\Comment;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Voucher;
use App\Models\Category;
use App\Models\Wishlist;
use App\Models\ProductColor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    //direct user home page
    public function home()
    {
        $categories = Category::all();

        $products = Product::select('products.*', 'categories.name as category_name', 'ratings.count')
            ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
            ->leftJoin('ratings', 'products.id', 'ratings.product_id')
            ->get();

        $wishlistProductIds = [];

        if (Auth::check()) {
            $wishlistProductIds = Wishlist::where('user_id', Auth::id())
                ->pluck('product_id')
                ->toArray();
        }

        $topSellings = Product::select('products.*')
            ->join('orders', 'products.id', '=', 'orders.product_id')
            ->selectRaw('SUM(orders.count) as total_sold')
            ->groupBy('products.id')
            ->orderByDesc('total_sold')
            ->take(8)
            ->get();

        return view('user.home.list', compact('categories', 'products', 'wishlistProductIds', 'topSellings'));
    }

    //wish list
    public function wishList(Request $request)
    {

        $userId = Auth::user()->id;
        $productId = $request->product_id;

        //wish list has / not has
        $exists = Wishlist::where('user_id', '=', $userId)
            ->where('product_id', '=', $productId)
            ->exists();

        if ($exists) {
            Wishlist::where('user_id', '=', $userId)
                ->where('product_id', '=', $productId)
                ->delete();

            $status = 'removed';

        } else {
            Wishlist::create([
                'user_id' => $userId,
                'product_id' => $productId,
                'count' => 1
            ]);
            $status = 'added';
        }

        $counts = Wishlist::where('user_id', '=', $userId)->sum('count');

        return response()->json([
            'status' => $status,
            'count' => $counts
        ]);
    }

    //view wish list
    public function viewWishList()
    {
        $userId = Auth::id();

        $wishlistItems = Wishlist::where('wishlists.user_id', $userId)
            ->join('products', 'wishlists.product_id', '=', 'products.id')
            ->select('products.*')
            ->get();

        $wishlistCount = Wishlist::where('user_id', $userId)->sum('count');

        return view('user.home.view_wishlist', compact('wishlistItems', 'wishlistCount'));
    }

    //view details product
    public function detailProduct($id)
    {
        $product = Product::select('products.*', 'categories.name as category_name')
            ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
            ->where('products.id', $id)
            ->first();

        $colors = ProductColor::select('colors.id as color_id', 'colors.name as color_name', 'product_colors.stock')
            ->leftJoin('colors', 'product_colors.color_id', '=', 'colors.id')
            ->where('product_colors.product_id', $id)
            ->get();

        $relatedProducts = Product::select('products.*', 'categories.name as category_name')
            ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
            ->where('products.category_id', $product->category_id)
            ->where('products.id', '!=', $id)
            ->get();

        $comments = Comment::select('comments.id as comment_id', 'comments.message', 'comments.created_at', 'users.id as user_id', 'users.profile', 'users.name', 'users.nickname', 'ratings.count as rating_count')
            ->where('comments.product_id', $id)
            ->leftJoin('users', 'users.id', 'comments.user_id')
            ->leftJoin('ratings', function ($join) {
                $join->on('ratings.user_id', '=', 'comments.user_id')
                    ->on('ratings.product_id', '=', 'comments.product_id');
            })
            ->orderBy('comments.created_at', 'desc')
            ->get();

        $avgRating = Rating::where('product_id', $id)->avg('count');
        $avgRating = $avgRating ? round($avgRating, 1) : 0;

        return view('user.product.details', compact('product', 'relatedProducts', 'colors', 'comments', 'avgRating'));
    }

    //comment
    public function addComment(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        Comment::create([
            'user_id' => Auth::id(),
            'product_id' => $request->product_id,
            'message' => $request->message,
        ]);

        if ($request->rating) {
            Rating::updateOrCreate(
                [
                    'user_id' => Auth::id(),
                    'product_id' => $request->product_id,
                ],
                [
                    'user_id' => Auth::id(),
                    'product_id' => $request->product_id,
                    'count' => $request->rating,
                ]
            );
        }

        Alert::success('Success', 'Comment added successfully');

        return back();
    }

    //direct cart page
    public function cartPage()
    {
        $carts = Cart::select('carts.*', 'colors.name as color_name', 'products.name as product_name', 'products.price', 'products.photo', 'products.id as product_id')
            ->leftJoin('products', 'carts.product_id', '=', 'products.id')
            ->leftJoin('colors', 'carts.color_id', '=', 'colors.id')
            ->where('carts.user_id', Auth::user()->id)
            ->get();

        $totalPrice = 0;
        foreach ($carts as $cart) {
            $totalPrice += $cart->price * $cart->qty;
        }

        return view('user.cart.cart', compact('carts', 'totalPrice'));
    }

    //add to cart
    public function addToCart(Request $request)
    {
        $productColor = ProductColor::where('product_id', $request->product_id)
            ->where('color_id', $request->color_id)
            ->first();

        if (!$productColor || $productColor->stock < $request->qty) {
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
    //cart delete
    public function cartDelete(Request $request)
    {
        // dd($request->all());
        $cartId = $request['cartId'];

        Cart::where('id', $cartId)->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'cart success'
        ], 200);
    }

    //orderlist tmp
    public function tmpOrder(Request $request)
    {
        $tmpOrder = [];

        foreach ($request->all() as $item) {
            array_push($tmpOrder, [
                'user_id' => $item['userId'],
                'product_id' => $item['productId'],
                'product_name' => $item['productName'],
                'color_id' => $item['colorId'],
                'qty' => $item['qty'],
                'price' => $item['price'],
                'status' => $item['status'],
                'order_code' => $item['orderCode'],
                'final_total' => $item['finalAmt'],
            ]);
        }
        Session::put('tmpCart', $tmpOrder);

        return response()->json([
            'status' => 'success',
            'message' => 'tmp order success'
        ], 200);
    }

    //direct checkout page
    public function checkOutPage()
    {
        $payments = Payment::select('id', 'account_number', 'account_name', 'account_type')->get();
        $tmpOrder = Session::get('tmpCart');
        $discount = Session::get('discount');
        $voucherUsed = Session::get('voucher_used');
        $voucherCode = Session::get('voucher_code');

        return view('user.cart.checkout', compact('payments', 'tmpOrder', 'discount', 'voucherUsed', 'voucherCode'));
    }

    //apply voucher
    public function applyVoucher(Request $request)
    {

        $userId = Auth::user()->id; //login user id
        $voucherCode = Voucher::where('voucher_code', $request->voucher_code)->first();
        $alreadyUsed = PaymentHistories::join('orders', 'payment_histories.order_code', '=', 'orders.order_code')
            ->where('orders.user_id', $userId)
            ->where('payment_histories.voucher_code', $request->voucher_code)
            ->first();

        if ($alreadyUsed) {
            return response()->json([
                'status' => 'error',
                'message' => 'Voucher code is already used!'
            ], 400);
        }

        if (!$voucherCode) {
            return response()->json([
                'status' => 'error',
                'message' => 'Voucher code is invalid'
            ], 400);
        }

        //check expiry date
        if ($voucherCode->end_date < now()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Voucher code has expired'
            ], 400);
        }

        //check usage limit
        if ($voucherCode->use_count >= $voucherCode->max_usage) {
            return response()->json([
                'status' => 'error',
                'message' => 'Voucher code usage limit reached'
            ], 400);
        }

        $finalAmount = $request->totalAmount - $voucherCode->voucher_price;

        // Ensure final amount doesn't go below 0
        if ($finalAmount < 0) {
            $finalAmount = 0;
        }

        Session::put(['discount' => $finalAmount]);
        Session::put(['voucher_id' => $voucherCode->id]);
        Session::put(['voucher_code' => $voucherCode->voucher_code]);
        Session::put(['voucher_used' => true]);

        return response()->json([
            'status' => 'success',
            'message' => 'Voucher applied successfully',
            'finalAmount' => $finalAmount
        ], 200);
    }

    //redirect category page
    public function category(Request $request)
    {
        $categories = Category::all();
        $productsQuery = Product::query();

        // Filter by category
        if ($request->filled('category')) {
            $productsQuery->whereIn('category_id', $request->category);
        }

        // Filter by minimum price
        if ($request->filled('price_min')) {
            $productsQuery->where('price', '>=', $request->price_min);
        }

        // Filter by maximum price
        if ($request->filled('price_max')) {
            $productsQuery->where('price', '<=', $request->price_max);
        }

        $products = $productsQuery->get();

        return view('user.home.category', compact('categories', 'products'));
    }
}
