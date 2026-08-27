<?php

namespace App\Domain\Expense\Queries;

use App\Models\Expense;
use Illuminate\Database\Eloquent\Builder;

class ExpenseListQuery
{
    public function handle(array $params = [], string $sortField = 'id', string $sortAsc = 'asc'): Builder
    {
        $query = Expense::query()->with(['job.car.client']);

        if (isset($params['search']) && $params['search']) {
            $query->where(function($query) use ($params) {
                $query->where('title', 'like', '%' . $params['search'] . '%')
                      ->orWhere('id', 'like', '%' . $params['search'] . '%');
            });
        }

        if (isset($params['category']) && $params['category']) {
            $query->where('category', $params['category']);
        }

        if (isset($params['job_id']) && $params['job_id']) {
            $query->where('job_id', $params['job_id']);
        }

        if (isset($params['date_from']) && $params['date_from']) {
            $query->where('date', '>=', $params['date_from']);
        }

        if (isset($params['date_to']) && $params['date_to']) {
            $query->where('date', '<=', $params['date_to']);
        }

        $sortField = in_array($sortField, Expense::sortable(), true) ? $sortField : 'id';
        $sortAsc = in_array(strtolower((string) $sortAsc), ['asc', 'desc'], true) ? $sortAsc : 'asc';

        return $query->orderBy($sortField, $sortAsc);
    }
}
