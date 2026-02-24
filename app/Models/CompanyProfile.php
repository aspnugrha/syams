<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyProfile extends Model
{
    use HasFactory;

    protected $table = 'company_profiles';

    protected $primaryKey = 'id';

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'name',
        'pavicon',
        'logo',
        'alamat',
        'description',
        'email',
        'phone_number',
        'whatsapp',
        'imessage',
        'facebook',
        'instagram',
        'twitter',
        'youtube',
        'tiktok',
        'privacy',
        'refund',
        'shipping',
        'maps',
        'banner',
        'created_by',
        'updated_by',
    ];
}
