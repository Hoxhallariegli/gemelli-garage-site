<?php

namespace App\Domain\CallLog\Queries;

use App\Models\CallLog;
use Illuminate\Database\Eloquent\Builder;

class CallLogListQuery
{
    public function handle(array $params = [], string $sortField = 'id', string $sortAsc = 'asc'): Builder
    {
        $query = CallLog::query();
        if (isset($params['search']) && $params['search']) {
            $query->where(function($query) use ($params) {
                $query->where('id', 'like', '%' . $params['search'] . '%');
                $query->orWhere('phone_number', 'like', '%' . $params['search'] . '%');
                $query->orWhere('caller_name', 'like', '%' . $params['search'] . '%');
            });
        }

        $sortField = in_array($sortField, CallLog::sortable(), true) ? $sortField : 'id';
        $sortAsc = in_array(strtolower((string) $sortAsc), ['asc', 'desc'], true) ? $sortAsc : 'asc';
        return $query->orderBy($sortField, $sortAsc);
    }
}