<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class DocumentationController extends Controller
{
    public function index(){
        return view('backend.documentation.index');
    }
    
    public function show($code){
        $filename = $code.'.pdf';

        if (!File::exists(public_path('assets/image/upload/documentation/' . $filename))) {
            return redirect()->back();
        }
        return view('backend.documentation.detail', compact('filename'));
    }
}
