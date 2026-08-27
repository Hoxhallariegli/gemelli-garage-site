<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Purchase extends Model
{
    use HasFactory;
    protected $fillable = ['supplier_id', 'purchase_date', 'reference_number', 'status', 'total_amount'];
    protected function casts(): array { return [
            'purchase_date' => 'date',
            'total_amount' => 'decimal:2',
        ]; }
    public static function rules($id = null): array { return [
            'supplier_id' => ['required', 'integer'],
            'purchase_date' => ['required', 'date'],
            'reference_number' => ['nullable', 'string', 'max:255'],
            'status' => ['required', \Illuminate\Validation\Rule::in(['pending', 'received'])],
            'total_amount' => ['required', 'numeric'],
        ]; }
    public static function sortable(): array { return ['id', 'supplier_id', 'purchase_date', 'reference_number', 'status', 'total_amount']; }

    public function supplier(): \Illuminate\Database\Eloquent\Relations\BelongsTo { return $this->belongsTo(\App\Models\Supplier::class, 'supplier_id'); }

    public function items()
    {
        return $this->hasMany(PurchaseItem::class);
    }

    public function receive()
    {
        if ($this->status === 'received') return;

        DB::transaction(function () {
            // Load items with their related products
            $items = $this->items()->with('itemable')->get();

            foreach ($items as $item) {
                $product = $item->itemable;
                if (!$product) continue;

                $newQty = (float) $item->quantity;
                $newPrice = (float) $item->unit_cost;

                if ($product instanceof Material) {
                    $currentStock = (float) $product->stock_meters;
                    $oldPrice = (float) $product->purchase_price;

                    // Update Average Cost
                    $totalStock = $currentStock + $newQty;
                    if ($totalStock > 0) {
                        $avgPrice = (($currentStock * $oldPrice) + ($newQty * $newPrice)) / $totalStock;
                        $product->purchase_price = $avgPrice;
                    }

                    // Increment Stock
                    $product->stock_meters = $totalStock;
                    $product->save();

                } elseif ($product instanceof Part) {
                    $currentStock = (float) $product->stock_quantity;
                    $oldPrice = (float) $product->purchase_price;

                    // Update Average Cost
                    $totalStock = $currentStock + $newQty;
                    if ($totalStock > 0) {
                        $avgPrice = (($currentStock * $oldPrice) + ($newQty * $newPrice)) / $totalStock;
                        $product->purchase_price = $avgPrice;
                    }

                    // Increment Stock
                    $product->stock_quantity = (int)$totalStock;
                    $product->save();
                }
            }

            $this->update(['status' => 'received']);
        });
    }
}
