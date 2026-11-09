<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory, \App\Models\Traits\BelongsToGarage;

    protected $fillable = ['tenant_id', 'name', 'description', 'base_price', 'active', 'image'];

    protected function casts(): array {
        return [
            'base_price' => 'decimal:2',
            'active' => 'boolean',
        ];
    }

    public static function rules($id = null): array {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'base_price' => ['required', 'numeric'],
            'active' => ['required', 'boolean'],
            'image' => ['nullable', 'string'],
        ];
    }

    public static function sortable(): array {
        return ['id', 'name', 'description', 'base_price', 'active'];
    }

    public function getResolvedImageAttribute(): string
    {
        if (!empty($this->image) && file_exists(public_path($this->image))) {
            return asset($this->image);
        }

        $name = strtolower($this->name);

        if (str_contains($name, 'oscuramento vetri') || str_contains($name, 'tinting') || str_contains($name, 'xham')) {
            return asset('assets/front/gemelli-garage/images/services/1.webp');
        }
        if (str_contains($name, 'fari') || str_contains($name, 'light')) {
            return asset('assets/front/gemelli-garage/images/services/2.webp');
        }
        if (str_contains($name, 'wrap')) {
            return asset('assets/front/gemelli-garage/images/services/3.webp');
        }
        if (str_contains($name, 'lucidatura') || str_contains($name, 'polishing') || str_contains($name, 'polir')) {
            return asset('assets/front/gemelli-garage/images/services/4.webp');
        }
        if (str_contains($name, 'detailing')) {
            return asset('assets/front/gemelli-garage/images/services/5.webp');
        }

        $num = (($this->id % 6) ?: 1);
        return asset("assets/front/gemelli-garage/images/services/{$num}.webp");
    }

    public function getResolvedDescriptionAttribute(): string
    {
        if (!empty($this->description)) {
            return $this->description;
        }

        $name = strtolower($this->name);

        if (str_contains($name, 'oscuramento vetri') || str_contains($name, 'tinting') || str_contains($name, 'xham')) {
            return __('front.tinting_desc');
        }
        if (str_contains($name, 'fari') || str_contains($name, 'light')) {
            return __('front.light_tinting_desc');
        }
        if (str_contains($name, 'wrap')) {
            return __('front.wrapping_desc');
        }
        if (str_contains($name, 'lucidatura') || str_contains($name, 'polishing') || str_contains($name, 'polir')) {
            return __('front.polishing_desc');
        }
        if (str_contains($name, 'detailing')) {
            return __('front.detailing_desc');
        }

        return __('front.choose_treatment');
    }
}
