<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BodyType extends Model
{
    use HasFactory;

    protected $fillable = ['tenant_id', 'name', 'wrap_meters', 'image', 'min_price', 'max_price'];

    protected function casts(): array {
        return [
            'wrap_meters' => 'decimal:2',
            'min_price' => 'decimal:2',
            'max_price' => 'decimal:2',
        ];
    }

    public static function rules($id = null): array {
        return [
            'name' => ['required', 'string', 'max:255'],
            'wrap_meters' => ['required', 'numeric'],
            'image' => ['nullable', 'string', 'max:255'],
            'min_price' => ['nullable', 'numeric'],
            'max_price' => ['nullable', 'numeric'],
        ];
    }

    public static function sortable(): array {
        return ['id', 'name', 'wrap_meters', 'image'];
    }

    public function getMinWrapPriceAttribute(): float
    {
        if (isset($this->attributes['min_price']) && (float)$this->attributes['min_price'] > 0) {
            return (float) $this->attributes['min_price'];
        }

        $name = strtolower($this->name);

        if (str_contains($name, 'micro') || str_contains($name, 'city')) return 1000.0;
        if (str_contains($name, 'hatchback') || str_contains($name, 'convertible')) return 1200.0;
        if (str_contains($name, 'coupe') || str_contains($name, 'sports')) return 1400.0;
        if (str_contains($name, 'sedan') || str_contains($name, 'wagon')) return 1500.0;
        if (str_contains($name, 'suv') || str_contains($name, 'crossover') || str_contains($name, 'pickup')) return 1800.0;
        if (str_contains($name, 'mpv') || str_contains($name, 'small van')) return 2000.0;
        if (str_contains($name, 'large van') || str_contains($name, 'truck')) return 2400.0;

        return 1400.0;
    }

    public function getMaxWrapPriceAttribute(): float
    {
        if (isset($this->attributes['max_price']) && (float)$this->attributes['max_price'] > 0) {
            return (float) $this->attributes['max_price'];
        }

        $name = strtolower($this->name);

        if (str_contains($name, 'micro') || str_contains($name, 'city')) return 1300.0;
        if (str_contains($name, 'hatchback') || str_contains($name, 'convertible')) return 1500.0;
        if (str_contains($name, 'coupe') || str_contains($name, 'sports')) return 1800.0;
        if (str_contains($name, 'sedan') || str_contains($name, 'wagon')) return 1900.0;
        if (str_contains($name, 'suv') || str_contains($name, 'crossover') || str_contains($name, 'pickup')) return 2300.0;
        if (str_contains($name, 'mpv') || str_contains($name, 'small van')) return 2500.0;
        if (str_contains($name, 'large van') || str_contains($name, 'truck')) return 3000.0;

        return 1800.0;
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
