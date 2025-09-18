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
        $deliveryMan = DeliveryMans::where('user_id', Auth::id())->first();

        if (!$deliveryMan) {
            return redirect()->back()->with('error', 'Delivery person profile not found');
        }

        // Get today's deliveries
        $todayDeliveries = Order::where('delivery_man_id', $deliveryMan->id)
            ->where('status', 2)
            ->whereDate('created_at', Carbon::today())
            ->count();

        // Get completed deliveries
        $completedDeliveries = Delivery::where('delivery_man_id', $deliveryMan->id)
            ->where('status', 4)
            ->count();

        // Get total deliveries
        $totalDeliveries = Delivery::where('delivery_man_id', $deliveryMan->id)->count();

        // Get this month's deliveries
        $thisMonthDeliveries = Delivery::where('delivery_man_id', $deliveryMan->id)
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->get();

        // Get recent activities (last 5)
        $recentActivities = Delivery::where('delivery_man_id', $deliveryMan->id)
            ->with(['order', 'user'])
            ->orderBy('updated_at', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($delivery) {
                return (object) [
                    'title' => 'Delivery #' . ($delivery->order->order_code ?? 'N/A'),
                    'description' => 'Status: ' . ucfirst($delivery->status),
                    'created_at' => $delivery->updated_at
                ];
            });

        return view("admin.delivery.home", compact(
            'todayDeliveries',
            'completedDeliveries',
            'totalDeliveries',
            'thisMonthDeliveries',
            'recentActivities'
        ));
    }

    // Start delivery
    public function startDelivery($id)
    {
        $delivery = Delivery::findOrFail($id);

        // Check if delivery belongs to current delivery man
        $deliveryMan = DeliveryMans::where('user_id', Auth::id())->first();
        if ($delivery->delivery_man_id != $deliveryMan->id) {
            return response()->json(['success' => false, 'message' => 'Unauthorized']);
        }

        $delivery->status = 'in_progress';
        $delivery->save();

        return response()->json(['success' => true, 'message' => 'Delivery started successfully']);
    }

    // Complete delivery
    public function completeDelivery($id)
    {
        $delivery = Delivery::findOrFail($id);

        // Check if delivery belongs to current delivery man
        $deliveryMan = DeliveryMans::where('user_id', Auth::id())->first();
        if ($delivery->delivery_man_id != $deliveryMan->id) {
            return response()->json(['success' => false, 'message' => 'Unauthorized']);
        }

        $delivery->status = 'delivered';
        $delivery->delivery_at = Carbon::now();
        $delivery->save();

        // Update order status
        if ($delivery->order) {
            $delivery->order->status = 'delivered';
            $delivery->order->save();
        }

        return response()->json(['success' => true, 'message' => 'Delivery completed successfully']);
    }

    // Get delivery details
    public function getDeliveryDetails($id)
    {
        $delivery = Delivery::with(['order', 'user', 'deliveryMan'])
            ->findOrFail($id);

        // Check if delivery belongs to current delivery man
        $deliveryMan = DeliveryMans::where('user_id', Auth::id())->first();
        if ($delivery->delivery_man_id != $deliveryMan->id) {
            return response()->json(['success' => false, 'message' => 'Unauthorized']);
        }

        $html = '
        <div class="row">
            <div class="col-md-6">
                <h6>Order Information</h6>
                <p><strong>Order Code:</strong> #' . ($delivery->order->order_code ?? 'N/A') . '</p>
                <p><strong>Customer:</strong> ' . ($delivery->user->name ?? 'N/A') . '</p>
                <p><strong>Phone:</strong> ' . ($delivery->user->phone ?? 'N/A') . '</p>
            </div>
            <div class="col-md-6">
                <h6>Delivery Information</h6>
                <p><strong>Status:</strong> ' . ucfirst($delivery->status) . '</p>
                <p><strong>Assigned:</strong> ' . $delivery->created_at->format('M d, Y H:i') . '</p>
                <p><strong>Address:</strong> ' . ($delivery->order->shipping_address ?? 'N/A') . '</p>
            </div>
        </div>
        ';

        return response($html);
    }
}
