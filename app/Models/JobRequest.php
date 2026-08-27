<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobRequest extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'email', 'phone', 'brand', 'model', 'body_type_id', 'service_id', 'material_id', 'estimated_price', 'message', 'status'];
    protected function casts(): array { return [
            'estimated_price' => 'decimal:2',
        ]; }
    public static function rules($id = null): array { return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'brand' => ['required', 'string', 'max:255'],
            'model' => ['required', 'string', 'max:255'],
            'body_type_id' => ['required', 'integer'],
            'service_id' => ['nullable', 'integer'],
            'material_id' => ['nullable', 'integer'],
            'estimated_price' => ['required', 'numeric'],
            'message' => ['nullable', 'string'],
            'status' => ['required', 'string', 'max:255'],
        ]; }
    public static function sortable(): array { return ['id', 'name', 'email', 'phone', 'brand', 'model', 'body_type_id', 'service_id', 'material_id', 'estimated_price', 'message', 'status']; }

    public function bodyType(): \Illuminate\Database\Eloquent\Relations\BelongsTo { return $this->belongsTo(\App\Models\BodyType::class, 'body_type_id'); }

    public function service(): \Illuminate\Database\Eloquent\Relations\BelongsTo { return $this->belongsTo(\App\Models\Service::class, 'service_id'); }

    public function material(): \Illuminate\Database\Eloquent\Relations\BelongsTo { return $this->belongsTo(\App\Models\Material::class, 'material_id'); }

}
