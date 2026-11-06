<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Garage extends Model
{
    use HasFactory, \App\Models\Traits\BelongsToGarage;

    protected $fillable = [
        'name',
        'slug',
        'owner_id',
        'phone',
        'email',
        'address',
        'city',
        'logo',
        'sms_enabled',
        'whatsapp_enabled',
        'reminder_hours_before',
        'active',
    ];

    protected function casts(): array
    {
        return [
            'sms_enabled' => 'boolean',
            'whatsapp_enabled' => 'boolean',
            'active' => 'boolean',
            'reminder_hours_before' => 'integer',
        ];
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'garage_user');
    }
}
