<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BodyType extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'wrap_meters', 'image'];
    protected function casts(): array { return [
            'wrap_meters' => 'decimal:2',
        ]; }
    public static function rules($id = null): array { return [
            'name' => ['required', 'string', 'max:255'],
            'wrap_meters' => ['required', 'numeric'],
            'image' => ['nullable', 'string', 'max:255'],
        ]; }
    public static function sortable(): array { return ['id', 'name', 'wrap_meters', 'image']; }

}