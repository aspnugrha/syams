<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\IdGenerator;
use App\Http\Controllers\Controller;
use App\Models\Products;

use function PHPSTORM_META\map;

class PortofolioController extends Controller
{
    public function index(){
        $covers = Products::select('cover')->where('active', 1)->inRandomOrder()->groupBy('cover')->get();
        $get_products = Products::where('active', 1)->inRandomOrder()->get();
        $products = [];
        if($get_products){
            foreach($get_products as $product){
                if($product->image){
                    $data_product = [
                        'name' => $product->name,
                        'slug' => $product->slug,
                    ];
                    
                    if(str_contains($product->image, ',')){
                        $image = explode(',', $product->image);
                        $image.map(function($item){
                            $data_product['image'] = $item;
                            $products[] = $data_product;
                        });
                    }else{
                        $data_product['image'] = $product->image;
                        $products[] = $data_product;
                    }
                }
            }
        }

        return view('frontend.portofolio.index', compact('products', 'covers'));
    }
    
    public function detail($slug){
        $product = Products::where('slug', $slug)->first();

        return view('frontend.portofolio.detail', compact('product'));
    }
}
