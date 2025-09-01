<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class PaymentController extends Controller
{
    //redirect payment page
    public function listPayment(){
        $payments = Payment::orderBy("id","desc")->paginate(10);

        return view("admin.payment.list", compact("payments"));
    }

    //create payment method
    public function paymentCreate(Request $request){
        // dd($request->all());
        $this->checkPayment($request);

        Payment::create([
            "account_name" => $request->account_name,
            "account_number"=> $request->account_number,
            "account_type" => $request->account_type,
        ]);

        Alert::success("Title", "Payment Created Successfully");

        return back();
    }

    //check validate payment data
    private function checkPayment($request){
        $request->validate([
            'account_name' => 'required',
            'account_number'=> 'required',
            'account_type'=> 'required',
        ]);
    }
}
