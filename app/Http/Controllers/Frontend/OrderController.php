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

        $products = Products::with(['hasCategory'])->where('active', 1)->where('type', 'ORDER')->inRandomOrder()->get()->map(function ($item) {
            $item->size_qty = ($item->size_qty_options ? json_decode($item->size_qty_options) : null);
            $item->material_color = ($item->material_color_options ? json_decode($item->material_color_options) : null);
            return $item;
        });
        
        $request_product = null;
        if($request->product) {
            $request_product = Products::with(['hasCategory'])->where('id', CodeHelper::decodeCode($request->product))->first();
            if($request_product){
                $request_product->size_qty = ($request_product->size_qty_options ? json_decode($request_product->size_qty_options) : null);
                $request_product->material_color = ($request_product->material_color_options ? json_decode($request_product->material_color_options) : null);
            }
        }
        
        return view('frontend.order.index', compact('products', 'request_product', 'order_type'));
    }

    public function store(OrderRequest $request){
        DB::beginTransaction();
        try{
            $check_material_color = true;
            if($request->material_options == null || $request->color_options == null){
                $check_material_color = false;
            }else{
                if((count($request->product_id) > count($request->material_options)) || (count($request->product_id) > count($request->color_options))){
                    $check_material_color = false;
                }
            }

            if(!$check_material_color){
                return response()->json([
                    'status' => 'material_color_options',
                    'success' => false,
                    'message' => 'Please select material and color!'
                ]);
            }
            
            $check_sablon_type = true;
            if($request->sablon_type == null){
                $check_sablon_type = false;
            }else{
                if(count($request->product_id) > count($request->sablon_type)){
                    $check_sablon_type = false;
                }
            }

            if(!$check_sablon_type){
                return response()->json([
                    'status' => 'sablon_type',
                    'success' => false,
                    'message' => 'Please select sablon type!'
                ]);
            }

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
                    'message' => 'Please select '.($request->order_type == 'ORDER' ? 'size and quantity!' : 'size!')
                ]);
            }

            $check_mockup = true;
            if($request->mockup == null){
                $check_mockup = false;
            }else{
                if(count($request->product_id) > count($request->mockup)){
                    $check_mockup = false;
                }
            }

            if(!$check_mockup){
                return response()->json([
                    'status' => 'mockup',
                    'success' => false,
                    'message' => 'Please select mockup file!'
                ]);
            }else{
                $mockup_gagal = 0;
                foreach($request->mockup as $mockup){
                    if(!in_array($mockup->getClientOriginalExtension(), ['psd','png','pdf','cdr','spg','eps'])){
                        $mockup_gagal++;
                    }
                }

                if($mockup_gagal){
                    return response()->json([
                        'status' => 'mockup',
                        'success' => false,
                        'message' => 'Only accepted mockup files are .psd, .png, .pdf, .cdr, .spg and .eps!'
                    ]);
                }
            }

            $check_raw_file = true;
            if($request->raw_file == null){
                $check_raw_file = false;
            }else{
                if(count($request->product_id) > count($request->raw_file)){
                    $check_raw_file = false;
                }
            }

            if(!$check_raw_file){
                return response()->json([
                    'status' => 'raw_file',
                    'success' => false,
                    'message' => 'Please select raw file!'
                ]);
            }else{
                $raw_file_gagal = 0;
                foreach($request->raw_file as $raw_file){
                    if(!in_array($raw_file->getClientOriginalExtension(), ['psd','png','pdf','cdr','spg','eps'])){
                        $raw_file_gagal++;
                    }
                }

                if($raw_file_gagal){
                    return response()->json([
                        'status' => 'raw_file',
                        'success' => false,
                        'message' => 'Only accepted raw files are .psd, .png, .pdf, .cdr, .spg and .eps!'
                    ]);
                }
            }

            // dd($request->all());

            $id = IdGenerator::generate('ORDR', 'orders');

            foreach($request->product_id as $product_id){
                $product = Products::with(['hasCategory'])->where('id', $product_id)->first();

                $material_options = $request->material_options;
                $color_options = $request->color_options;
                $color_code_options = $request->color_code_options;
                $color_image_options = $request->color_image_options;
                $sablon_type = $request->sablon_type;
                $is_bordir = $request->is_bordir;
                $size_options = $request->size_options;
                $qty_options = $request->qty_options;
                $product_notes = $request->product_notes;

                $mockup = null;
                if (!empty($request->file('mockup')[$product_id])) {
                    $mockup = time() .'-'. rand(1000, 9999) . '.' . $request->file('mockup')[$product_id]->getClientOriginalExtension();
                    $destinationPath = public_path('/assets/image/upload/order/mockup');
                    $request->file('mockup')[$product_id]->move($destinationPath, $mockup);
                }
                
                $raw_file = null;
                if (!empty($request->file('raw_file')[$product_id])) {
                    $raw_file = time() .'-'. rand(1000, 9999) . '.' . $request->file('raw_file')[$product_id]->getClientOriginalExtension();
                    $destinationPath = public_path('/assets/image/upload/order/raw_file');
                    $request->file('raw_file')[$product_id]->move($destinationPath, $raw_file);
                }

                $data_detail = [
                    'id' => IdGenerator::generate('ORDRDTL', 'order_details'),
                    'order_id' => $id,
                    'product_id' => $product_id,
                    'product_name' => $product->name,
                    'product_category' => ($product->category_id ? $product->hasCategory->name : null),
                    'product_image' => $product->image,
                    'mockup' => $mockup,
                    'raw_file' => $raw_file,
                    'notes' =>$product_notes[$product_id],
                    'created_by_customer' => (Auth::guard('customer')->user() ? Auth::guard('customer')->user()->id : null),
                    'created_at' => date('Y-m-d H:i:s'),
                ];
                
                if($request->order_type == 'ORDER'){
                    if($size_options[$product_id] || $qty_options[$product_id]){
                        $data_detail['size_selected'] = implode(',', $size_options[$product_id]);
                        $data_detail['qty_selected'] = json_encode($qty_options[$product_id]);
                    }
                }else{
                    if($size_options[$product_id]){
                        $data_detail['size_selected'] = $size_options[$product_id];
                        $data_detail['qty_selected'] = json_encode([
                            $size_options[$product_id] => '1',
                        ]);
                    }
                }
                
                $data_detail['material_selected'] = $material_options[$product_id];

                $color = $color_options[$product_id][$material_options[$product_id]];
                $color_code = $color_code_options[$product_id][$material_options[$product_id]][$color];
                $color_image = $color_image_options[$product_id][$material_options[$product_id]][$color];

                $data_detail['material_color_selected'] = json_encode([
                    'color' => $color,
                    (isset($color_code) ? 'color_code' : 'color_image') => (isset($color_code) ? $color_code : $color_image),
                ]);
                $data_detail['sablon_selected'] = $sablon_type[$product_id];

                if(isset($is_bordir[$product_id])){
                    $data_detail['is_bordir'] = 1;
                }

                // dd($data_detail, $request->all());

                $save_detail = OrderDetails::insert($data_detail);
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
                'customer_country_code' => $request->country_code,
                'customer_dial_code' => $request->dial_code,
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

        $company_profile = CompanyProfile::first();
        
        return view('frontend.order.show', compact('orders', 'company_profile'));
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
