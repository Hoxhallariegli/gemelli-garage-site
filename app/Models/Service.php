<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description', 'base_price', 'active', 'image'];
    protected function casts(): array { return [
            'base_price' => 'decimal:2',
            'active' => 'boolean',
        ]; }
    public static function rules($id = null): array { return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'base_price' => ['required', 'numeric'],
            'active' => ['required', 'boolean'],
            'image' => ['nullable', 'string'],
        ]; }
    public static function sortable(): array { return ['id', 'name', 'description', 'base_price', 'active']; }

}
