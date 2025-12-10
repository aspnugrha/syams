<?php

namespace App\Http\Controllers\Frontend\Panel;

use App\Helpers\CodeHelper;
use App\Helpers\IdGenerator;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderCustomerResource;
use App\Mail\ApproveCancelOrderEmail;
use App\Models\CompanyProfile;
use App\Models\OrderDetails;
use App\Models\Orders;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

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
            $order_detail = OrderDetails::where('order_id', $id)->get();

            $order->update([
                'canceled_by_customer' => Auth::guard('customer')->user()->id,
                'updated_by_customer' => Auth::guard('customer')->user()->id,
                'canceled_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'status' => 'CANCELED',
            ]);
            
            if($order_detail){
                foreach($order_detail as $od){
                    $od->update([
                        'canceled_by_customer' => Auth::guard('customer')->user()->id,
                        'updated_by_customer' => Auth::guard('customer')->user()->id,
                        'canceled_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                        'status' => 'CANCELED',
                    ]);
                }
            }

            $orders = Orders::with(['details'])->where('id', $id)->first();
            
            if($order->customer_id){
                $url = route('my-order.show', CodeHelper::encodeCode($order->order_number));
            }else{
                $url = route('order.show', CodeHelper::encodeCode($order->order_number));
            }
            
            $customer = (object)[
                'name' => $orders->customer_name,
                'email' => $orders->customer_email,
                'phone_number' => $orders->customer_phone_number,
            ];

            $company_profile = CompanyProfile::first();
            Mail::to($orders->customer_email)->send(new ApproveCancelOrderEmail($customer, $orders, $url, 'frontend', $company_profile));

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
