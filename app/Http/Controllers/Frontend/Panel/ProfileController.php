<?php

namespace App\Http\Controllers\Frontend\Panel;

use App\Helpers\IdGenerator;
use App\Http\Controllers\Controller;
use App\Models\CompanyProfile;
use App\Models\Customers;
use App\Models\Products;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index(){
        $customer = Customers::where('id', Auth::guard('customer')->user()->id)->first();
        return view('frontend.panel.profile.index', compact('customer'));
    }
}
