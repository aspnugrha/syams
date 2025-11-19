<?php

namespace App\Http\Controllers\Backend;

use App\Exports\MasterUserExport;
use App\Helpers\CodeHelper;
use App\Helpers\IdGenerator;
use App\Http\Controllers\Controller;
use App\Http\Requests\MasterUserRequest;
use App\Mail\ActivationRegisterEmail;
use App\Models\CompanyProfile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;

class MasterUserController extends Controller
{
    public function loadData(Request $request){
        $data = User::loadData($request);

        $response = [
            'success' => true,
            'recordsTotal' => $data['recordsTotal'],
            'recordsFiltered' => $data['recordsFiltered'],
            'data' => $data['data'],
        ];
        
        return response()->json($response, Response::HTTP_OK);
    }

    public function export(Request $request){
        return Excel::download(new MasterUserExport($request), 'master-user.xlsx');
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('backend.masterdata.masteruser.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.masterdata.masteruser.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MasterUserRequest $request)
    {
        DB::beginTransaction();
        try{
            $image = null;
            if (!empty($request->file('image'))) {
                $image = time() .'-'. rand(1000, 9999) . '.' . $request->file('image')->getClientOriginalExtension();
                $destinationPath = public_path('/assets/uploads/user');
                $request->file('image')->move($destinationPath, $image);
            }

            $activation_code = CodeHelper::generateRandomCode(8);
            $activation_code_encode = CodeHelper::encodeCode($activation_code);
            $email_encode = CodeHelper::encodeCode($request->email);

            $id = IdGenerator::generate('USR', 'users');
            $save = User::insert([
                'id' => $id,
                'name' => $request->name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'active' => ($request->active ? 1 : 0),
                'email_verified_at' => ($request->active ? date('Y-m-d H:i:s') : null),
                'image' => $image,
                'password' => password_hash('password', PASSWORD_DEFAULT),
                'activation_code' => $activation_code,
                'created_by' => Auth::user()->id,
                'created_at' => date('Y-m-d H:i:s'),
            ]);

            $user = User::where('id', $id)->first();

            $company_profile = CompanyProfile::first();
            $url_activation = route('paneladmin.register.activation', ['email' => $email_encode, 'code' => $activation_code_encode]);
            Mail::to($request->email)->send(new ActivationRegisterEmail($user, $url_activation, 'Your account is ready to be activated!', $company_profile));

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
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = User::where('id', $id)->first();
        return view('backend.masterdata.masteruser.detail', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = User::where('id', $id)->first();
        return view('backend.masterdata.masteruser.form', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MasterUserRequest $request, string $id)
    {
        DB::beginTransaction();
        try{
            $user = User::where('id', $id)->first();
        
            $image = $user->image;
            if (!empty($request->file('image'))) {
                if (File::exists(public_path('assets/uploads/user/' . $user->image))) {
                    File::delete(public_path('assets/uploads/user/' . $user->image));
                }
                $image = time() .'-'. rand(1000, 9999) . '.' . $request->file('image')->getClientOriginalExtension();
                $destinationPath = public_path('/assets/uploads/user');
                $request->file('image')->move($destinationPath, $image);
            }

            $activation_code = CodeHelper::generateRandomCode(8);
            $activation_code_encode = CodeHelper::encodeCode($activation_code);
            $email_encode = CodeHelper::encodeCode($request->email);

            if($user->email != $request->email){
                $company_profile = CompanyProfile::first();
                $url_activation = route('paneladmin.register.activation', ['email' => $email_encode, 'code' => $activation_code_encode]);
                Mail::to($request->email)->send(new ActivationRegisterEmail($user, $url_activation, 'Your account is ready to be activated!', $company_profile));
            }

            $save = $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'active' => ($user->email != $request->email) ? 0 : ($request->active ? 1 : 0),
                'email_verified_at' => ($request->active ? date('Y-m-d H:i:s') : null),
                'image' => $image,
                'updated_by' => Auth::guard('web')->user()->id,
                'updated_at' => date('Y-m-d H:i:s'),
                'activation_code' => (($user->email == $request->email)? $user->activation_code : $activation_code),
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
            $show = User::where('id', $id)->first();
            if($show->image){
                if (File::exists(public_path('assets/uploads/user/' . $show->image))) {
                    File::delete(public_path('assets/uploads/user/' . $show->image));
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
