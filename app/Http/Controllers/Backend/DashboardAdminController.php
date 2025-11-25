<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Customers;
use App\Models\Orders;
use App\Models\Products;
use App\Models\User;
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

    public function loadData(Request $request){
        return response()->json([]);
    }
}
