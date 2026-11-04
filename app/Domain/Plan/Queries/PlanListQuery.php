<?php

namespace App\Domain\Plan\Queries;

use App\Models\Plan;
use Illuminate\Database\Eloquent\Builder;

class PlanListQuery
{
    public function handle(array $params = [], string $sortField = 'id', string $sortAsc = 'asc'): Builder
    {
        $query = Plan::query();
        if (isset($params['search']) && $params['search']) {
            $query->where(function($q) use ($params) {
                $q->where('id', 'like', '%' . $params['search'] . '%');
                $q->orWhere('name', 'like', '%' . $params['search'] . '%');
            });
        }

        return $query->orderBy($sortField, $sortAsc);
    }
}
