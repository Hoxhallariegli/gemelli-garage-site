<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobMaterial extends Model
{
    use HasFactory;

    protected $with = ['material'];

    protected $fillable = ['job_id', 'material_id', 'quantity', 'cost_price', 'sell_price'];

    protected $casts = [
        'quantity' => 'decimal:2',
        'cost_price' => 'decimal:2',
        'sell_price' => 'decimal:2',
    ];

    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    public function material()
    {
        return $this->belongsTo(Material::class);
    }
}
