<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialBrand extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'image'];
    protected function casts(): array { return [
        ]; }
    public static function rules($id = null): array { return [
            'name' => ['required', 'string', 'max:255'],
            'image' => ['nullable'],
        ]; }
    public static function sortable(): array { return ['id', 'name', 'image']; }

}
