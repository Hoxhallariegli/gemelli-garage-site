<?php

namespace App\Domain\Purchase\Actions;

use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Material;
use App\Models\Part;
use App\Domain\Purchase\DTOs\PurchaseDTO;
use App\Models\AuditTrail;
use Illuminate\Support\Facades\DB;

class UpdatePurchaseAction
{
    public function execute(Purchase $model, PurchaseDTO $dto): Purchase
    {
        return DB::transaction(function () use ($model, $dto) {
            $model->fill($dto->toArray());
            $model->save();

            // Only update items if it's still pending
            if ($model->status === 'pending') {
                $model->items()->delete();
                foreach ($dto->items as $itemData) {
                    PurchaseItem::create([
                        'purchase_id' => $model->id,
                        'itemable_id' => $itemData['id'],
                        'itemable_type' => $itemData['type'] === 'Material' ? Material::class : Part::class,
                        'quantity' => $itemData['quantity'],
                        'unit_cost' => $itemData['unit_cost'],
                    ]);
                }
            }

            AuditTrail::log($model, 'update', 'Purchases');
            return $model->fresh();
        });
    }
}
