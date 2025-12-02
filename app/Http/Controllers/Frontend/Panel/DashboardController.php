<?php

namespace App\Http\Controllers\Frontend\Panel;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderCustomerResource;
use App\Models\Orders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request){
        $samples = Orders::where('order_type', 'SAMPLE')->where('customer_id', Auth::guard('customer')->user()->id)->get();
        $orders = Orders::where('order_type', 'ORDER')->where('customer_id', Auth::guard('customer')->user()->id)->get();

        $sample_pending = $samples;
        $sample_approved = $samples;
        $sample_canceled = $samples;
        $sample_pending = $sample_pending->where('status', 'PENDING')->count();
        $sample_approved = $sample_approved->where('status', 'APPROVED')->count();
        $sample_canceled = $sample_canceled->where('status', 'CANCELED')->count();

        $order_pending = $orders;
        $order_approved = $orders;
        $order_canceled = $orders;
        $order_pending = $order_pending->where('status', 'PENDING')->count();
        $order_approved = $order_approved->where('status', 'APPROVED')->count();
        $order_canceled = $order_canceled->where('status', 'CANCELED')->count();

        $request->customer_id = Auth::guard('customer')->user()->id;
        $request->limit = 5;
        $get_recent_orders = Orders::getRecentOrders($request);
        $count_recent_orders = $get_recent_orders->count();
        $recent_orders = collect(
            OrderCustomerResource::collection($get_recent_orders)->resolve()
        )->map(function ($item) {
            return (object) $item;     // ubah array hasil resource menjadi object
        });

        return view('frontend.panel.dashboard.index', compact('sample_pending', 'sample_approved', 'sample_canceled', 'order_pending', 'order_approved', 'order_canceled', 'recent_orders', 'count_recent_orders'));
    }
}
