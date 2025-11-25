<?php

namespace App\Http\Controllers\Backend;

use App\Exports\MasterCustomerExport;
use App\Http\Controllers\Controller;
use App\Models\Customers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;

class MasterCustomerController extends Controller
{
    public function loadData(Request $request){
        $data = Customers::loadData($request);

        $response = [
            'success' => true,
            'recordsTotal' => $data['recordsTotal'],
            'recordsFiltered' => $data['recordsFiltered'],
            'data' => $data['data'],
        ];
        
        return response()->json($response, Response::HTTP_OK);
    }

    public function export(Request $request){
        return Excel::download(new MasterCustomerExport($request), 'master-customer.xlsx');
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('backend.mastercustomer.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Customers::where('id', $id)->first();
        return view('backend.mastercustomer.detail', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = Customers::where('id', $id)->first();
        return view('backend.mastercustomer.form', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        DB::beginTransaction();
        try{
            $customer = Customers::where('id', $id)->first();

            $save = $customer->update([
                'active' => ($request->active ? 1 : 0),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);

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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();
        try{
            $show = Customers::where('id', $id)->first();
            if($show->image){
                if (File::exists(public_path('assets/image/upload/customer/' . $show->image))) {
                    File::delete(public_path('assets/image/upload/customer/' . $show->image));
                }
            }
            $delete = $show->delete();

            Cache::flush();
            DB::commit();

            return response()->json([
                'response' => $delete,
                'success' => true,
                'status' => 'success',
            ]);
        } catch (\Exception $exc) {
            DB::rollBack();
            return $exc;
        }
    }
}
