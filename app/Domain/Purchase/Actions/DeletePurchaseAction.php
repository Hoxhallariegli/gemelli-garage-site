<?php

namespace App\Domain\Purchase\Actions;

use App\Models\Purchase;
use App\Models\AuditTrail;
use App\Models\Material;
use App\Models\Part;
use Illuminate\Support\Facades\DB;

class DeletePurchaseAction
{
    public function execute(Purchase $model): bool
    {
        return DB::transaction(function () use ($model) {
            // If it's already received, we MUST reverse the stock
            if ($model->status === 'received') {
                // Fetch items explicitly to ensure they are available
                $items = $model->items()->get();

                foreach ($items as $item) {
                    $qty = (float)$item->quantity;

                    if ($item->itemable_type === Material::class) {
                        Material::where('id', $item->itemable_id)->decrement('stock_meters', $qty);
                    } elseif ($item->itemable_type === Part::class) {
                        Part::where('id', $item->itemable_id)->decrement('stock_quantity', $qty);
                    }
                }
            }

            AuditTrail::log($model, 'delete', 'Purchases');

            // Delete the purchase (items will be deleted via cascade in DB)
            return $model->delete();
        });
    }
}
