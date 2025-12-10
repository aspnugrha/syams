<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\CodeHelper;
use App\Helpers\IdGenerator;
use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Mail\ApproveCancelOrderEmail;
use App\Mail\OrderEmail;
use App\Models\CompanyProfile;
use App\Models\OrderDetails;
use App\Models\Orders;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    public function index(Request $request){
        $order_type = ($request->order_type == 'SAMPLE' || $request->order_type == 'ORDER') ? $request->order_type : null;

        $products = Products::with(['hasCategory'])->where('active', 1)->inRandomOrder()->get()->map(function ($item) {
            $item->size_qty = ($item->size_qty_options ? json_decode($item->size_qty_options) : null);
            return $item;
        });

        $request_product = null;
        if($request->product) {
            $request_product = Products::with(['hasCategory'])->where('id', CodeHelper::decodeCode($request->product))->first();
            if($request_product){
                $request_product->size_qty = ($request_product->size_qty_options ? json_decode($request_product->size_qty_options) : null);
            }
        }
        
        return view('frontend.order.index', compact('products', 'request_product', 'order_type'));
    }

    public function store(OrderRequest $request){
        DB::beginTransaction();
        try{
            $check_size_qty = true;
            if($request->order_type == 'ORDER'){
                if($request->size_options == null || $request->qty_options == null){
                    $check_size_qty = false;
                }else{
                    if((count($request->product_id) > count($request->size_options)) || (count($request->product_id) > count($request->qty_options))){
                        $check_size_qty = false;
                    }
                }
            }else{
                if($request->size_options == null){
                    $check_size_qty = false;
                }else{
                    if(count($request->product_id) > count($request->size_options)){
                        $check_size_qty = false;
                    }
                }
            }
            
            if(!$check_size_qty){
                return response()->json([
                    'status' => 'size_qty_options',
                    'success' => false,
                    'message' => 'Please select size and quantity!'
                ]);
            }

            // dd($request->all());

            $id = IdGenerator::generate('ORDR', 'orders');

            foreach($request->product_id as $product_id){
                $product = Products::with(['hasCategory'])->where('id', $product_id)->first();

                $size_options = $request->size_options;
                $qty_options = $request->qty_options;
                $product_notes = $request->product_notes;

                $data_detail = [
                    'id' => IdGenerator::generate('ORDRDTL', 'order_details'),
                    'order_id' => $id,
                    'product_id' => $product_id,
                    'product_name' => $product->name,
                    'product_category' => ($product->category_id ? $product->hasCategory->name : null),
                    'product_image' => $product->image,
                    'notes' =>$product_notes[$product_id],
                    'created_by_customer' => (Auth::guard('customer')->user() ? Auth::guard('customer')->user()->id : null),
                    'created_at' => date('Y-m-d H:i:s'),
                ];
                
                if($request->order_type == 'ORDER'){
                    if($size_options[$product_id] || $qty_options[$product_id]){
                        $data_detail['size_selected'] = implode(',', $size_options[$product_id]);
                        $data_detail['qty_selected'] = json_encode($qty_options[$product_id]);
                        $save_detail = OrderDetails::insert($data_detail);
                    }
                }else{
                    if($size_options[$product_id]){
                        $data_detail['size_selected'] = $size_options[$product_id];
                        $data_detail['qty_selected'] = json_encode([
                            $size_options[$product_id] => '1',
                        ]);
                        $save_detail = OrderDetails::insert($data_detail);
                    }
                }
            }

            $order_number = ($request->order_type == 'SAMPLE' ? 'SMPL' : 'ORDR').'-'.date('Ymd').'-'.time();
            $order_number_encode = CodeHelper::encodeCode($order_number);

            $save = Orders::insert([
                'id' => $id,
                'order_number' => $order_number,
                'order_type' => $request->order_type,
                'order_date' => date('Y-m-d H:i:s'),
                'customer_id' => $request->customer_id,
                'customer_name' => $request->fullname,
                'customer_email' => $request->email,
                'customer_phone_number' => $request->phone_number,
                'notes' => $request->notes,
                'status' => 'PENDING',
                'created_by_customer' => (Auth::guard('customer')->user() ? Auth::guard('customer')->user()->id : null),
                'created_at' => date('Y-m-d H:i:s'),
            ]);

            $customer = (object)[
                'name' => $request->fullname,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
            ];

            $orders = Orders::with(['details'])->where('id', $id)->first();
            
            $company_profile = CompanyProfile::first();
            if(Auth::guard('customer')->user()){
                $url = route('my-order.show', $order_number_encode);
            }else{
                $url = route('order.show', $order_number_encode);
            }
            Mail::to($request->email)->send(new OrderEmail($customer, $orders, $url, $company_profile));
            
            Cache::flush();
            DB::commit();

            return response()->json([
                'response' => $save,
                'success' => true,
                'status' => 'success',
                'message' => 'Congratulations! Your order has been successfully placed. Check email '.$request->email.' for details.'
            ]);
        } catch (\Exception $exc) {
            DB::rollBack();
            return $exc;
        }
    }

    public function show($order_number_decode){
        $order_number = CodeHelper::decodeCode($order_number_decode);
        $orders = Orders::with(['details'])->where('order_number', $order_number)->first();
        if($orders){
            $orders->id_encode = CodeHelper::encodeCode($orders->id);
            $orders->order_number_encode = CodeHelper::encodeCode($orders->order_number);
        }
        
        return view('frontend.order.show', compact('orders'));
    }

    public function cancelOrder($order_number_encode){
        DB::beginTransaction();
        try{
            $order_number = CodeHelper::decodeCode($order_number_encode);
            $order = Orders::where('order_number', $order_number)->first();
            $order_detail = OrderDetails::where('order_id', ($order ? $order->id : null))->get();

            if(!$order){
                return response()->json([
                    'response' => $order,
                    'success' => false,
                    'status' => 'error',
                ]);
            }

            $order->update([
                // 'canceled_by_customer' => Auth::guard('customer')->user()->id,
                // 'updated_by_customer' => Auth::guard('customer')->user()->id,
                'canceled_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'status' => 'CANCELED',
            ]);
            
            if($order_detail){
                foreach($order_detail as $od){
                    $od->update([
                        // 'canceled_by_customer' => Auth::guard('customer')->user()->id,
                        // 'updated_by_customer' => Auth::guard('customer')->user()->id,
                        'canceled_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                        'status' => 'CANCELED',
                    ]);
                }
            }

            $orders = Orders::with(['details'])->where('order_number', $order_number)->first();
            
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
