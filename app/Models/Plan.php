<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'duration_months',
        'max_users',
        'max_cars',
        'max_jobs',
        'active',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'duration_months' => 'integer',
            'max_users' => 'integer',
            'max_cars' => 'integer',
            'max_jobs' => 'integer',
            'active' => 'boolean',
        ];
    }
}
