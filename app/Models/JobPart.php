<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobPart extends Model
{
    use HasFactory;

    protected $with = ['part'];

    protected $fillable = ['job_id', 'part_id', 'quantity', 'cost_price', 'sell_price'];

    protected $casts = [
        'cost_price' => 'decimal:2',
        'sell_price' => 'decimal:2',
    ];

    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    public function part()
    {
        return $this->belongsTo(Part::class);
    }
}
