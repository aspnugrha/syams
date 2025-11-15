<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\IdGenerator;
use App\Http\Controllers\Controller;
use App\Models\CompanyProfile;
use App\Models\Products;

class HomeController extends Controller
{
    public function index(){
        $products = Products::where('active', 1)->inRandomOrder()->get();

        return view('frontend.home.index', compact('products'));
    }

    public function contactUs(){
        $company = CompanyProfile::first();
        
        return view('frontend.contact.index', compact('company'));
    }
}
