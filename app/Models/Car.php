<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;
    protected $fillable = ['client_id', 'brand_id', 'model_id', 'year', 'license_plate', 'color'];
    protected function casts(): array { return [
        ]; }
    public static function rules($id = null): array { return [
            'client_id' => ['required', 'integer'],
            'brand_id' => ['required', 'integer'],
            'model_id' => ['required', 'integer'],
            'year' => ['nullable', 'string', 'max:255'],
            'license_plate' => ['nullable', 'string', 'max:255'],
            'color' => ['nullable', 'string', 'max:255'],
        ]; }
    public static function sortable(): array { return ['id', 'client_id', 'brand_id', 'model_id', 'year', 'license_plate', 'color']; }

    public function client(): \Illuminate\Database\Eloquent\Relations\BelongsTo { return $this->belongsTo(\App\Models\Client::class, 'client_id'); }

    public function brand(): \Illuminate\Database\Eloquent\Relations\BelongsTo { return $this->belongsTo(\App\Models\VehicleBrand::class, 'brand_id'); }

    public function model(): \Illuminate\Database\Eloquent\Relations\BelongsTo { return $this->belongsTo(\App\Models\VehicleModel::class, 'model_id'); }

    public function getBodyTypeImageAttribute()
    {
        return $this->model?->bodyType?->image;
    }

}
