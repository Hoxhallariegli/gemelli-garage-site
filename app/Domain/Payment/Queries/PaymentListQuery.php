<?php

namespace App\Domain\Payment\Queries;

use App\Models\Payment;
use Illuminate\Database\Eloquent\Builder;

class PaymentListQuery
{
    public function handle(array $params = [], string $sortField = 'id', string $sortAsc = 'asc'): Builder
    {
        $query = Payment::query()->with(['job.car.client', 'job.car.brand', 'job.car.model']);
        if (isset($params['search']) && $params['search']) {
            $query->where(function($query) use ($params) {
                $query->where('id', 'like', '%' . $params['search'] . '%');

            });
        }
        if (isset($params['job_id']) && $params['job_id']) $query->where('job_id', $params['job_id']);
        $sortField = in_array($sortField, Payment::sortable(), true) ? $sortField : 'id';
        $sortAsc = in_array(strtolower((string) $sortAsc), ['asc', 'desc'], true) ? $sortAsc : 'asc';
        return $query->orderBy($sortField, $sortAsc);
    }
}
