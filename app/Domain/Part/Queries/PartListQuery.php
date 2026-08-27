<?php

namespace App\Domain\Part\Queries;

use App\Models\Part;
use Illuminate\Database\Eloquent\Builder;

class PartListQuery
{
    public function handle(array $params = [], string $sortField = 'id', string $sortAsc = 'asc'): Builder
    {
        $query = Part::query();
        if (isset($params['search']) && $params['search']) {
            $query->where(function($query) use ($params) {
                $query->where('id', 'like', '%' . $params['search'] . '%');
                $query->orWhere('name', 'like', '%' . $params['search'] . '%');
            });
        }

        $sortField = in_array($sortField, Part::sortable(), true) ? $sortField : 'id';
        $sortAsc = in_array(strtolower((string) $sortAsc), ['asc', 'desc'], true) ? $sortAsc : 'asc';
        return $query->orderBy($sortField, $sortAsc);
    }
}