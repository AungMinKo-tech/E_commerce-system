<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    //redirect order list
    public function orderList(){
        $orders = Order::select([
                    'orders.order_code',
                    DB::raw('MIN(orders.created_at) AS created_at'),
                    DB::raw('MIN(orders.status) AS status'),
                    DB::raw('MIN(users.name) AS name'),
                    DB::raw('MIN(users.nickname) AS nickname'),
                    DB::raw('MIN(users.phone) AS phone'),
                    DB::raw('COUNT(*) AS items_count'),
                    DB::raw('ph.total_amount AS total_amount'),
                    DB::raw('pm.account_type AS account_type'),
                ])
                ->leftJoin('users', 'orders.user_id', '=', 'users.id')
                ->leftJoin('payment_histories as ph', 'orders.order_code', '=', 'ph.order_code')
                ->leftJoin('payments as pm', 'ph.payment_method', '=', 'pm.id')
                ->groupBy('orders.order_code', 'ph.total_amount', 'pm.account_type')
                ->orderBy('created_at', 'desc')
                ->paginate(10);

        return view("admin.order.list", compact("orders"));
    }

    //order details
    public function orderDetail($order_code){
        $order = Order::select([
                    'orders.order_code',
                    DB::raw('MIN(orders.created_at) AS created_at'),
                    DB::raw('MIN(orders.status) AS status'),
                    DB::raw('MIN(users.name) AS name'),
                    DB::raw('MIN(users.nickname) AS nickname'),
                    DB::raw('MIN(users.phone) AS phone'),
                    DB::raw('COUNT(*) AS items_count'),
                    DB::raw('ph.total_amount AS total_amount'),
                    DB::raw('pm.account_type AS account_type'),
                    DB::raw('ph.payslip_image'),
                ])
                ->leftJoin('users', 'orders.user_id', '=', 'users.id')
                ->leftJoin('payment_histories as ph', 'orders.order_code', '=', 'ph.order_code')
                ->leftJoin('payments as pm', 'ph.payment_method', '=', 'pm.id')
                ->where('orders.order_code', $order_code)
                ->groupBy('orders.order_code', 'ph.total_amount', 'ph.payslip_image', 'pm.account_type')
                ->first();

        $items = Order::select(
                    'orders.product_id',
                    'orders.count as quantity',
                    'products.name as product_name',
                    'products.price as price'
                )
                ->leftJoin('products', 'orders.product_id', '=', 'products.id')
                ->where('orders.order_code', $order_code)
                ->get();

        return view("admin.order.detail", compact("order", "items"));
    }
}
