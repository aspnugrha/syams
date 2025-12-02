<?php

namespace App\Models;

use Carbon\Carbon;
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

    public static function getDataChart($request){
        $data = NULL;
        DB::beginTransaction();
        try {
            $raw = DB::table('orders')
                ->select([
                    $request->mode === 'day'
                        ? DB::raw("DATE(created_at) as key_date")
                        : DB::raw("DATE_FORMAT(created_at, '%Y-%m') as key_date"),

                    DB::raw("COUNT(*) as total"),
                    DB::raw("SUM(CASE WHEN order_type = 'ORDER' THEN 1 ELSE 0 END) as total_order"),
                    DB::raw("SUM(CASE WHEN order_type = 'SAMPLE' THEN 1 ELSE 0 END) as total_sample"),
                ])
                ->whereBetween('created_at', [$request->start_date, $request->end_date])
                ->groupBy('key_date')
                ->orderBy('key_date')
                ->get()
                ->keyBy('key_date'); // supaya mudah dicocokkan 
            
            $labels = [];
            $totalData = [];
            $totalDataSample = [];
            $totalDataOrder = [];

            $cursor = $request->start_date->copy();

            while ($cursor <= $request->end_date) {

                if ($request->mode === 'day') {
                    $key = $cursor->format('Y-m-d');
                    $label = $cursor->translatedFormat('d F Y');
                    $cursor->addDay();
                } else {
                    $key = $cursor->format('Y-m');
                    $label = $cursor->translatedFormat('F Y');
                    $cursor->addMonth();
                }

                $data = $raw[$key] ?? null;

                // simpan label
                $labels[] = $label;

                // simpan semua data
                $totalData[]        = $data->total ?? 0;
                $totalDataSample[]  = $data->total_sample ?? 0;
                $totalDataOrder[]   = $data->total_order ?? 0;
            }

            $data = [
                'label' => $labels,
                'data' => [
                    'total_data'         => $totalData,
                    'total_data_sample'  => $totalDataSample,
                    'total_data_order'   => $totalDataOrder,
                ],
            ];

            Cache::flush();
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            $data = $th;
        }
        return $data;
    }

    public static function getRecentOrders($request){
        $data = NULL;
        DB::beginTransaction();
        try {
            $data = Orders::orderBy('created_at', 'DESC')
                ->when(request()->customer_id != null, function ($query) {
                    $query->where('customer_id', request()->customer_id);
                })
                ->when(request()->order_type != null, function ($query) {
                    $query->where('order_type', request()->order_type);
                })
                ->when(request()->created_at != null, function ($query) {
                    $created_ranges = explode(' - ', request()->created_at);
                    $query->where('created_at', '>=', date('Y-m-d H:i:s', strtotime($created_ranges[0].' 00:00:00')));
                    $query->where('created_at', '<=', date('Y-m-d H:i:s', strtotime($created_ranges[1].' 23:59:59')));
                })
                ->limit($request->limit)
                ->get();

            Cache::flush();
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            $data = $th;
        }
        return $data;
    }
}
