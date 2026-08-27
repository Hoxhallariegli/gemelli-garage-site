<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobService extends Model
{
    use HasFactory;

    protected $with = ['service'];

    protected $fillable = ['job_id', 'service_id', 'price'];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
