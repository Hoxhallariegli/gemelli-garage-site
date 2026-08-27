<?php

namespace App\Domain\Purchase\Actions;

use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Material;
use App\Models\Part;
use App\Domain\Purchase\DTOs\PurchaseDTO;
use App\Models\AuditTrail;
use Illuminate\Support\Facades\DB;

class CreatePurchaseAction
{
    public function execute(PurchaseDTO $dto): Purchase
    {
        return DB::transaction(function () use ($dto) {
            $item = Purchase::create($dto->toArray());

            foreach ($dto->items as $itemData) {
                PurchaseItem::create([
                    'purchase_id' => $item->id,
                    'itemable_id' => $itemData['id'],
                    'itemable_type' => $itemData['type'] === 'Material' ? Material::class : Part::class,
                    'quantity' => $itemData['quantity'],
                    'unit_cost' => $itemData['unit_cost'],
                ]);
            }

            AuditTrail::log($item, 'create', 'Purchases');
            return $item;
        });
    }
}
