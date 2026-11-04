<?php

namespace App\Domain\Subscription\Queries;

use App\Models\Subscription;
use Illuminate\Database\Eloquent\Builder;

class SubscriptionListQuery
{
    public function handle(array $params = [], string $sortField = 'id', string $sortAsc = 'asc'): Builder
    {
        $query = Subscription::query()->with('plan');
        if (isset($params['search']) && $params['search']) {
            $query->where('id', 'like', '%' . $params['search'] . '%');
        }

        return $query->orderBy($sortField, $sortAsc);
    }
}
