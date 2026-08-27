<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleBrand extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'logo'];
    protected function casts(): array { return [
        ]; }
    public static function rules($id = null): array { return [
            'name' => ['required', 'string', 'max:255'],
            'logo' => ['nullable', 'string', 'max:255'],
        ]; }
    public static function sortable(): array { return ['id', 'name', 'logo']; }

}