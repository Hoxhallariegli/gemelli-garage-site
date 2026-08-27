<?php

namespace App\Domain\JobRequest\Queries;

use App\Models\JobRequest;
use Illuminate\Database\Eloquent\Builder;

class JobRequestListQuery
{
    public function handle(array $params = [], string $sortField = 'id', string $sortAsc = 'asc'): Builder
    {
        $query = JobRequest::query()->with(['bodyType', 'service', 'material']);
        if (isset($params['search']) && $params['search']) {
            $query->where(function($query) use ($params) {
                $query->where('id', 'like', '%' . $params['search'] . '%');
                $query->orWhere('name', 'like', '%' . $params['search'] . '%');
                $query->orWhere('email', 'like', '%' . $params['search'] . '%');
                $query->orWhere('phone', 'like', '%' . $params['search'] . '%');
                $query->orWhere('brand', 'like', '%' . $params['search'] . '%');
                $query->orWhere('model', 'like', '%' . $params['search'] . '%');
                $query->orWhere('message', 'like', '%' . $params['search'] . '%');
                $query->orWhere('status', 'like', '%' . $params['search'] . '%');
            });
        }
        if (isset($params['body_type_id']) && $params['body_type_id']) $query->where('body_type_id', $params['body_type_id']);
        if (isset($params['service_id']) && $params['service_id']) $query->where('service_id', $params['service_id']);
        if (isset($params['material_id']) && $params['material_id']) $query->where('material_id', $params['material_id']);
        $sortField = in_array($sortField, JobRequest::sortable(), true) ? $sortField : 'id';
        $sortAsc = in_array(strtolower((string) $sortAsc), ['asc', 'desc'], true) ? $sortAsc : 'asc';
        return $query->orderBy($sortField, $sortAsc);
    }
}