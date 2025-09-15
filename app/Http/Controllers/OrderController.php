<?php

namespace App\Http\Controllers;

use Session;
use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\PaymentHistories;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class OrderController extends Controller
{
    //redirect order page
    public function orderPage()
    {
        // Get the latest order for each order code using a subquery
        $orderList = Order::whereIn('id', function($query) {
            $query->select(DB::raw('MAX(id)'))
                  ->from('orders')
                  ->where('user_id', Auth::user()->id)
                  ->groupBy('order_code');
        })
        ->where('user_id', Auth::user()->id)
        ->orderBy('created_at', 'desc')
        ->get();

        return view('user.order.list', compact('orderList'));
    }

    //create order
    public function orderCreate(Request $request)
    {
        // dd($request->all());
        $order = Session::get('tmpCart');
        $paymentHistoryData = [
            'user_name' => $request->name,
            'phone' => $request->phone,
            'payment_method' => $request->payment,
            'order_code' => $request->order_code,
            'voucher_code' => $request->voucher_code,
            'total_amount' => $request->amount
        ];

        if ($request->hasFile('payslip')) {
            $filename = uniqid() . $request->file('payslip')->getClientOriginalName();
            $request->file('payslip')->move(public_path('payslip_image/'), $filename);
            $paymentHistoryData['payslip_image'] = $filename;
        }

        PaymentHistories::create($paymentHistoryData);

        foreach ($order as $item) {
            Order::create([
                'user_id' => $item['user_id'],
                'product_id' => $item['product_id'],
                'count' => $item['qty'],
                'status' => $item['status'],
                'order_code' => $item['order_code'],
            ]);
            Cart::where('user_id', $item['user_id'])->where('product_id', $item['product_id'])->delete();
        }
        Alert::success('Thank You For Order', 'Order Created Sucessfully');

        return to_route('user#orderPage');
    }
}
