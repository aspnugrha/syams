<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderCustomerResource;
use App\Models\Customers;
use App\Models\Orders;
use App\Models\Products;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;

class DashboardAdminController extends Controller
{
    public function index(User $user, Customers $customer, Products $product, Orders $order){
        $total_data = [
            'total_user' => $user::count(),
            'total_user_month' => $user::where('created_at', 'like', date('Y-m').'%')->count(),
            'total_customer' => $customer::count(),
            'total_customer_month' => $customer::where('created_at', 'like', date('Y-m').'%')->count(),
            'total_product' => $product::count(),
            'total_product_month' => $product::where('created_at', 'like', date('Y-m').'%')->count(),
            'total_order' => $order::count(),
            'total_order_month' => $order::where('created_at', 'like', date('Y-m').'%')->count(),
        ];

        return view('backend.dashboard.index', compact('total_data'));
    }

    public function loadData(Request $request, User $user, Customers $customer, Products $product, Orders $order){
        $range = $request->filter_date;
        [$start, $end] = explode(' - ', $range);

        $start_format = DateTime::createFromFormat('d/m/Y', $start)->format('Y-m-d');
        $end_format = DateTime::createFromFormat('d/m/Y', $end)->format('Y-m-d');

        $total_data = [
            'total_user_month' => $user::when($start_format && $end_format, function($query) use($start_format, $end_format){
                $query->where('created_at', '>=', date('Y-m-d H:i:s', strtotime($start_format.' 00:00:00')));
                $query->where('created_at', '<=', date('Y-m-d H:i:s', strtotime($end_format.' 23:59:59')));
            })->count(),
            'total_customer_month' => $customer::when($start_format && $end_format, function($query) use($start_format, $end_format){
                $query->where('created_at', '>=', date('Y-m-d H:i:s', strtotime($start_format.' 00:00:00')));
                $query->where('created_at', '<=', date('Y-m-d H:i:s', strtotime($end_format.' 23:59:59')));
            })->count(),
            'total_product_month' => $product::when($start_format && $end_format, function($query) use($start_format, $end_format){
                $query->where('created_at', '>=', date('Y-m-d H:i:s', strtotime($start_format.' 00:00:00')));
                $query->where('created_at', '<=', date('Y-m-d H:i:s', strtotime($end_format.' 23:59:59')));
            })->count(),
            'total_order_month' => $order::when($start_format && $end_format, function($query) use($start_format, $end_format){
                $query->where('created_at', '>=', date('Y-m-d H:i:s', strtotime($start_format.' 00:00:00')));
                $query->where('created_at', '<=', date('Y-m-d H:i:s', strtotime($end_format.' 23:59:59')));
            })->count(),
        ];


        // Convert ke Carbon dengan format DD/MM/YYYY
        $startDate = Carbon::createFromFormat('d/m/Y', $start)->startOfDay();
        $endDate = Carbon::createFromFormat('d/m/Y', $end)->endOfDay();

        // Hitung selisih bulan
        $diffInMonths = $startDate->diffInMonths($endDate);

        // Tentukan mode (per hari atau per bulan)
        $mode = ($diffInMonths >= 1) ? 'month' : 'day';

        $request->mode = $mode;
        $request->start_date = $startDate;
        $request->end_date = $endDate;

        $chart = Orders::getDataChart($request);


        $request->created_at = $start_format.' - '.$end_format;
        $request->limit = 5;
        $request->order_type = $request->filter_order;
        $recent_orders = OrderCustomerResource::collection(Orders::getRecentOrders($request));

        return response()->json([
            'mode' => $mode,
            'chart' => $chart,
            'total_data' => $total_data,
            'recent_orders' => $recent_orders,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ]);
    }
}
