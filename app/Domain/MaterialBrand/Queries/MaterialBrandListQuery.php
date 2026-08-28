<?php

namespace App\Domain\MaterialBrand\Queries;

use App\Models\MaterialBrand;
use Illuminate\Database\Eloquent\Builder;

class MaterialBrandListQuery
{
    public function handle(array $params = [], string $sortField = 'id', string $sortAsc = 'asc'): Builder
    {
        $query = MaterialBrand::query();
        if (isset($params['search']) && $params['search']) {
            $query->where(function($query) use ($params) {
                $query->where('id', 'like', '%' . $params['search'] . '%');
                $query->orWhere('name', 'like', '%' . $params['search'] . '%');
                $query->orWhere('image', 'like', '%' . $params['search'] . '%');
            });
        }

        $sortField = in_array($sortField, MaterialBrand::sortable(), true) ? $sortField : 'id';
        $sortAsc = in_array(strtolower((string) $sortAsc), ['asc', 'desc'], true) ? $sortAsc : 'asc';
        return $query->orderBy($sortField, $sortAsc);
    }
}