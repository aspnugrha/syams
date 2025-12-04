<?php

namespace App\Http\Controllers\Backend;

use App\Helpers\CodeHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyProfileRequest;
use App\Http\Requests\PasswordCustomerRequest;
use App\Http\Requests\ProfileAdminRequest;
use App\Mail\ActivationRegisterEmail;
use App\Mail\CustomerNewPasswordEmail;
use App\Models\CompanyProfile;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ProfileAdminController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     */
    public function index()
    {
        $data = User::where('id', Auth::user()->id)->first();
        return view('backend.profile.form', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateProfile(ProfileAdminRequest $request){
        DB::beginTransaction();
        try{
            $user = User::where('id', $request->id)->first();
        
            $image = $user->image;
            if (!empty($request->file('image'))) {
                if (File::exists(public_path('assets/image/upload/user/' . $user->image))) {
                    File::delete(public_path('assets/image/upload/user/' . $user->image));
                }
                $image = time() .'-'. rand(1000, 9999) . '.' . $request->file('image')->getClientOriginalExtension();
                $destinationPath = public_path('/assets/image/upload/user');
                $request->file('image')->move($destinationPath, $image);
            }

            $activation_code = CodeHelper::generateRandomCode(8);
            
            $send_email = false;
            if($user->email != $request->email){
                $send_email = true;
            }

            $save = $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone_number' => ($request->phone_number ? $request->phone_number : $user->phone_number),
                'image' => $image,
                'activation_code' => ($user->email != $request->email ? $activation_code : $user->activation_code),
                'email_verified_at' => ($user->email != $request->email ? null : $user->email_verified_at),
                'active' => ($user->email != $request->email ? 0 : $user->active),
                'updated_by' => Auth::user()->id,
                'updated_at' => date('Y-m-d H:i:s'),
            ]);

            if($send_email){
                $user = User::where('id', $request->id)->first();
                $activation_code_encode = CodeHelper::encodeCode($activation_code);
                $email_encode = CodeHelper::encodeCode($request->email);
                
                $company_profile = CompanyProfile::first();
                $url_activation = route('paneladmin.register.activation', ['email' => $email_encode, 'code' => $activation_code_encode]);
                Mail::to($request->email)->send(new ActivationRegisterEmail($user, $url_activation, 'Your account is ready to be activated!', $company_profile));

                Auth::logout();
            }

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
    
    public function setNewPassword(PasswordCustomerRequest $request){
        DB::beginTransaction();
        try{
            $user = User::where('id', $request->id)->first();

            if($user){
                if(Hash::check($request->old_password, $user->password)){
                    $save = $user->update([
                        'password' => password_hash($request->new_password, PASSWORD_DEFAULT),
                        'updated_by' => Auth::user()->id,
                        'updated_at' => date('Y-m-d H:i:s'),
                    ]);

                    $company_profile = CompanyProfile::first();
                    Mail::to($user->email)->send(new CustomerNewPasswordEmail($user, $company_profile));

                    Cache::flush();
                    DB::commit();

                    return response()->json([
                        'response' => $save,
                        'success' => true,
                        'status' => 'success',
                    ]);
                }else{
                    return response()->json([
                        'message' => 'The password you entered is incorrect!',
                        'success' => false,
                        'status' => 'validation',
                        'validation' => [
                            [
                                'name' => 'old_password',
                                'value' => 'The password you entered is incorrect!'
                            ],
                        ],
                    ]);
                }
            }else{
                return response()->json([
                    'message' => 'Account not found!',
                    'success' => false,
                    'status' => 'not-found',
                ]);
            }
        } catch (\Exception $exc) {
            dd($exc);
            DB::rollBack();
            return $exc;
        }
    }
}
