<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetails extends Model
{
    use HasFactory;

    protected $table = 'order_details';

    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'order_id',
        'product_id',
        'product_name',
        'product_category',
        'product_image',
        'size_selected',
        'qty_selected',
        'material_selected',
        'material_color_selected',
        'sablon_selected',
        'is_bordir',
        'mockup',
        'raw_file',
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

    public function order(){
        return $this->belongsTo(Orders::class, 'order_id', 'id');
    }

    public function hasProduct(){
        return $this->belongsTo(Products::class, 'product_id', 'id');
    }
}
