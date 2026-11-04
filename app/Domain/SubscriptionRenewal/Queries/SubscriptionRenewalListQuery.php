<?php

namespace App\Domain\SubscriptionRenewal\Queries;

use App\Models\SubscriptionRenewal;
use Illuminate\Database\Eloquent\Builder;

class SubscriptionRenewalListQuery
{
    public function handle(array $params = [], string $sortField = 'id', string $sortAsc = 'asc'): Builder
    {
        $query = SubscriptionRenewal::query()->with('plan');
        if (isset($params['search']) && $params['search']) {
            $query->where('id', 'like', '%' . $params['search'] . '%');
        }

        return $query->orderBy($sortField, $sortAsc);
    }
}
