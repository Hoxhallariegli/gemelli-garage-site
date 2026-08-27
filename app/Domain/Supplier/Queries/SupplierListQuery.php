<?php

namespace App\Domain\Supplier\Queries;

use App\Models\Supplier;
use Illuminate\Database\Eloquent\Builder;

class SupplierListQuery
{
    public function handle(array $params = [], string $sortField = 'id', string $sortAsc = 'asc'): Builder
    {
        $query = Supplier::query();
        if (isset($params['search']) && $params['search']) {
            $query->where(function($query) use ($params) {
                $query->where('id', 'like', '%' . $params['search'] . '%');
                $query->orWhere('name', 'like', '%' . $params['search'] . '%');
                $query->orWhere('contact_person', 'like', '%' . $params['search'] . '%');
                $query->orWhere('phone', 'like', '%' . $params['search'] . '%');
                $query->orWhere('email', 'like', '%' . $params['search'] . '%');
            });
        }
        $sortField = in_array($sortField, Supplier::sortable(), true) ? $sortField : 'id';
        $sortAsc = in_array(strtolower((string) $sortAsc), ['asc', 'desc'], true) ? $sortAsc : 'asc';
        return $query->orderBy($sortField, $sortAsc);
    }
}
