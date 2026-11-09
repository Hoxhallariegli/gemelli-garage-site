<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        Model::unguard();

        $modules = [
            'Garages' => 'garages',
            'Plans' => 'plans',
            'Subscriptions' => 'subscriptions',
            'SubscriptionRenewals' => 'subscription_renewals',
            'Jobs' => 'jobs',
            'JobRequests' => 'job_requests',
            'Clients' => 'clients',
            'Cars' => 'cars',
            'Payments' => 'payments',
            'Expenses' => 'expenses',
            'Reports' => 'reports',
            'Services' => 'services',
            'Materials' => 'materials',
            'MaterialBrands' => 'material_brands',
            'Parts' => 'parts',
            'Suppliers' => 'suppliers',
            'Purchases' => 'purchases',
            'VehicleBrands' => 'vehicle_brands',
            'VehicleModels' => 'vehicle_models',
            'BodyTypes' => 'body_types',
            'Users' => 'users',
            'Roles' => 'roles',
            'AuditTrails' => 'audit_trails',
            'SystemSettings' => 'system_settings',
            'AiAssistant' => 'ai_assistant',
            'Languages' => 'languages',
            'SmsGateway' => 'sms_gateway',
        ];

        foreach ($modules as $name => $pluralSnake) {
            foreach (['view', 'add', 'edit', 'delete'] as $act) {
                Permission::firstOrCreate(
                    ['name' => "{$act}_{$pluralSnake}"],
                    [
                        'label' => ucfirst($act) . ' ' . $name,
                        'module' => Str::plural($name)
                    ]
                );
            }
        }

        // Additional custom app permissions
        Permission::firstOrCreate(['name' => 'view_dashboard', 'label' => 'View Dashboard', 'module' => 'App']);
        Permission::firstOrCreate(['name' => 'view_notifications', 'label' => 'View Notifications', 'module' => 'App']);
        Permission::firstOrCreate(['name' => 'view_workdesk', 'label' => 'View WorkDesk', 'module' => 'Jobs']);
        Permission::firstOrCreate(['name' => 'view_users_profiles', 'label' => 'View Users Profiles', 'module' => 'Users']);
        Permission::firstOrCreate(['name' => 'view_users_activity', 'label' => 'View Users Activity', 'module' => 'Users']);
        Permission::firstOrCreate(['name' => 'edit_own_account', 'label' => 'Edit Own Account', 'module' => 'Users']);

        // 2. Create Global Roles with tenant_id = 0 explicitly
        $adminRole = Role::firstOrCreate(
            ['name' => 'admin'],
            ['guard_name' => 'web', 'label' => 'Administrator', 'tenant_id' => 0]
        );

        $managerRole = Role::firstOrCreate(
            ['name' => 'manager'],
            ['guard_name' => 'web', 'label' => 'Manager', 'tenant_id' => 0]
        );

        $staffRole = Role::firstOrCreate(
            ['name' => 'staff'],
            ['guard_name' => 'web', 'label' => 'Staff / Mechanist', 'tenant_id' => 0]
        );

        // Assign ALL permissions to Global Admin role
        $allPermissions = Permission::all();
        $adminRole->syncPermissions($allPermissions);

        // Assign standard operational permissions to Manager (excluding sensitive Admin settings)
        $managerPermissions = Permission::whereNotIn('module', ['Roles', 'SystemSettings', 'AuditTrails'])->get();
        $managerRole->syncPermissions($managerPermissions);

        // Assign view & add permissions to Staff
        $staffPermissions = Permission::whereIn('name', [
            'view_dashboard', 'view_workdesk', 'view_jobs', 'add_jobs', 'view_cars', 'add_cars', 'view_clients', 'add_clients', 'view_services', 'view_materials', 'view_parts'
        ])->get();
        $staffRole->syncPermissions($staffPermissions);

        if (function_exists('app')) {
            app(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
        }
    }
}
