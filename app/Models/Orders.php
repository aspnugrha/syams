<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class Orders extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'order_number',
        'order_type',
        'order_date',
        'customer_id',
        'customer_name',
        'customer_email',
        'customer_phone_number',
        'notes',
        'status',
        'approved_at',
        'canceled_at',
        'approved_by',
        'canceled_by_customer',
        'canceled_by',
        'created_by_customer',
        'updated_by_customer',
        'created_by',
        'updated_by',
    ];

    public function details(){
        return $this->hasMany(OrderDetails::class, 'order_id', 'id');
    }

    public static function loadDataCustomer($request){
        $data = NULL;
        DB::beginTransaction();
        try {
            $get_data = Orders::where('customer_id', Auth::guard('customer')->user()->id)
                ->when(request()->search, function ($query) {
                    $query->where('order_number', 'like', '%' . request()->search . '%');
                })
                ->when(request()->status != null, function ($query) {
                    $query->where('status', request()->status);
                })
                ->when(request()->order_type != null, function ($query) {
                    $query->where('order_type', request()->order_type);
                })
                ->when(request()->created_at != null, function ($query) {
                    $created_ranges = explode(' - ', request()->created_at);
                    $query->where('created_at', '>=', date('Y-m-d H:i:s', strtotime($created_ranges[0].' 00:00:00')));
                    $query->where('created_at', '<=', date('Y-m-d H:i:s', strtotime($created_ranges[1].' 23:59:59')));
                })
                ->orderBy('created_at', request()->order_by);

            $data = [
                'recordsTotal' => $get_data->count(),
                'recordsFiltered' => $get_data->skip($request->input('start'))->take($request->input('length'))->get()->count(),
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

    public static function loadData($request){
        $data = NULL;
        DB::beginTransaction();
        try {
            $get_data = Orders::orderBy('created_at', 'DESC')
                ->when(request()->search['value'], function ($query) {
                    $query->where('name', 'like', '%' . request()->search['value'] . '%');
                    $query->orWhere('description', 'like', '%' . request()->search['value'] . '%');
                })
                ->when(request()->category_id != null, function ($query) {
                    $query->where('category_id', request()->category_id);
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
