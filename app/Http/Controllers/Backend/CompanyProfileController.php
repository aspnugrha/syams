<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyProfileRequest;
use App\Models\CompanyProfile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class CompanyProfileController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = CompanyProfile::first();
        return view('backend.companyprofile.form', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CompanyProfileRequest $request, string $id)
    {
        DB::beginTransaction();
        try{
            $company_profile = CompanyProfile::where('id', $id)->first();
        
            $logo = $company_profile->logo;
            if (!empty($request->file('logo'))) {
                if (File::exists(public_path('assets/image/upload/logo/' . $company_profile->logo))) {
                    File::delete(public_path('assets/image/upload/logo/' . $company_profile->logo));
                }
                $logo = time() .'-'. rand(1000, 9999) . '.' . $request->file('logo')->getClientOriginalExtension();
                $destinationPath = public_path('/assets/image/upload/logo');
                $request->file('logo')->move($destinationPath, $logo);
            }
            
            $pavicon = $company_profile->pavicon;
            if (!empty($request->file('pavicon'))) {
                if (File::exists(public_path('assets/image/upload/pavicon/' . $company_profile->pavicon))) {
                    File::delete(public_path('assets/image/upload/pavicon/' . $company_profile->pavicon));
                }
                $pavicon = time() .'-'. rand(1000, 9999) . '.' . $request->file('pavicon')->getClientOriginalExtension();
                $destinationPath = public_path('/assets/image/upload/pavicon');
                $request->file('pavicon')->move($destinationPath, $pavicon);
            }

            $banner = ($company_profile->banner ? json_decode($company_profile->banner, true) : null);
            
            $banner_landing_page = ($banner ? $banner['banner_landing_page'] : null);
            if (!empty($request->file('banner_landing_page'))) {
                if (File::exists(public_path('assets/image/upload/banner/' . ($banner ? $banner['banner_landing_page'] : null)))) {
                    File::delete(public_path('assets/image/upload/banner/' . ($banner ? $banner['banner_landing_page'] : null)));
                }
                $banner_landing_page = time() .'-'. rand(1000, 9999) . '.' . $request->file('banner_landing_page')->getClientOriginalExtension();
                $destinationPath = public_path('/assets/image/upload/banner');
                $request->file('banner_landing_page')->move($destinationPath, $banner_landing_page);
            }

            $banner_showcase = ($banner ? $banner['banner_showcase'] : null);
            if (!empty($request->file('banner_showcase'))) {
                if (File::exists(public_path('assets/image/upload/banner/' . ($banner ? $banner['banner_showcase'] : null)))) {
                    File::delete(public_path('assets/image/upload/banner/' . ($banner ? $banner['banner_showcase'] : null)));
                }
                $banner_showcase = time() .'-'. rand(1000, 9999) . '.' . $request->file('banner_showcase')->getClientOriginalExtension();
                $destinationPath = public_path('/assets/image/upload/banner');
                $request->file('banner_showcase')->move($destinationPath, $banner_showcase);
            }

            $new_banner = json_encode([
                'banner_landing_page' => $banner_landing_page,
                'banner_showcase' => $banner_showcase,
            ]);

            $save = $company_profile->update([
                'name' => $request->name,
                'description' => $request->description,
                'alamat' => $request->alamat,
                'logo' => $logo,
                'pavicon' => $pavicon,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'whatsapp' => $request->whatsapp,
                'imessage' => $request->imessage,
                'facebook' => $request->facebook,
                'instagram' => $request->instagram,
                'twitter' => $request->twitter,
                'youtube' => $request->youtube,
                'tiktok' => $request->tiktok,
                'maps' => $request->maps,
                'privacy' => $request->privacy,
                'refund' => $request->refund,
                'shipping' => $request->shipping,
                'banner' => $new_banner,
                'updated_by' => Auth::guard('web')->user()->id,
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
}
