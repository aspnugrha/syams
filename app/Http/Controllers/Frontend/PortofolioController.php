<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\IdGenerator;
use App\Http\Controllers\Controller;
use App\Models\Products;

use function PHPSTORM_META\map;

class PortofolioController extends Controller
{
    public function index(){
        $products = Products::with(['hasCategory'])->where('active', 1)->inRandomOrder()->get();

        return view('frontend.portofolio.index', compact('products'));
    }
    
    public function detail($slug){
        $product = Products::with(['hasCategory'])->where('slug', $slug)->first();

        return view('frontend.portofolio.detail', compact('product'));
    }
}
