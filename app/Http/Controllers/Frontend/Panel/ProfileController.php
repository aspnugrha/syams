<?php

namespace App\Http\Controllers\Frontend\Panel;

use App\Helpers\CodeHelper;
use App\Helpers\IdGenerator;
use App\Http\Controllers\Controller;
use App\Http\Requests\PasswordCustomerRequest;
use App\Http\Requests\ProfileCustomerRequest;
use App\Mail\ActivationRegisterEmail;
use App\Mail\CustomerNewPasswordEmail;
use App\Models\CompanyProfile;
use App\Models\Customers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ProfileController extends Controller
{
    public function index(){
        $customer = Customers::where('id', Auth::guard('customer')->user()->id)->first();
        return view('frontend.panel.profile.index', compact('customer'));
    }

    public function updateProfile(ProfileCustomerRequest $request){
        DB::beginTransaction();
        try{
            $customer = Customers::where('id', $request->id)->first();
        
            $image = $customer->image;
            if (!empty($request->file('image'))) {
                if (File::exists(public_path('assets/image/upload/customer/' . $customer->image))) {
                    File::delete(public_path('assets/image/upload/customer/' . $customer->image));
                }
                $image = time() .'-'. rand(1000, 9999) . '.' . $request->file('image')->getClientOriginalExtension();
                $destinationPath = public_path('/assets/image/upload/customer');
                $request->file('image')->move($destinationPath, $image);
            }

            $activation_code = CodeHelper::generateRandomCode(8);
            
            $send_email = false;
            if($customer->email != $request->email){
                $send_email = true;
            }

            $save = $customer->update([
                'name' => $request->fullname,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'dial_code' => $request->dial_code,
                'country_code' => $request->country_code,
                'image' => $image,
                'activation_code' => ($customer->email != $request->email ? $activation_code : $customer->activation_code),
                'email_verified_at' => ($customer->email != $request->email ? null : $customer->email_verified_at),
                'active' => ($customer->email != $request->email ? 0 : $customer->active),
                'updated_by' => Auth::guard('customer')->user()->id,
                'updated_at' => date('Y-m-d H:i:s'),
            ]);

            if($send_email){
                $customer = Customers::where('id', $request->id)->first();
                $activation_code_encode = CodeHelper::encodeCode($activation_code);
                $email_encode = CodeHelper::encodeCode($request->email);
                
                $company_profile = CompanyProfile::first();
                $url_activation = route('register.activation', ['email' => $email_encode, 'code' => $activation_code_encode]);
                Mail::to($request->email)->send(new ActivationRegisterEmail($customer, $url_activation, 'Your account is ready to be activated!', $company_profile));

                Auth::guard('customer')->logout();
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
    
    public function updatePassword(PasswordCustomerRequest $request){
        DB::beginTransaction();
        try{
            $customer = Customers::where('id', $request->id)->first();

            if($customer){
                if(Hash::check($request->old_password, $customer->password)){
                    $save = $customer->update([
                        'password' => password_hash($request->new_password, PASSWORD_DEFAULT),
                        'updated_by' => Auth::guard('customer')->user()->id,
                        'updated_at' => date('Y-m-d H:i:s'),
                    ]);

                    $company_profile = CompanyProfile::first();
                    Mail::to($customer->email)->send(new CustomerNewPasswordEmail($customer, $company_profile));

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
            DB::rollBack();
            return $exc;
        }
    }
}
