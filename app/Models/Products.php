<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class Products extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'type',
        'category_id',
        'slug',
        'name',
        'description',
        'cover',
        'image',
        'size_qty_options',
        'material_color_options',
        'sablon_type',
        'is_bordir',
        'active',
        'main_product',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
    ];

    public function hasCategory(){
        return $this->belongsTo(Categories::class, 'category_id', 'id');
    }

    public static function loadData($request){
        $data = NULL;
        DB::beginTransaction();
        try {
            $get_data = Products::orderBy('main_product', 'desc')->orderBy('created_at', 'DESC')
                ->when(request()->search['value'], function ($query) {
                    $query->where('name', 'like', '%' . request()->search['value'] . '%');
                    $query->orWhere('description', 'like', '%' . request()->search['value'] . '%');
                })
                ->when(request()->category_id != null, function ($query) {
                    $query->where('category_id', request()->category_id);
                })
                ->when(request()->type != null, function ($query) {
                    $query->where('type', request()->type);
                })
                ->when(request()->active != null, function ($query) {
                    $query->where('active', request()->active);
                })
                ->when(request()->created_at != null, function ($query) {
                    $created_ranges = explode(' - ', request()->created_at);
                    $query->where('created_at', '>=', date('Y-m-d H:i:s', strtotime($created_ranges[0].' 00:00:00')));
                    $query->where('created_at', '<=', date('Y-m-d H:i:s', strtotime($created_ranges[1].' 23:59:59')));
                });

            $data = [
                'recordsTotal' => $get_data->count(),
                'recordsFiltered' => $get_data->count(),
                'data' => $get_data->skip($request->input('start'))->take($request->input('length'))->get()
            ];

            Cache::flush();
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            $data = $th;
        }
        return $data;
    }
}
