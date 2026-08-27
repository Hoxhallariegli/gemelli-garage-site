<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'amount', 'date', 'category', 'job_id', 'notes'];

    protected function casts(): array {
        return [
            'date' => 'date',
            'amount' => 'decimal:2',
        ];
    }

    public static function rules($id = null): array {
        return [
            'title' => ['required', 'string', 'max:255'],
            'amount' => ['required', 'numeric', 'min:0'],
            'date' => ['required', 'date'],
            'category' => ['required', \Illuminate\Validation\Rule::in(['rent', 'electricity', 'water', 'supplies', 'salary', 'marketing', 'other'])],
            'job_id' => ['nullable', 'integer', 'exists:jobs,id'],
            'notes' => ['nullable', 'string'],
        ];
    }

    public static function sortable(): array {
        return ['id', 'title', 'amount', 'date', 'category'];
    }

    public function job(): \Illuminate\Database\Eloquent\Relations\BelongsTo {
        return $this->belongsTo(\App\Models\Job::class, 'job_id');
    }
}
