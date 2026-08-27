<?php

namespace App\Domain\Job\Queries;

use App\Models\Job;
use Illuminate\Database\Eloquent\Builder;

class JobListQuery
{
    public function handle(array $params = [], string $sortField = 'id', string $sortAsc = 'desc'): Builder
    {
        $query = Job::query()->with(['car.brand', 'car.model.bodyType', 'car.client', 'services.service', 'materials.material', 'parts.part', 'payments']);

        if (isset($params['search']) && $params['search']) {
            $query->where(function($query) use ($params) {
                $query->where('id', 'like', '%' . $params['search'] . '%');
                $query->orWhere('notes', 'like', '%' . $params['search'] . '%');
                $query->orWhereHas('car', function($q) use ($params) {
                    $q->where('license_plate', 'like', '%' . $params['search'] . '%');
                });
            });
        }

        if (isset($params['car_id']) && $params['car_id']) $query->where('car_id', $params['car_id']);
        if (isset($params['service_id']) && $params['service_id']) $query->where('service_id', $params['service_id']);

        $sortField = in_array($sortField, Job::sortable(), true) ? $sortField : 'id';
        $sortAsc = in_array(strtolower((string) $sortAsc), ['asc', 'desc'], true) ? $sortAsc : 'desc';

        return $query->orderBy($sortField, $sortAsc);
    }
}
