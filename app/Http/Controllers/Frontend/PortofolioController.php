<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\IdGenerator;
use App\Http\Controllers\Controller;
use App\Models\Products;

use function PHPSTORM_META\map;

class PortofolioController extends Controller
{
    public function index(){
        $product_showcase = Products::with(['hasCategory'])->where('active', 1)->where('type', 'SHOWCASE')->inRandomOrder()->get();
        $product_order = Products::with(['hasCategory'])->where('active', 1)->where('type', 'ORDER')->inRandomOrder()->get();

        return view('frontend.portofolio.index', compact('product_showcase', 'product_order'));
    }
    
    public function detail($slug){
        $product = Products::with(['hasCategory'])->where('slug', $slug)->first();

        if($product){
            if(!$product->active){
                return redirect()->route('showcase');
            }
        }else{
            return redirect()->route('showcase');
        }
        return view('frontend.portofolio.detail', compact('product'));
    }
}
