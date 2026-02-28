<?php

namespace App\Http\Controllers\Backend;

use App\Exports\ProductExport;
use App\Helpers\CodeHelper;
use App\Helpers\IdGenerator;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Categories;
use App\Models\Products;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends Controller
{
    public function loadData(Request $request){
        $data = Products::loadData($request);

        $response = [
            'success' => true,
            'recordsTotal' => $data['recordsTotal'],
            'recordsFiltered' => $data['recordsFiltered'],
            'data' => ProductResource::collection($data['data']),
        ];
        
        return response()->json($response, Response::HTTP_OK);
    }

    public function export(Request $request){
        return Excel::download(new ProductExport($request), 'product.xlsx');
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Categories::get();
        return view('backend.product.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Categories::get();
        $materials = json_decode(json_encode(Products::getDataMaterials()));
        return view('backend.product.form', compact('categories', 'materials'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        DB::beginTransaction();
        try{
            // dd($request->all());
            $cover = null;
            if (!empty($request->file('cover'))) {
                $cover = time() .'-'. rand(1000, 9999) . '.' . $request->file('cover')->getClientOriginalExtension();
                $destinationPath = public_path('/assets/image/upload/product');
                $request->file('cover')->move($destinationPath, $cover);
            }
            
            $images = [];
            if (!empty($request->file('images'))) {
                foreach($request->file('images') as $image){
                    $image_name = time() .'-'. rand(1000, 9999) . '.' . $image->getClientOriginalExtension();
                    $destinationPath = public_path('/assets/image/upload/product');
                    $image->move($destinationPath, $image_name);
                    $images[] = $image_name;
                }
            }

            $size_qty_options = [];
            if(count($request->size_options)){
                for ($i=0; $i < count($request->size_options); $i++) { 
                    $size_qty_options[] = [
                        'size' => $request->size_options[$i],
                        'qty' => explode(',', $request->qty_options[$i]),
                    ];
                }
            }

            $material_color_options = [];
            // if(count($request->material_options)){
            //     foreach($request->material_options as $index_material => $material){
            //         $colors = [];
            //         if(count($request->color[$material])){
            //             foreach($request->color[$material] as $color){
            //                 $colors[] = [
            //                     'color' => $color,
            //                     'color_code' => $request->color_code[$material][$color],
            //                 ];
            //             }
            //         }

            //         $material_color_options[] = [
            //             'material' => $material,
            //             'colors' => $colors,
            //         ];
            //     }
            // }
            if(count($request->material_color_options)){
                foreach($request->material_color_options as $index_material => $material){
                    $get_material = Products::getDataMaterials($material);
                    $material_color_options[] = $get_material;
                }
            }
            // dd($material_color_options);

            $request['sablon_type'] = implode(',', $request->sablon_type);

            $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $request->name), '-'));
            $cek_slug = Products::where('slug', $slug)->first();

            $id = IdGenerator::generate('PRDCT', 'products');
            $save = Products::insert([
                'id' => $id,
                'type' => $request->type,
                'category_id' => $request->category_id,
                'slug' => ($cek_slug ? $slug.'-'.CodeHelper::generateRandomCode(4) : $slug),
                'name' => $request->name,
                'description' => $request->description,
                'cover' => $cover,
                'image' => ($images ? implode(',', $images) : null),
                'size_qty_options' => ($size_qty_options ? json_encode($size_qty_options) : null),
                'material_color_options' => ($material_color_options ? json_encode($material_color_options) : null),
                'sablon_type' => $request->sablon_type,
                'bordir' => ($request->bordir ? implode(',', $request->bordir) : null),
                'input_settings' => ($request->input_settings ? implode(',', $request->input_settings) : null),
                // 'is_bordir' => ($request->is_bordir ? 1 : 0),
                'active' => ($request->active ? 1 : 0),
                'created_by' => Auth::user()->id,
                'created_at' => date('Y-m-d H:i:s'),
            ]);

            Cache::flush();
            DB::commit();

            return response()->json([
                'response' => $save,
                'success' => true,
                'status' => 'success',
            ]);
        } catch (\Exception $exc) {
            DB::rollBack();
            return $exc;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $id = CodeHelper::decodeCode($id);
        $product = Products::with(['hasCategory'])->where('id', $id)->first();
        $product['images'] = ($product->image ? explode(',', $product->image) : null);
        $product['size_qty_option_decode'] = ($product->size_qty_options ? json_decode($product->size_qty_options) : null);
        $product['material_color_option_decode'] = ($product->material_color_options ? json_decode($product->material_color_options) : null);

        return view('backend.product.detail', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $categories = Categories::get();
        $id = CodeHelper::decodeCode($id);
        $data = Products::where('id', $id)->first();
        $data['images'] = ($data->image ? explode(',', $data->image) : null);
        $data['size_qty_option_decode'] = ($data->size_qty_options ? json_decode($data->size_qty_options) : null);
        $data['material_color_option_decode'] = ($data->material_color_options ? json_decode($data->material_color_options) : null);
        $materials = json_decode(json_encode(Products::getDataMaterials()));

        return view('backend.product.form', compact('data', 'categories', 'materials'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, string $id)
    {
        DB::beginTransaction();
        try{
            $product = Products::where('id', $id)->first();

            $image_old = ($product->image ? explode(',', $product->image) : []);
            $image_new = ($request->old_images ? explode(',', $request->old_images) : []);
            $deleted_image = array_diff($image_old, $image_new);
            
            if($image_old != null && $deleted_image != null){
                foreach($deleted_image as $di){
                    if (File::exists(public_path('assets/image/upload/product/' . $di))) {
                        File::delete(public_path('assets/image/upload/product/' . $di));
                    }
                }
            }

            $cover = $product->cover;
            if (!empty($request->file('cover'))) {
                $cover = time() .'-'. rand(1000, 9999) . '.' . $request->file('cover')->getClientOriginalExtension();
                $destinationPath = public_path('/assets/image/upload/product');
                $request->file('cover')->move($destinationPath, $cover);
            }

            // dd($image_old, $image_new, $request->images, $request->list_images);
            
            $images = $image_new;
            if (!empty($request->file('images'))) {
                foreach($request->file('images') as $image){
                    $image_name = time() .'-'. rand(1000, 9999) . '.' . $image->getClientOriginalExtension();
                    $destinationPath = public_path('/assets/image/upload/product');
                    $image->move($destinationPath, $image_name);
                    $images[] = $image_name;
                }
            }

            $size_qty_options = [];
            if(count($request->size_options)){
                for ($i=0; $i < count($request->size_options); $i++) { 
                    $size_qty_options[] = [
                        'size' => $request->size_options[$i],
                        'qty' => explode(',', $request->qty_options[$i]),
                    ];
                }
            }

            $material_color_options = [];
            // if(count($request->material_options)){
            //     foreach($request->material_options as $index_material => $material){
            //         $colors = [];
            //         if(count($request->color[$material])){
            //             foreach($request->color[$material] as $color){
            //                 $colors[] = [
            //                     'color' => $color,
            //                     'color_code' => $request->color_code[$material][$color],
            //                 ];
            //             }
            //         }

            //         $material_color_options[] = [
            //             'material' => $material,
            //             'colors' => $colors,
            //         ];
            //     }
            // }
            if(count($request->material_color_options)){
                foreach($request->material_color_options as $index_material => $material){
                    $get_material = Products::getDataMaterials($material);
                    $material_color_options[] = $get_material;
                }
            }

            $request['sablon_type'] = implode(',', $request->sablon_type);

            $id = IdGenerator::generate('PRDCT', 'products');
            $product->update([
                'category_id' => $request->category_id,
                'name' => $request->name,
                'description' => $request->description,
                'cover' => $cover,
                'image' => ($images ? implode(',', $images) : null),
                'size_qty_options' => ($size_qty_options ? json_encode($size_qty_options) : null),
                'material_color_options' => ($material_color_options ? json_encode($material_color_options) : null),
                'sablon_type' => $request->sablon_type,
                // 'is_bordir' => ($request->is_bordir ? 1 : 0),
                'bordir' => ($request->bordir ? implode(',', $request->bordir) : null),
                'input_settings' => ($request->input_settings ? implode(',', $request->input_settings) : null),
                'active' => ($request->active ? 1 : 0),
                'updated_by' => Auth::guard('web')->user()->id,
                'updated_at' => date('Y-m-d H:i:s'),
            ]);

            Cache::flush();
            DB::commit();

            $product = Products::where('id', $id)->first();

            return response()->json([
                'response' => $product,
                'success' => true,
                'status' => 'success',
            ]);
        } catch (\Exception $exc) {
            DB::rollBack();
            return $exc;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();
        try{
            $show = Products::where('id', $id)->first();
            if($show->cover){
                if (File::exists(public_path('assets/image/upload/product/' . $show->cover))) {
                    File::delete(public_path('assets/image/upload/product/' . $show->cover));
                }
            }
            if($show->image){
                foreach(explode(',', $show->image) as $image){
                    if (File::exists(public_path('assets/image/upload/product/' . $image))) {
                        File::delete(public_path('assets/image/upload/product/' . $image));
                    }
                }
            }
            $delete = $show->delete();

            Cache::flush();
            DB::commit();

            return response()->json([
                'response' => $delete,
                'success' => true,
                'status' => 'success',
            ]);
        } catch (\Exception $exc) {
            DB::rollBack();
            return $exc;
        }
    }
    
    public function mainProduct(string $id, $status)
    {
        DB::beginTransaction();
        try{
            $id = CodeHelper::decodeCode($id);
            $show = Products::where('id', $id)->first();

            $check_main_product = Products::where('main_product', 1)->get()->count();
            if($check_main_product >= 4){
                if(!$status){
                    return response()->json([
                        'response' => 'error',
                        'success' => false,
                        'status' => 'main-product-limit',
                        'message' => 'Sorry, main product is only available for 4 products!'
                    ]);
                }
            }

            $show->update([
                'main_product' => ($status ? 0 : 1),
                'updated_by' => Auth::guard('web')->user()->id,
                'updated_at' => date('Y-m-d H:i:s'),
            ]);

            Cache::flush();
            DB::commit();

            return response()->json([
                'response' => $show,
                'success' => true,
                'status' => 'success',
            ]);
        } catch (\Exception $exc) {
            DB::rollBack();
            return $exc;
        }
    }
}
