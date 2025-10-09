<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Delivery;
use App\Models\DeliveryMans;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DeliveryController extends Controller
{
    //redirect delivery home
    public function home()
    {
        $shippingList = Order::select(
                'orders.order_code',
                \DB::raw('MAX(delivery_mans.name) as delivery_name'),
                \DB::raw('MAX(shipping_addresses.name) as shipping_name'),
                \DB::raw('MAX(shipping_addresses.email) as shipping_email'),
                \DB::raw('MAX(shipping_addresses.address) as shipping_address'),
                \DB::raw('MAX(shipping_addresses.city) as shipping_city'),
                \DB::raw('MAX(shipping_addresses.phone) as shipping_phone'),
                \DB::raw('MAX(shipping_addresses.order_note) as order_note'),
                \DB::raw('MAX(orders.created_at) as created_at')
            )
            ->join('delivery_mans', 'delivery_mans.id', '=', 'orders.delivery_man_id')
            ->join('shipping_addresses', 'shipping_addresses.order_code', '=', 'orders.order_code')
            ->where('status', 2)
            ->groupBy('orders.order_code')
            ->get();

        return view("admin.delivery.home", compact( "shippingList"));
    }

    //complete delivery
    public function completeDelivery(Request $request){

        Order::where('order_code', $request->order_code)->update([
            'status' => 4, // 4 = delivered
            'updated_at' => Carbon::now()
        ]);

        return redirect()->route('delivery#home')->with(['message' => 'Delivery marked as complete.']);
    }

    //view delievered order
    public function viewDelivered(){
        $deliveredList = Order::select(
                'orders.order_code',
                \DB::raw('MAX(delivery_mans.user_id) as user_id'),
                \DB::raw('MAX(users.name) as delivery_name'),
                \DB::raw('MAX(shipping_addresses.name) as shipping_name'),
                \DB::raw('MAX(shipping_addresses.email) as shipping_email'),
                \DB::raw('MAX(shipping_addresses.address) as shipping_address'),
                \DB::raw('MAX(shipping_addresses.city) as shipping_city'),
                \DB::raw('MAX(shipping_addresses.phone) as shipping_phone'),
                \DB::raw('MAX(shipping_addresses.order_note) as order_note'),
                \DB::raw('MAX(orders.created_at) as created_at'),
                \DB::raw('MAX(orders.updated_at) as updated_at')
            )
            ->join('delivery_mans', 'delivery_mans.id', '=', 'orders.delivery_man_id')
            ->join('shipping_addresses', 'shipping_addresses.order_code', '=', 'orders.order_code')
            ->join('users', 'users.id', '=', 'delivery_mans.user_id')
            ->where('status', 4) // 4 = delivered
            ->groupBy('orders.order_code')
            ->get();

        return view("admin.delivery.list", compact( "deliveredList"));
    }
}
