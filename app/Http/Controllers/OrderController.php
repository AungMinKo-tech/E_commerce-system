<?php

namespace App\Http\Controllers;

use App\Models\ProductColor;
use App\Models\ShippingAddress;
use App\Models\Voucher;
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
        // Get orders grouped by order_code
        $orderList = Order::select('orders.*', 'products.name as product_name', 'products.photo as product_photo', 'products.price', 'payment_histories.total_amount', 'payment_histories.voucher_code')
            ->leftJoin('products', 'orders.product_id', '=', 'products.id')
            ->leftJoin('payment_histories','orders.order_code','=','payment_histories.order_code')
            ->where('orders.user_id', Auth::user()->id)
            ->orderBy('orders.created_at', 'desc')
            ->get()
            ->groupBy('order_code');

        return view('user.order.list', compact('orderList'));
    }

    //create order
    public function orderCreate(Request $request)
    {
        // dd($request->all());
        $order = Session::get('tmpCart');

        try {
            DB::transaction(function () use ($request, $order) {
                $paymentHistoryData = [
                    'user_id' => Auth::user()->id,
                    'payment_name' => $request->name,
                    'phone' => $request->phone,
                    'payment_method' => $request->payment,
                    'transaction_id'=> $request->transaction_id,
                    'order_code' => $request->order_code,
                    'voucher_code' => Session::get('voucher_code'),
                    'total_amount' => $request->amount
                ];

                if ($request->hasFile('payslip')) {
                    $filename = uniqid() . $request->file('payslip')->getClientOriginalName();
                    $request->file('payslip')->move(public_path('payslip_image/'), $filename);
                    $paymentHistoryData['payslip_image'] = $filename;
                }

                PaymentHistories::create($paymentHistoryData);

                ShippingAddress::create([
                    'user_id'=> Auth::user()->id,
                    'name' => $request->ship_name,
                    'phone'=> $request->ship_phone,
                    'email'=> $request->ship_email,
                    'address' => $request->ship_address,
                    'city' => $request->ship_city,
                    'order_code' => $request->order_code,
                    'order_note' => $request->order_note
                ]);

                foreach ($order as $item) {
                    $productColor = ProductColor::where('product_id', $item['product_id'])
                        ->where('color_id', $item['color_id'])
                        ->lockForUpdate()
                        ->first();

                    if (!$productColor || $productColor->stock < $item['qty']) {
                        throw new \Exception('Insufficient stock for the selected color.');
                    }

                    $productColor->stock = $productColor->stock - $item['qty'];
                    $productColor->save();

                    Order::create([
                        'user_id' => $item['user_id'],
                        'product_id' => $item['product_id'],
                        'color_id' => $item['color_id'],
                        'count' => $item['qty'],
                        'status' => $item['status'],
                        'order_code' => $item['order_code'],
                    ]);

                    Cart::where('user_id', $item['user_id'])
                        ->where('product_id', $item['product_id'])
                        ->where('color_id', $item['color_id'])
                        ->delete();
                }

                // delete after successful order
                $voucherId = Session::get('voucher_id');
                if ($voucherId) {
                    $voucher = Voucher::lockForUpdate()->find($voucherId);
                    if (!$voucher) {
                        throw new \Exception('Invalid voucher.');
                    }

                    // adjust usage counters as requested
                    $voucher->use_count = $voucher->use_count + 1;
                    $voucher->max_usage = max(0, $voucher->max_usage - 1);
                    $voucher->save();

                    // clear voucher session flags post successful order
                    Session::forget('voucher_used');
                    Session::forget('voucher_code');
                    Session::forget('voucher_id');
                    Session::forget('discount');
                }
            });
        } catch (\Throwable $e) {
            Alert::error('Fail', $e->getMessage());
            return back();
        }

        Alert::success('Thank You For Order', 'Order Created Sucessfully');

        return to_route('user#orderPage');
    }
}
