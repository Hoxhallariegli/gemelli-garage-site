<?php

namespace App\Domain\Car\Queries;

use App\Models\Car;
use Illuminate\Database\Eloquent\Builder;

class CarListQuery
{
    public function handle(array $params = [], string $sortField = 'id', string $sortAsc = 'asc'): Builder
    {
        $query = Car::query()->with(['client', 'brand', 'model.bodyType']);
        if (isset($params['search']) && $params['search']) {
            $query->where(function($query) use ($params) {
                $query->where('id', 'like', '%' . $params['search'] . '%');
                $query->orWhere('year', 'like', '%' . $params['search'] . '%');
                $query->orWhere('license_plate', 'like', '%' . $params['search'] . '%');
                $query->orWhere('color', 'like', '%' . $params['search'] . '%');
            });
        }
        if (isset($params['client_id']) && $params['client_id']) $query->where('client_id', $params['client_id']);
        if (isset($params['brand_id']) && $params['brand_id']) $query->where('brand_id', $params['brand_id']);
        if (isset($params['model_id']) && $params['model_id']) $query->where('model_id', $params['model_id']);
        $sortField = in_array($sortField, Car::sortable(), true) ? $sortField : 'id';
        $sortAsc = in_array(strtolower((string) $sortAsc), ['asc', 'desc'], true) ? $sortAsc : 'asc';
        return $query->orderBy($sortField, $sortAsc);
    }
}
