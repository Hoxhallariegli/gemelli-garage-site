<?php

namespace App\Domain\Purchase\Queries;

use App\Models\Purchase;
use Illuminate\Database\Eloquent\Builder;

class PurchaseListQuery
{
    public function handle(array $params = [], string $sortField = 'id', string $sortAsc = 'asc'): Builder
    {
        $query = Purchase::query()
            ->with(['supplier', 'items.itemable'])
            ->withCount('items')
            ->withSum('items as total_qty', 'quantity');
        if (isset($params['search']) && $params['search']) {
            $query->where(function($query) use ($params) {
                $query->where('id', 'like', '%' . $params['search'] . '%');
                $query->orWhere('reference_number', 'like', '%' . $params['search'] . '%');
                $query->orWhereHas('supplier', function($q) use ($params) {
                    $q->where('name', 'like', '%' . $params['search'] . '%');
                });
            });
        }
        if (isset($params['supplier_id']) && $params['supplier_id']) $query->where('supplier_id', $params['supplier_id']);
        if (isset($params['status']) && $params['status']) $query->where('status', $params['status']);

        $sortField = in_array($sortField, Purchase::sortable(), true) ? $sortField : 'id';
        $sortAsc = in_array(strtolower((string) $sortAsc), ['asc', 'desc'], true) ? $sortAsc : 'asc';
        return $query->orderBy($sortField, $sortAsc);
    }
}
