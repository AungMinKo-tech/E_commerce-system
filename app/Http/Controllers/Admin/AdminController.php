<?php

namespace App\Http\Controllers\Admin;

use App\Models\Contact;
use App\Models\PaymentHistories;
use App\Models\User;
use App\Models\Color;
use App\Models\Order;
use App\Models\Category;
use App\Models\Delivery;
use App\Models\DeliveryMans;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class AdminController extends Controller
{
    //redirect admin dashboard
    public function dashboard()
    {
        $users = User::latest()->paginate(10);

        return view('admin.home.dashboard', compact('users'));
    }

    public function userDetail($id) {
        $user = User::find($id);

        return view('admin.home.userdetails', compact('user'));
    }

    public function deleteUser(Request $request) {
        // dd($request->toArray());
        User::find($request->id, 'id')->delete();

        return to_route('admin#dashboard');
    }

    //add new admin & delivery man
    public function newAdminPage()
    {
        return view('admin.home.add');
    }

    //add new admin
    public function newAdmin(Request $request)
    {
        $this->checkAdminValidate($request);

        $filename = uniqid() . $request->file('documents')->getClientOriginalName();
        $request->file('documents')->move(public_path('cv_form/'), $filename);
        $request->documents = $filename;

        $data = $this->getAdminData($request);

        User::create($data);

        Alert::success('Success', 'Admin Account Created!');

        return back();
    }

    //redirect new delivery page
    public function newDeliveryPage()
    {
        return view('admin.home.delivery');
    }

    //add new delivery
    public function newDelivery(Request $request)
    {
        $this->checkNewDelivery($request);

        // dd($request->all());

        $filename = uniqid() . $request->file('documents')->getClientOriginalName();
        $request->file('documents')->move(public_path('cv_form/'), $filename);
        $request->documents = $filename;

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role' => $request->role,
            'address' => $request->address,
            'password' => Hash::make($request->password)
        ]);

        DeliveryMans::create([
            'user_id' => $user->id,
            'document_cv' => $request->documents,
            'license' => $request->license_number,
            'vehicle' => $request->vehicle_type,
            'delivery_zone' => $request->delivery_zone,
            'work_time' => $request->preferred_shift
        ]);

        Alert::success('Title', 'Delivery Man Created Sucessfully');

        return back();
    }

    //view admin|delivery|user list page
    public function adminList()
    {
        $admins = User::where('role', 'admin')->get();
        $deliverys = User::where('role', 'delivery')
            ->leftJoin('delivery_mans', 'users.id', '=', 'delivery_mans.user_id')
            ->get();

        $users = User::where('role', 'user')->get();

        return view('admin.home.view', compact('admins', 'deliverys', 'users'));
    }

    //delete admin & delivery account
    public function adminDelete(Request $request)
    {

        //admin delete
        if ($request->role == 'admin') {
            $admin = User::find($request->id);

            // dd($admin->toArray());
            if ($admin) {

                if ($admin && $admin->document_cv && file_exists(public_path('cv_form/' . $admin->document_cv))) {
                    unlink(public_path('cv_form/' . $admin->document_cv));
                }

                $admin->update([
                    'role' => 'user',
                    'document_cv' => NULL
                ]);

                Alert::success('Success', 'Admin Account Deleted!');

                return back();
            }
        }

        //delivery delete
        if ($request->role == 'delivery') {
            $userId = $request->user_id;
            $user = $userId ? User::find($userId) : null;

            if ($user) {
                $delivery = DeliveryMans::where('user_id', $user->id)->first();

                if ($delivery && $delivery->document_cv && file_exists(public_path('cv_form/' . $delivery->document_cv))) {
                    unlink(public_path('cv_form/' . $delivery->document_cv));
                }

                if ($delivery) {
                    $delivery->delete();
                }

                $user->update([
                    'role' => 'user'
                ]);

                Alert::success('Success', 'Delivery Account Deleted!');

                return back();
            }
        }

        //user delete
        if ($request->role == 'user') {
            $user = User::find($request->id);

            if ($user) {
                if ($user->profile && file_exists(public_path('profile/' . $user->profile))) {
                    unlink(public_path('profile/' . $user->profile));
                }

                $user->delete();

                Alert::success('Success', 'User Account Deleted!');

                return back();
            }
        }
    }

    //admin delivery user details
    public function adminDetails($id)
    {
        $user = User::find($id);

        return view('admin.home.details', compact('user'));
    }

    //delivery details
    public function deliveryDetails($id)
    {
        $delivery = DeliveryMans::query()
            ->leftJoin('users', 'delivery_mans.user_id', '=', 'users.id')
            ->where('delivery_mans.id', $id)
            ->select([
                'users.*',
                'delivery_mans.id as delivery_man_id',
                'delivery_mans.user_id as delivery_user_id',
                'delivery_mans.document_cv',
                'delivery_mans.license',
                'delivery_mans.vehicle',
                'delivery_mans.delivery_zone',
                'delivery_mans.work_time',
            ])
            ->first();

        return view('admin.home.deliveryDetails', compact('delivery'));
    }

    //add color page
    public function addColor()
    {
        $colors = Color::paginate(5);

        return view('admin.color.add', compact('colors'));
    }

    //create color
    public function createColor(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        Color::create($request->all());

        Alert::success('Title', 'Successful Created Color');

        return back();
    }

    //delete color
    public function deleteColor($id)
    {
        Color::where('id', $id)->delete();

        return back();
    }

    //wishlist page
    public function wishList(Request $request)
    {
        $query = \App\Models\Wishlist::with(['user', 'product']);

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('nickname', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            })->orWhereHas('product', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        $wishlists = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.wishlist.list', compact('wishlists'));
    }

    //sale information
    public function saleInfo()
    {
        $monthlySales = PaymentHistories::select(
            DB::raw('SUM(total_amount) as total_sales'),
            DB::raw('MONTH(created_at) as month')
        )
            ->whereYear('created_at', Carbon::now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $months = [];
        $salesData = [];

        foreach (range(1, 12) as $m) {
            $monthName = Carbon::create()->month($m)->format('M');
            $months[] = $monthName;

            $sale = $monthlySales->firstWhere('month', $m);
            $salesData[] = $sale ? $sale->total_sales : 0;
        }

        $totalSales = $monthlySales->sum('total_sales');
        $totalOrders = PaymentHistories::count('order_code');
        $totalCustomers = PaymentHistories::count('id');

        $topSelling = Order::select(
            'products.name as product_name',
            DB::raw('SUM(orders.count) as total_sold')
        )
            ->join('products', 'orders.product_id', '=', 'products.id')
            ->groupBy('products.name')
            ->orderBy('total_sold', 'desc')
            ->take(5)
            ->get();

        return view('admin.saleInfo.sale', compact('months', 'salesData', 'totalSales', 'totalOrders', 'totalCustomers', 'topSelling'));
    }

    //message
    public function message() {
        $message = Contact::select('contacts.message', 'users.name', 'users.phone', 'users.address', 'users.city', 'contacts.id')
                ->leftJoin('users', 'contacts.user_id', '=', 'users.id')
                ->get();

        return view('admin.home.message', compact('message'));
    }

    //check admin validate
    private function checkAdminValidate(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required|min:8',
            'password_confirmation' => 'required|same:password',
            'phone' => 'required',
            'address' => 'required',
            'documents' => 'required|mimes:jpg,jpeg,png,pdf,heic,svg,webp',
        ], [
            'name.required' => 'admin အမည်လိုအပ်သည်။',
            'email.required' => 'အီးမေးလ် လိုအပ်သည်။',
            'email.unique' => 'အီးမေးလ်က ရှိပြီးသားပါ။',
            'password.required' => 'စကားဝှက်လိုအပ်သည်။',
            'password.min' => 'စကားဝှက်သည် အနည်းဆုံး စကားလုံး ၈ လုံးရှိရမည်။',
            'password_confirmation.required' => 'စကားဝှက်လိုအပ်သည်။',
            'password_confirmation.same' => 'စကားဝှက်သည် တူညီရပါမည်။',
            'phone.required' => 'ဖုန်းနံပါတ် လိုအပ်ပါသည်။',
            'address.required' => 'လိပ်စာ လိုအပ်ပါသည်။',
            'documents.required' => 'စာရွက်စာတမ်းလိုအပ်သည်။'
        ]);
    }

    //get admin data
    private function getAdminData(Request $request)
    {
        return [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'role' => $request->role,
            'address' => $request->address,
            'document_cv' => $request->documents,
        ];
    }

    //check new delivery validate
    private function checkNewDelivery(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required|min:8',
            'password_confirmation' => 'required|same:password',
            'phone' => 'required',
            'address' => 'required',
            'documents' => 'required|mimes:jpg,jpeg,png,pdf,heic,svg,webp',
            'vehicle_type' => 'required',
            'license_number' => 'required',
            'delivery_zone' => 'required',
            'preferred_shift' => 'required',
        ]);
    }
}
