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
                $model->tenant_id = Auth::user()->tenant_id;
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
            if (app()->runningInConsole() || !Auth::check()) {
                return;
            }

            $user = Auth::user();
            $model = $builder->getModel();

            if ($model instanceof \Spatie\Permission\Models\Role ||
                $model instanceof \Spatie\Permission\Models\Permission) {
                return;
            }

            $tableName = $model->getTable();

            $isGlobalAdmin = \Illuminate\Support\Facades\DB::table('model_has_roles')
                ->where('model_id', $user->id)
                ->where('tenant_id', 0)
                ->exists();

            if ($isGlobalAdmin) {
                return;
            }

            if (!$user->tenant_id && !($model instanceof Garage)) {
                $builder->whereRaw('1 = 0');
                return;
            }

            if ($model instanceof Garage) {
                $builder->where(function ($q) use ($user, $tableName) {
                    $q->where($tableName . '.owner_id', $user->id)
                      ->orWhereHas('users', fn($qu) => $qu->where('users.id', $user->id));
                });
            } elseif ($model instanceof \App\Models\User) {
                if ($user->id !== null) {
                    $builder->whereIn($tableName . '.id', function($q) use ($user) {
                        $q->select('user_id')
                          ->from('garage_user')
                          ->where('garage_id', $user->tenant_id);
                    })->orWhere($tableName . '.id', $user->id);
                }
            } else {
                if (\Illuminate\Support\Facades\Schema::hasColumn($tableName, 'tenant_id')) {
                    $builder->where($tableName . '.tenant_id', $user->tenant_id);
                }
            }
        });
    }

    public function garage()
    {
        return $this->belongsTo(Garage::class, 'tenant_id');
    }
}
