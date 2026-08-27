<?php

namespace App\Domain\Client\Queries;

use App\Models\Client;
use Illuminate\Database\Eloquent\Builder;

class ClientListQuery
{
    public function handle(array $params = [], string $sortField = 'id', string $sortAsc = 'asc'): Builder
    {
        $query = Client::query();
        if (isset($params['search']) && $params['search']) {
            $query->where(function($query) use ($params) {
                $query->where('id', 'like', '%' . $params['search'] . '%');
                $query->orWhere('name', 'like', '%' . $params['search'] . '%');
                $query->orWhere('phone', 'like', '%' . $params['search'] . '%');
                $query->orWhere('email', 'like', '%' . $params['search'] . '%');
                $query->orWhere('notes', 'like', '%' . $params['search'] . '%');
            });
        }

        $sortField = in_array($sortField, Client::sortable(), true) ? $sortField : 'id';
        $sortAsc = in_array(strtolower((string) $sortAsc), ['asc', 'desc'], true) ? $sortAsc : 'asc';
        return $query->orderBy($sortField, $sortAsc);
    }
}