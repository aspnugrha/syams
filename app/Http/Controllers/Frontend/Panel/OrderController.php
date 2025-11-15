<?php

namespace App\Http\Controllers\Frontend\Panel;

use App\Helpers\IdGenerator;
use App\Http\Controllers\Controller;
use App\Models\CompanyProfile;
use App\Models\Products;

class OrderController extends Controller
{
    public function index(){
        return view('frontend.panel.order.index');
    }
}
