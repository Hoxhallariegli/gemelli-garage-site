<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Users;

use App\Actions\GetInitialsAction;
use App\Mail\Users\SendInviteMail;
use App\Models\Garage;
use App\Models\Role;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Livewire\WithPagination;

class Invite extends Component
{
    use WithPagination;

    public string $name = '';

    public string $email = '';

    /**
     * Structure: [garage_id => [role_id1, role_id2]]
     */
    public array $garageRoles = [];

    protected array $rules = [
        'name' => [
            'required',
            'string',
        ],
        'email' => [
            'required',
            'string',
            'email',
            'unique:users,email',
        ],
    ];

    protected array $messages = [
        'name.required' => 'Name is required',
        'email.required' => 'Email is required',
    ];

    public function mount(): void
    {
        $currentUser = auth()->user();
        if ($currentUser && $currentUser->is_global_admin) {
            $allGarages = Garage::all();
        } else {
            $allGarages = Garage::where('id', $currentUser?->tenant_id)->get();
        }

        foreach ($allGarages as $garage) {
            $this->garageRoles[(int)$garage->id] = [];
        }
    }

    /**
     * @throws ValidationException
     */
    public function updated(string $propertyName): void
    {
        $this->validateOnly($propertyName);
    }

    public function render(): View
    {
        $currentUser = auth()->user();
        if ($currentUser && $currentUser->is_global_admin) {
            $allGarages = Garage::all();
        } else {
            $allGarages = Garage::where('id', $currentUser?->tenant_id)->get();
        }

        $availableRoles = Role::where('name', '!=', 'admin')->orderby('name')->get();

        return view('livewire.admin.users.invite', compact('allGarages', 'availableRoles'));
    }

    public function store(GetInitialsAction $getInitialsAction): void
    {
        $this->validate();

        $selectedGarageIds = collect($this->garageRoles)
            ->filter(fn($roles) => !empty($roles))
            ->keys()
            ->map(fn($id) => (int)$id)
            ->toArray();

        $primaryGarageId = !empty($selectedGarageIds)
            ? $selectedGarageIds[0]
            : (auth()->user()?->tenant_id ?: 1);

        $user = User::create([
            'tenant_id' => $primaryGarageId,
            'name' => $this->name,
            'slug' => Str::slug($this->name),
            'email' => $this->email,
            'is_active' => 0,
            'is_office_login_only' => 0,
            'invite_token' => Str::random(32),
            'invited_by' => auth()->id(),
            'invited_at' => now(),
        ]);

        if (!empty($selectedGarageIds)) {
            $user->garages()->syncWithoutDetaching($selectedGarageIds);
        } else {
            $user->garages()->syncWithoutDetaching([$primaryGarageId]);
        }

        // generate avatar image
        $initialsName = $getInitialsAction($user->name);
        $id = $user->id.'.png';
        $path = 'users/';
        $imagePath = create_avatar($initialsName, $id, $path);

        $user->image = $imagePath;
        $user->save();

        // Assign per-garage roles
        foreach ($this->garageRoles as $garageId => $roleIds) {
            if (!empty($roleIds)) {
                foreach ($roleIds as $roleId) {
                    DB::table('model_has_roles')->insertOrIgnore([
                        'role_id' => $roleId,
                        'model_id' => $user->id,
                        'model_type' => 'App\Models\User',
                        'tenant_id' => (int)$garageId
                    ]);
                }
            }
        }

        if (function_exists('app')) {
            app(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
        }

        Mail::send(new SendInviteMail($user));

        add_user_log([
            'title' => 'invited '.$user->name,
            'reference_id' => $user->id,
            'section' => 'Auth',
            'type' => 'Join',
        ]);

        flash('User invited')->success();

        $this->reset(['name', 'email']);
        $this->mount();
        $this->dispatch('refreshUsers');
        $this->dispatch('close-modal');
    }

    public function cancel(): void
    {
        $this->reset(['name', 'email']);
        $this->mount();
        $this->dispatch('close-modal');
    }
}
