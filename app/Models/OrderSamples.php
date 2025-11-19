<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderSamples extends Model
{
    use HasFactory;

    protected $table = 'order_samples';

    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'date_order',
        'customer_id',
        'customer_name',
        'customer_email',
        'customer_phone_number',
        'notes',
        'status',
        'created_by',
        'updated_by',
    ];
}
