<?php

namespace App\Http\Controllers\Backend;

use App\Exports\OrderExport;
use App\Helpers\CodeHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyProfileRequest;
use App\Http\Resources\OrderCustomerResource;
use App\Mail\ApproveCancelOrderEmail;
use App\Models\CompanyProfile;
use App\Models\Customers;
use App\Models\Orders;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use stdClass;

class OrderController extends Controller
{
    public function loadData(Request $request){
        $data = Orders::loadData($request);

        $response = [
            'success' => true,
            'recordsTotal' => $data['recordsTotal'],
            'recordsFiltered' => $data['recordsFiltered'],
            'data' => OrderCustomerResource::collection($data['data']),
        ];
        
        return response()->json($response, Response::HTTP_OK);
    }

    public function export(Request $request){
        return Excel::download(new OrderExport($request), 'order.xlsx');
    }
    
    /**
     * Show the form for editing the specified resource.
     */
    public function index(Request $request)
    {
        $customers = Customers::select('id', 'name', 'email')->where('active', 1)->get();
        return view('backend.order.index', compact('customers'));
    }
    
    public function show($id)
    {
        $data = Orders::with(['details', 'hasCustomer', 'hasApprovedBy', 'hasCanceledBy', 'hasCanceledByCustomer'])->where('id', $id)->first();
        return view('backend.order.detail', compact('data'));
    }
    
    public function setStatus(Request $request)
    {
        DB::beginTransaction();
        try{
            $order = Orders::where('id', $request->id)->first();
            
            $data_update = ['status' => $request->status];
            
            if($request->status == 'APPROVED'){
                $data_update['approved_by'] = Auth::guard('web')->user()->id;
                $data_update['approved_at'] = date('Y-m-d H:i:s');
                $data_update['canceled_by'] = null;
                $data_update['canceled_at'] = null;
            }else if($request->status == 'CANCELED'){
                $data_update['approved_by'] = null;
                $data_update['approved_at'] = null;
                $data_update['canceled_by'] = Auth::guard('web')->user()->id;
                $data_update['canceled_at'] = date('Y-m-d H:i:s');
            }
            $save = $order->update($data_update);
            
            $orders = Orders::with(['details'])->where('id', $request->id)->first();
            
            if($order->customer_id){
                $url = route('my-order.show', CodeHelper::encodeCode($order->order_number));
            }else{
                $url = route('order.show', CodeHelper::encodeCode($order->order_number));
            }
            
            $customer = (object)[
                'name' => $order->customer_name,
                'email' => $order->customer_email,
                'phone_number' => $order->customer_phone_number,
            ];
            
            $company_profile = CompanyProfile::first();
            Mail::to($order->customer_email)->send(new ApproveCancelOrderEmail($customer, $orders, $url, $company_profile));

            Cache::flush();
            DB::commit();

            return response()->json([
                'response' => $save,
                'success' => true,
                'status' => 'success',
            ]);
        } catch (\Exception $exc) {
            DB::rollBack();
            return $exc;
        }
    }
}
