<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'phone', 'email', 'notes'];
    protected function casts(): array { return [
        ]; }
    public static function rules($id = null): array { return [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
        ]; }
    public static function sortable(): array { return ['id', 'name', 'phone', 'email', 'notes']; }

}