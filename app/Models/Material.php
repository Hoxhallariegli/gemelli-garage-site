<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory, \App\Models\Traits\BelongsToGarage;

    protected $fillable = ['tenant_id', 'name', 'material_brand_id', 'purchase_price', 'sell_price', 'stock_meters', 'image'];

    protected function casts(): array {
        return [
            'purchase_price' => 'decimal:2',
            'sell_price' => 'decimal:2',
            'stock_meters' => 'decimal:2',
        ];
    }

    public static function rules($id = null): array {
        return [
            'name' => ['required', 'string', 'max:255'],
            'material_brand_id' => ['nullable'],
            'purchase_price' => ['required', 'numeric'],
            'sell_price' => ['required', 'numeric'],
            'stock_meters' => ['required', 'numeric'],
            'image' => ['nullable', 'string'],
        ];
    }

    public static function sortable(): array {
        return ['id', 'name', 'material_brand_id', 'purchase_price', 'sell_price', 'stock_meters'];
    }

    public function setMaterialBrandIdAttribute($value)
    {
        $this->attributes['material_brand_id'] = ($value === '' || $value === null) ? null : (int)$value;
    }

    public function setPurchasePriceAttribute($value)
    {
        $this->attributes['purchase_price'] = ($value === '' || $value === null) ? 0 : $value;
    }

    public function setSellPriceAttribute($value)
    {
        $this->attributes['sell_price'] = ($value === '' || $value === null) ? 0 : $value;
    }

    public function setStockMetersAttribute($value)
    {
        $this->attributes['stock_meters'] = ($value === '' || $value === null) ? 0 : $value;
    }

    public function materialBrand()
    {
        return $this->belongsTo(MaterialBrand::class);
    }

    public function purchaseItems()
    {
        return $this->morphMany(PurchaseItem::class, 'itemable');
    }

    public function jobMaterials()
    {
        return $this->hasMany(JobMaterial::class);
    }
}
