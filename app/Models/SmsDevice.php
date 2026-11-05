<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmsDevice extends Model
{
    use HasFactory, \App\Models\Traits\BelongsToGarage;

    protected $fillable = [
        'tenant_id',
        'fcm_token',
        'device_name',
        'api_key',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
