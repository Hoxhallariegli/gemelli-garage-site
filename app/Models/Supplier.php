<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'contact_person', 'phone', 'email'];
    protected function casts(): array { return [
        ]; }
    public static function rules($id = null): array { return [
            'name' => ['required', 'string', 'max:255'],
            'contact_person' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'string', 'max:255'],
        ]; }
    public static function sortable(): array { return ['id', 'name', 'contact_person', 'phone', 'email']; }

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }
}
