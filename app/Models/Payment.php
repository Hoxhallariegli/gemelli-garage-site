<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $fillable = ['job_id', 'amount', 'method', 'payment_date'];
    protected function casts(): array { return [
            'amount' => 'decimal:2',
            'payment_date' => 'datetime',
        ]; }
    public static function rules($id = null): array { return [
            'job_id' => ['required', 'integer'],
            'amount' => ['required', 'numeric'],
            'method' => ['required', \Illuminate\Validation\Rule::in(['cash', 'card', 'transfer'])],
            'payment_date' => ['required', 'date'],
        ]; }
    public static function sortable(): array { return ['id', 'job_id', 'amount', 'method', 'payment_date']; }

    public function job(): \Illuminate\Database\Eloquent\Relations\BelongsTo { return $this->belongsTo(\App\Models\Job::class, 'job_id'); }

}