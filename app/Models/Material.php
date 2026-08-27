<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'brand', 'hex_code', 'roughness', 'metalness', 'purchase_price', 'sell_price', 'stock_meters', 'image'];
    protected function casts(): array { return [
            'purchase_price' => 'decimal:2',
            'sell_price' => 'decimal:2',
            'stock_meters' => 'decimal:2',
            'roughness' => 'decimal:2',
            'metalness' => 'decimal:2',
        ]; }
    public static function rules($id = null): array { return [
            'name' => ['required', 'string', 'max:255'],
            'brand' => ['nullable', 'string', 'max:255'],
            'hex_code' => ['nullable', 'string', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
            'roughness' => ['nullable', 'numeric', 'min:0', 'max:1'],
            'metalness' => ['nullable', 'numeric', 'min:0', 'max:1'],
            'purchase_price' => ['required', 'numeric'],
            'sell_price' => ['required', 'numeric'],
            'stock_meters' => ['required', 'numeric'],
            'image' => ['nullable', 'string'],
        ]; }
    public static function sortable(): array { return ['id', 'name', 'brand', 'purchase_price', 'sell_price', 'stock_meters']; }

    public function purchaseItems()
    {
        return $this->morphMany(PurchaseItem::class, 'itemable');
    }

    public function jobMaterials()
    {
        return $this->hasMany(JobMaterial::class);
    }
}
