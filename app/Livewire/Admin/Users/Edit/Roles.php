<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Users\Edit;

use App\Models\Role;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class Roles extends Component
{
    public User $user;

    /**
     * @var Collection<int, Role>
     */
    public Collection $roles;

    /**
     * @var array<int>
     */
    public array $roleSelections = [];

    public function mount(): void
    {
        $this->roles = Role::orderby('name')->get();
        if (function_exists('setPermissionsTeamId')) {
            setPermissionsTeamId($this->user->tenant_id ?: 1);
        }
        $this->roleSelections = $this->user->roles->pluck('id')->toArray();
    }

    public function render(): View
    {
        return view('livewire.admin.users.edit.roles');
    }

    public function update(): bool
    {
        $role = Role::where('name', 'admin')
            ->firstOrFail();

        // if admin role is not in array
        if (! in_array(needle: $role->id, haystack: $this->roleSelections, strict: true)) {
            $adminRolesCount = User::role('admin')->count();

            // when there is only 1 admin role alert user and stop
            if ($adminRolesCount === 1 && $this->user->hasRole('admin')) {
                flash('there must be at least one admin user!')->error();

                return false;
            }

            // @codeCoverageIgnoreStart
            $this->syncRoles();

            return false;
            // @codeCoverageIgnoreEnd
        }

        $this->syncRoles();

        return true;
    }

    protected function syncRoles(): void
    {
        $adminRole = Role::where('name', 'admin')->first();
        $adminRoleId = $adminRole ? $adminRole->id : null;

        $tenantId = $this->user->tenant_id ?: 1;

        $rolesWithPivot = collect($this->roleSelections)->mapWithKeys(function (string $roleId) use ($tenantId, $adminRoleId) {
            $tId = ($adminRoleId && $roleId === $adminRoleId) ? 0 : $tenantId;
            return [
                $roleId => ['tenant_id' => $tId]
            ];
        })->toArray();

        $this->user->roles()->sync($rolesWithPivot);

        if ($tenantId) {
            $this->user->garages()->syncWithoutDetaching([$tenantId]);
        }

        if (function_exists('app')) {
            app(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
        }

        add_user_log([
            'title' => 'updated '.$this->user->name."'s roles",
            'reference_id' => $this->user->id,
            'link' => route('admin.users.edit', ['user' => $this->user->id]),
            'section' => 'Users',
            'type' => 'Update',
        ]);

        flash('Roles Updated!')->success();
    }
}
