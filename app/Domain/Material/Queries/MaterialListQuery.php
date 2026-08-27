<?php

namespace App\Domain\Material\Queries;

use App\Models\Material;
use Illuminate\Database\Eloquent\Builder;

class MaterialListQuery
{
    public function handle(array $params = [], string $sortField = 'id', string $sortAsc = 'asc'): Builder
    {
        $query = Material::query();
        if (isset($params['search']) && $params['search']) {
            $query->where(function($query) use ($params) {
                $query->where('id', 'like', '%' . $params['search'] . '%');
                $query->orWhere('name', 'like', '%' . $params['search'] . '%');
                $query->orWhere('brand', 'like', '%' . $params['search'] . '%');
            });
        }

        $sortField = in_array($sortField, Material::sortable(), true) ? $sortField : 'id';
        $sortAsc = in_array(strtolower((string) $sortAsc), ['asc', 'desc'], true) ? $sortAsc : 'asc';
        return $query->orderBy($sortField, $sortAsc);
    }
}