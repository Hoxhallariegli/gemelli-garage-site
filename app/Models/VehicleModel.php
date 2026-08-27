<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleModel extends Model
{
    use HasFactory;
    protected $fillable = ['brand_id', 'body_type_id', 'name', 'wrap_meters_needed', 'model_3d_path'];

    protected function casts(): array { return [
            'wrap_meters_needed' => 'decimal:2',
        ]; }
    public static function rules($id = null): array { return [
            'brand_id' => ['required', 'integer'],
            'body_type_id' => ['required', 'integer'],
            'name' => ['required', 'string', 'max:255'],
            'wrap_meters_needed' => ['required', 'numeric'],
        ]; }
    public static function sortable(): array { return ['id', 'brand_id', 'body_type_id', 'name', 'wrap_meters_needed', 'model_3d_path']; }

    public function brand(): \Illuminate\Database\Eloquent\Relations\BelongsTo { return $this->belongsTo(\App\Models\VehicleBrand::class, 'brand_id'); }

    public function bodyType(): \Illuminate\Database\Eloquent\Relations\BelongsTo { return $this->belongsTo(\App\Models\BodyType::class, 'body_type_id'); }

    public function getEffectiveModel3dPath()
    {
        return $this->model_3d_path;
    }

}
