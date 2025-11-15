<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\IdGenerator;
use App\Http\Controllers\Controller;

class SampleController extends Controller
{
    public function index(){
        return view('frontend.sample.index');
    }
}
