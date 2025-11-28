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
        'notes',
        'status',
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
