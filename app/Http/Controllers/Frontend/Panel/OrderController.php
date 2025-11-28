<?php

namespace App\Http\Controllers\Frontend\Panel;

use App\Helpers\CodeHelper;
use App\Helpers\IdGenerator;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderCustomerResource;
use App\Models\CompanyProfile;
use App\Models\Orders;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(){
        return view('frontend.panel.order.index');
    }

    public function loadData(Request $request){
        $data = Orders::loadDataCustomer($request);

        $response = [
            'success' => true,
            'recordsTotal' => $data['recordsTotal'],
            'recordsFiltered' => $data['recordsFiltered'],
            'data' => OrderCustomerResource::collection($data['data']),
        ];
        
        return response()->json($response, Response::HTTP_OK);
    }

    public function show($order_number_decode){
        $order_number = CodeHelper::decodeCode($order_number_decode);
        $orders = Orders::with(['details'])->where('order_number', $order_number)->first();
        
        return view('frontend.order.show', compact('orders'));
    }

    public function cancelOrder($id){
        DB::beginTransaction();
        try{
            $order = Orders::where('id', $id)->first();

            $order->update([
                'canceled_by_customer' => Auth::guard('customer')->user()->id,
                'updated_by_customer' => Auth::guard('customer')->user()->id,
                'canceled_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'status' => 'CANCELED',
            ]);

            Cache::flush();
            DB::commit();

            return response()->json([
                'response' => $order,
                'success' => true,
                'status' => 'success',
            ]);
        } catch (\Exception $exc) {
            DB::rollBack();
            return $exc;
        }
    }
}
