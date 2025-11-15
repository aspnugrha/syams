<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\IdGenerator;
use App\Http\Controllers\Controller;
use App\Models\Products;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(){
        $products = Products::where('active', 1)->inRandomOrder()->get()->map(function ($item) {
            $item->size_qty = ($item->size_qty_options ? json_decode($item->size_qty_options) : null);
            return $item;
        });

        return view('frontend.order.index', compact('products'));
    }

    public function store(Request $request){
        dd($request->all());
    }
}
