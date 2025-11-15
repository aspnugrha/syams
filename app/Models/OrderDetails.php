<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetails extends Model
{
    use HasFactory;

    protected $table = 'order_details';

    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'order_id',
        'product_id',
        'size_selected',
        'qty_selected',
        'notes',
        'status',
        'created_by',
        'updated_by',
    ];
}
