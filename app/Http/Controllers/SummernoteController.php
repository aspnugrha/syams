<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SummernoteController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    
     public function upload(Request $request){
        $request->validate([
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $urls = [];

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $random_string = substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(5/strlen($x)) )),1,5);
                $filename = date('YmdHis') . '_' . $random_string . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('assets/image/upload/'.$request->folder), $filename);
                $urls[] = asset('assets/image/upload/'.$request->folder . '/' . $filename);
            }
            return response()->json($urls);
        }

        return response()->json(['error' => 'Tidak ada file yang diupload'], 400);
     }

     public function delete(Request $request)
    {
        $imageUrl = $request->input('image_url');

        // Validasi bahwa path-nya berada di folder assets/image/upload
        $baseUrl = asset('assets/image/upload/'.$request->folder.'/');

        $pisah_url = explode('/summernote/', $imageUrl);
        $domain = parse_url($imageUrl, PHP_URL_HOST);
        $myDomain = parse_url(url('/'), PHP_URL_HOST);
        
        if($domain === $myDomain){
            $imageName = $pisah_url[1];
            if (strpos($imageUrl, $baseUrl) === 0) {
                $fullPath = public_path('assets/image/upload/'.$request->folder).'/'.$imageName;

                if (file_exists($fullPath)) {
                    unlink($fullPath);
                    return response()->json(['success' => true]);
                } else {
                    return response()->json(['error' => 'File tidak ditemukan'], 404);
                }
            }
        }

        return response()->json(['error' => 'URL tidak valid'], 400);
    }

}
