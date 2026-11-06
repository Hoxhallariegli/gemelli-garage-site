<?php

namespace App\Models\Traits;

use App\Models\Garage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

trait BelongsToGarage
{
    public static function bootBelongsToGarage(): void
    {
        static::creating(function ($model) {
            if (!($model instanceof Garage) && !$model->tenant_id && Auth::check()) {
                $userTenantId = Auth::user()?->getAttribute('tenant_id') ?: 1;
                $model->tenant_id = $userTenantId;
            }
        });

        static::saving(function ($model) {
            foreach ($model->getAttributes() as $key => $value) {
                if ($value === '' || $value === null) {
                    if ($model->hasCast($key, ['int', 'integer', 'decimal', 'float', 'double'])) {
                        $model->setAttribute($key, null);
                    } elseif ($model->hasCast($key, ['bool', 'boolean'])) {
                        $model->setAttribute($key, 0);
                    }
                }
            }
        });

        // Global Scope: Automatic Multi-Tenancy Filtering
        static::addGlobalScope('garage_access', function (Builder $builder) {
            if (!Auth::check()) {
                return;
            }

            $user = Auth::user();
            $model = $builder->getModel();

            if ($model instanceof \Spatie\Permission\Models\Role ||
                $model instanceof \Spatie\Permission\Models\Permission) {
                return;
            }

            $tableName = $model->getTable();

            $isGlobalAdmin = false;

            try {
                if (\Illuminate\Support\Facades\Schema::hasColumn('model_has_roles', 'tenant_id')) {
                    $isGlobalAdmin = \Illuminate\Support\Facades\DB::table('model_has_roles')
                        ->where('model_id', $user->id)
                        ->where('tenant_id', 0)
                        ->exists();
                }
            } catch (\Throwable $e) {}

            if (!$isGlobalAdmin && $user->is_global_admin) {
                $isGlobalAdmin = true;
            }

            if ($isGlobalAdmin) {
                return;
            }

            $activeTenantId = $user->getAttribute('tenant_id') ?: 1;

            if ($model instanceof Garage) {
                $builder->where(function ($q) use ($user, $tableName, $activeTenantId) {
                    $q->where($tableName . '.id', $activeTenantId)
                      ->orWhere($tableName . '.owner_id', $user->id)
                      ->orWhereHas('users', fn($qu) => $qu->where('users.id', $user->id));
                });
            } elseif ($model instanceof \App\Models\User) {
                if ($user->id !== null) {
                    $builder->whereIn($tableName . '.id', function($q) use ($activeTenantId) {
                        $q->select('user_id')
                          ->from('garage_user')
                          ->where('garage_id', $activeTenantId);
                    })->orWhere($tableName . '.id', $user->id)
                      ->orWhere($tableName . '.tenant_id', $activeTenantId);
                }
             } else {
                if (\Illuminate\Support\Facades\Schema::hasColumn($tableName, 'tenant_id')) {
                    $builder->where($tableName . '.tenant_id', $activeTenantId);
                }
            }
        });
    }

    public function garage()
    {
        return $this->belongsTo(Garage::class, 'tenant_id');
    }
}
