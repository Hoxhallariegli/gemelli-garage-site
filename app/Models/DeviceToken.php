<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeviceToken extends Model
{
    use HasFactory, \App\Models\Traits\BelongsToGarage;

    protected $fillable = [
        'user_id',
        'tenant_id',
        'fcm_token',
        'device_name',
        'platform',
        'is_sms_gateway',
        'last_used_at',
    ];

    protected $casts = [
        'is_sms_gateway' => 'boolean',
        'last_used_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
