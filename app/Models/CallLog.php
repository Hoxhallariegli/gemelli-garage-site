<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CallLog extends Model
{
    protected $fillable = [
        'phone_number',
        'caller_name',
        'type',
        'call_time',
        'is_client',
    ];

    protected $casts = [
        'call_time' => 'datetime',
        'is_client' => 'boolean',
    ];
}
