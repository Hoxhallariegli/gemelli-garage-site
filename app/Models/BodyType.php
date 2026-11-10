<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BodyType extends Model
{
    use HasFactory;

    protected $fillable = ['tenant_id', 'name', 'wrap_meters', 'image'];

    protected function casts(): array {
        return [
            'wrap_meters' => 'decimal:2',
        ];
    }

    public static function rules($id = null): array {
        return [
            'name' => ['required', 'string', 'max:255'],
            'wrap_meters' => ['required', 'numeric'],
            'image' => ['nullable', 'string', 'max:255'],
        ];
    }

    public static function sortable(): array {
        return ['id', 'name', 'wrap_meters', 'image'];
    }

    public function getResolvedImageAttribute(): string
    {
        $path = null;

        if (!empty($this->image) && file_exists(public_path($this->image))) {
            $path = public_path($this->image);
        } else {
            $name = strtolower($this->name);

            if (str_contains($name, 'convertible') || str_contains($name, 'cabrio')) {
                $path = public_path('body_types/convertible.webp');
            } elseif (str_contains($name, 'coupe') || str_contains($name, 'sports') || str_contains($name, 'supercar') || str_contains($name, 'hypercar') || str_contains($name, 'targa') || str_contains($name, 'liftback') || str_contains($name, 'fastback') || str_contains($name, 'roadster') || str_contains($name, 'shooting')) {
                $path = public_path('body_types/coupe.webp');
            } elseif (str_contains($name, 'hatchback') || str_contains($name, 'city') || str_contains($name, 'micro')) {
                $path = public_path('body_types/hatchback.webp');
            } elseif (str_contains($name, 'suv') || str_contains($name, 'crossover') || str_contains($name, 'off-road')) {
                $path = public_path('body_types/small_suv.webp');
            } elseif (str_contains($name, 'pickup') || str_contains($name, 'pick-up')) {
                $path = public_path('body_types/pickup_truck.webp');
            } elseif (str_contains($name, 'mpv') || str_contains($name, 'minivan')) {
                $path = public_path('body_types/mpv.webp');
            } elseif (str_contains($name, 'van') || str_contains($name, 'camper') || str_contains($name, 'motorhome') || str_contains($name, 'truck')) {
                $path = public_path('body_types/large_van.webp');
            } else {
                $path = public_path('body_types/sedan_reference.webp');
            }
        }

        if ($path && file_exists($path)) {
            $data = base64_encode(file_get_contents($path));
            return "data:image/webp;base64,{$data}";
        }

        return asset('body_types/sedan_reference.webp');
    }
}
