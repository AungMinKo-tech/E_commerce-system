<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class VoucherController extends Controller
{
    public function listVoucher()
    {
        $vouchers = Voucher::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.voucher.list', compact('vouchers'));
    }

    public function createVoucherPage()
    {
        return view('admin.voucher.create');
    }

    public function createVoucher(Request $request)
    {
        // dd($request->all());
        $this->checkVoucher($request);

        Voucher::create([
            'voucher_code' => $request->voucher_code,
            'voucher_price' => $request->voucher_price,
            'max_usage' => $request->max_usage,
            'use_count' => 0,
            'status' => $request->status,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date
        ]);

        Alert::success('Title', 'Voucher Created Successfully!');

        return to_route('admin#voucherList');
    }

    public function editVoucher($id)
    {
        $voucher = Voucher::findOrFail($id);
        return view('admin.voucher.edit', compact('voucher'));
    }

    public function updateVoucher(Request $request, $id)
    {
        $voucher = Voucher::findOrFail($id);

        $request->merge(['id' => $id]);

        $this->checkVoucher($request);

        $voucher->update([
            'voucher_code' => $request->voucher_code,
            'voucher_price' => $request->voucher_price,
            'max_usage' => $request->max_usage,
            'use_count' => 0,
            'status' => $request->status,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date
        ]);

        Alert::success('Title', 'Voucher Updated Successfully!');

        return to_route('admin#voucherList');
    }

    public function deleteVoucher($id)
    {
        try {
            $voucher = Voucher::findOrFail($id);
            $voucher->delete();

            Alert::success('Success', 'Voucher deleted successfully!');
            return redirect()->route('admin#voucherList');
        } catch (\Exception $e) {
            Alert::error('Error', 'Failed to delete voucher. Please try again.');
            return redirect()->back();
        }
    }

    //check voucher validation
    private function checkVoucher(Request $request)
    {
        $request->validate([
            'voucher_code' => 'required|string|max:50|unique:vouchers,voucher_code,'. $request->id,
            'voucher_price' => 'required|numeric|min:0',
            'max_usage' => 'required|integer|min:1',
            'status' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ], [
            'voucher_code.required' => 'Voucher code is required.',
            'voucher_code.unique' => 'This voucher code already exists.',
            'voucher_price.required' => 'Discount amount is required.',
            'voucher_price.min' => 'Discount amount must be at least 0.',
            'max_usage.required' => 'Maximum usage is required.',
            'max_usage.min' => 'Maximum usage must be at least 1.',
            'status.required' => 'Status is required.',
            'start_date.required' => 'Start date is required.',
            'start_date.after_or_equal' => 'Start date must be today or later.',
            'end_date.required' => 'End date is required.',
            'end_date.after' => 'End date must be after start date.',
        ]);
    }
}
