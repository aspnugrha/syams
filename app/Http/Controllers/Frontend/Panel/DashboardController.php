<?php

namespace App\Http\Controllers\Frontend\Panel;

use App\Http\Controllers\Controller;
use App\Models\Orders;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(){
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

        return view('frontend.panel.dashboard.index', compact('sample_pending', 'sample_approved', 'sample_canceled', 'order_pending', 'order_approved', 'order_canceled'));
    }
}
