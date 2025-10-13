<?php

namespace App\Http\Controllers\Admin;

use App\Models\DeliveryMans;
use App\Models\Order;
use App\Models\ShippingAddress;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    //redirect order list
    public function orderList()
    {
        $orders = Order::select([
            'orders.order_code',
            DB::raw('MIN(orders.created_at) AS created_at'),
            DB::raw('MIN(orders.status) AS status'),
            DB::raw('MIN(orders.delivery_name) AS delivery_name'),
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
            ->orderBy('created_at', 'asc')
            ->paginate(10);

        return view("admin.order.list", compact("orders"));
    }

    //order details
    public function orderDetail($order_code)
    {
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
            DB::raw('ph.voucher_code'),
            DB::raw('ph.payslip_image'),
            DB::raw('MIN(ph.transaction_id) AS transaction_id'),
        ])
            ->leftJoin('users', 'orders.user_id', '=', 'users.id')
            ->leftJoin('payment_histories as ph', 'orders.order_code', '=', 'ph.order_code')
            ->leftJoin('payments as pm', 'ph.payment_method', '=', 'pm.id')
            ->where('orders.order_code', $order_code)
            ->groupBy('orders.order_code', 'ph.total_amount', 'ph.payslip_image', 'pm.account_type', 'ph.voucher_code')
            ->first();

        $items = Order::select(
            'orders.product_id',
            'orders.count as quantity',
            'products.name as product_name',
            'products.photo as product_photo',
            'products.price as price',
            'colors.name as color_name'
        )
            ->leftJoin('products', 'orders.product_id', '=', 'products.id')
            ->leftJoin('colors', 'orders.color_id', '=', 'colors.id')
            ->where('orders.order_code', $order_code)
            ->get();

        $deliveryMans = DeliveryMans::select('users.name as delivery_name', 'delivery_mans.id')
                    ->leftJoin('users', 'delivery_mans.user_id', '=', 'users.id')
                    ->get();

        $userId = Order::where('order_code', $order_code)->value('user_id');
        $shipping = null;
        if ($userId) {
            $shipping = ShippingAddress::where('user_id', $userId)
                ->latest()
                ->first();
        }

        return view("admin.order.detail", compact("order", "items", "shipping", "deliveryMans"));
    }

    //accept shipping reject order
    public function confirmOrder(Request $request){

        // dd($request->all());
        $request->validate([
            'order_code' => 'required|string',
            'status' => 'required|integer|in:1,2,3,4',
            'delivery_info' => 'nullable|string'
        ]);

        $orderData = [
            'status' => $request->status,
        ];

        if($request->delivery_info) {
            list($deliveryManId, $deliveryName) = explode('|', $request->delivery_info);
            $orderData['delivery_name'] = $deliveryName;
            $order['delivery_man_id'] = $deliveryManId;
        }

        $orderCode = $request->order_code;

        $order = Order::where('order_code', $orderCode);
        $order->update($orderData);

        return redirect()->route('admin#orderDetail', $orderCode)
            ->with('success', 'Order status updated successfully!');
    }
}
