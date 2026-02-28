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
            // dd($request->all());
            $products = Products::whereIn('id', $request->product_id)->get();
            foreach($products as $product){
                $input_settings = ($product->input_settings ? explode(',', $product->input_settings) : []);

                $check_material_color = true;
                if((!isset($request->material_options[$product->id]) || !isset($request->color_options[$product->id])) || ($request->material_options[$product->id] == null || $request->color_options[$product->id] == null)){
                    $check_material_color = false;
                }

                if(!$check_material_color){
                    return response()->json([
                        'status' => 'material_color_options',
                        'success' => false,
                        'message' => 'Please select material and color "'.$product->name.'"!'
                    ]);
                }

                if(in_array('sablon_type', $input_settings)){
                    $check_sablon_type = true;
                    if(!isset($request->sablon_type[$product->id]) || $request->sablon_type[$product->id] == null){
                        $check_sablon_type = false;
                    }

                    if(!$check_sablon_type){
                        return response()->json([
                            'status' => 'sablon_type',
                            'success' => false,
                            'message' => 'Please select sablon type "'.$product->name.'"!'
                        ]);
                    }
                }
                if(in_array('bordir', $input_settings)){
                    $check_bordir = true;
                    if(!isset($request->bordir[$product->id]) || $request->bordir[$product->id] == null){
                        $check_bordir = false;
                    }

                    if(!$check_bordir){
                        return response()->json([
                            'status' => 'bordir',
                            'success' => false,
                            'message' => 'Please select bordir type "'.$product->name.'"!'
                        ]);
                    }
                }

                $check_size_qty = true;
                if($request->order_type == 'ORDER'){
                    if((!isset($request->size_options[$product->id]) || !isset($request->qty_options[$product->id])) || ($request->size_options[$product->id] == null || $request->qty_options[$product->id] == null)){
                        $check_size_qty = false;
                    }
                    // else{
                    //     if((count($request->product_id) > count($request->size_options)) || (count($request->product_id) > count($request->qty_options))){
                    //         $check_size_qty = false;
                    //     }
                    // }
                }else{
                    if(!isset($request->size_options[$product->id]) || ($request->size_options[$product->id] == null)){
                        $check_size_qty = false;
                    }
                    // else{
                    //     if(count($request->product_id) > count($request->size_options)){
                    //         $check_size_qty = false;
                    //     }
                    // }
                }
                
                if(!$check_size_qty){
                    return response()->json([
                        'status' => 'size_qty_options',
                        'success' => false,
                        'message' => 'Please select '.($request->order_type == 'ORDER' ? 'size and quantity!' : 'size!').' "'.$product->name.'"',
                    ]);
                }

                if(in_array('mockup', $input_settings)){
                    $check_mockup = true;
                    if(!isset($request->mockup[$product->id]) || ($request->mockup[$product->id] == null)){
                        $check_mockup = false;
                    }

                    if(!$check_mockup){
                        return response()->json([
                            'status' => 'mockup',
                            'success' => false,
                            'message' => 'Please select mockup file "'.$product->name.'"!'
                        ]);
                    }else{
                        $mockup_gagal = false;
                        if(!in_array($request->mockup[$product->id]->getClientOriginalExtension(), ['psd','png','pdf','cdr','spg','eps'])){
                            $mockup_gagal = true;
                        }
                        // $mockup_gagal = 0;
                        // foreach($request->mockup as $mockup){
                        //     if(!in_array($mockup->getClientOriginalExtension(), ['psd','png','pdf','cdr','spg','eps'])){
                        //         $mockup_gagal++;
                        //     }
                        // }

                        if($mockup_gagal){
                            return response()->json([
                                'status' => 'mockup',
                                'success' => false,
                                'message' => '"'.$product->name.'" Only accepted mockup files are .psd, .png, .pdf, .cdr, .spg and .eps!'
                            ]);
                        }
                    }
                }

                if(in_array('raw_file', $input_settings)){
                    $check_raw_file = true;
                    if(!isset($request->raw_file[$product->id]) || ($request->raw_file[$product->id] == null)){
                        $check_raw_file = false;
                    }

                    if(!$check_raw_file){
                        return response()->json([
                            'status' => 'raw_file',
                            'success' => false,
                            'message' => 'Please select raw file "'.$product->name.'"!'
                        ]);
                    }else{
                        $raw_file_gagal = false;
                        if(!in_array($request->raw_file[$product->id]->getClientOriginalExtension(), ['psd','png','pdf','cdr','spg','eps'])){
                            $raw_file_gagal = true;
                        }
                        // $raw_file_gagal = 0;
                        // foreach($request->raw_file as $raw_file){
                        //     if(!in_array($raw_file->getClientOriginalExtension(), ['psd','png','pdf','cdr','spg','eps'])){
                        //         $raw_file_gagal++;
                        //     }
                        // }

                        if($raw_file_gagal){
                            return response()->json([
                                'status' => 'raw_file',
                                'success' => false,
                                'message' => '"'.$product->name.'" Only accepted raw files are .psd, .png, .pdf, .cdr, .spg and .eps!'
                            ]);
                        }
                    }
                }
                if(in_array('custom_packaging', $input_settings)){
                    $check_packaging = true;
                    if(!isset($request->custom_packaging[$product->id]) || ($request->custom_packaging[$product->id] == null)){
                        $check_packaging = false;
                    }

                    if(!$check_packaging){
                        return response()->json([
                            'status' => 'packaging',
                            'success' => false,
                            'message' => 'Please select packaging file "'.$product->name.'"!'
                        ]);
                    }else{
                        $packaging_gagal = false;
                        if(!in_array($request->custom_packaging[$product->id]->getClientOriginalExtension(), ['psd','png','pdf','cdr','spg','eps'])){
                            $packaging_gagal = true;
                        }

                        if($packaging_gagal){
                            return response()->json([
                                'status' => 'packaging',
                                'success' => false,
                                'message' => '"'.$product->name.'" Only accepted packaging files are .psd, .png, .pdf, .cdr, .spg and .eps!'
                            ]);
                        }
                    }
                }
                if(in_array('custom_label', $input_settings)){
                    $check_label = true;
                    if(!isset($request->custom_label[$product->id]) || ($request->custom_label[$product->id] == null)){
                        $check_label = false;
                    }

                    if(!$check_label){
                        return response()->json([
                            'status' => 'label',
                            'success' => false,
                            'message' => 'Please select label file "'.$product->name.'"!'
                        ]);
                    }else{
                        $label_gagal = false;
                        if(!in_array($request->custom_label[$product->id]->getClientOriginalExtension(), ['psd','png','pdf','cdr','spg','eps'])){
                            $label_gagal = true;
                        }

                        if($label_gagal){
                            return response()->json([
                                'status' => 'label',
                                'success' => false,
                                'message' => '"'.$product->name.'" Only accepted label files are .psd, .png, .pdf, .cdr, .spg and .eps!'
                            ]);
                        }
                    }
                }
                if(in_array('custom_metal', $input_settings)){
                    $check_metal = true;
                    if(!isset($request->custom_metal[$product->id]) || ($request->custom_metal[$product->id] == null)){
                        $check_metal = false;
                    }

                    if(!$check_metal){
                        return response()->json([
                            'status' => 'metal',
                            'success' => false,
                            'message' => 'Please select zipper/pin/metal file "'.$product->name.'"!'
                        ]);
                    }else{
                        $metal_gagal = false;
                        if(!in_array($request->custom_metal[$product->id]->getClientOriginalExtension(), ['psd','png','pdf','cdr','spg','eps'])){
                            $metal_gagal = true;
                        }

                        if($metal_gagal){
                            return response()->json([
                                'status' => 'metal',
                                'success' => false,
                                'message' => '"'.$product->name.'" Only accepted zipper/pin/metal files are .psd, .png, .pdf, .cdr, .spg and .eps!'
                            ]);
                        }
                    }
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
                $bordir = $request->bordir;
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

                $custom_packaging = null;
                if (!empty($request->file('custom_packaging')[$product_id])) {
                    $custom_packaging = time() .'-'. rand(1000, 9999) . '.' . $request->file('custom_packaging')[$product_id]->getClientOriginalExtension();
                    $destinationPath = public_path('/assets/image/upload/order/custom_packaging');
                    $request->file('custom_packaging')[$product_id]->move($destinationPath, $custom_packaging);
                }

                $custom_label = null;
                if (!empty($request->file('custom_label')[$product_id])) {
                    $custom_label = time() .'-'. rand(1000, 9999) . '.' . $request->file('custom_label')[$product_id]->getClientOriginalExtension();
                    $destinationPath = public_path('/assets/image/upload/order/custom_label');
                    $request->file('custom_label')[$product_id]->move($destinationPath, $custom_label);
                }

                $custom_metal = null;
                if (!empty($request->file('custom_metal')[$product_id])) {
                    $custom_metal = time() .'-'. rand(1000, 9999) . '.' . $request->file('custom_metal')[$product_id]->getClientOriginalExtension();
                    $destinationPath = public_path('/assets/image/upload/order/custom_metal');
                    $request->file('custom_metal')[$product_id]->move($destinationPath, $custom_metal);
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
                    'custom_packaging' => $custom_packaging,
                    'custom_label' => $custom_label,
                    'custom_metal' => $custom_metal,
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
                // $data_detail['sablon_selected'] = $sablon_type[$product_id];
                
                // if(isset($is_bordir[$product_id])){
                //     $data_detail['is_bordir'] = 1;
                // }

                $data_detail['sablon_selected'] = implode(',', $sablon_type[$product_id]);
                if(isset($bordir[$product_id])){
                    $data_detail['bordir_selected'] = implode(',', $bordir[$product_id]);
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
