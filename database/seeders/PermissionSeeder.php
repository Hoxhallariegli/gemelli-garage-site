<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        Model::unguard();

        $permissions = [
            // App
            ['name' => 'view_dashboard', 'label' => 'View Dashboard', 'module' => 'App'],
            ['name' => 'view_notifications', 'label' => 'View Notifications', 'module' => 'App'],

            // Users
            ['name' => 'view_users', 'label' => 'View Users', 'module' => 'Users'],
            ['name' => 'view_users_profiles', 'label' => 'View Users Profiles', 'module' => 'Users'],
            ['name' => 'view_users_activity', 'label' => 'View Users Activity', 'module' => 'Users'],
            ['name' => 'add_users', 'label' => 'Add Users', 'module' => 'Users'],
            ['name' => 'edit_users', 'label' => 'Edit Users', 'module' => 'Users'],
            ['name' => 'edit_own_account', 'label' => 'Edit Own Account', 'module' => 'Users'],
            ['name' => 'delete_users', 'label' => 'Delete Users', 'module' => 'Users'],

            // Roles
            ['name' => 'view_roles', 'label' => 'View Roles', 'module' => 'Roles'],
            ['name' => 'add_roles', 'label' => 'Add Roles', 'module' => 'Roles'],
            ['name' => 'edit_roles', 'label' => 'Edit Roles', 'module' => 'Roles'],
            ['name' => 'delete_roles', 'label' => 'Delete Roles', 'module' => 'Roles'],

            // Settings
            ['name' => 'view_audit_trails', 'label' => 'View Audit Trails', 'module' => 'Settings'],
            ['name' => 'view_system_settings', 'label' => 'View System Settings', 'module' => 'Settings'],
            ['name' => 'view_ai_assistant', 'label' => 'View AI Assistant', 'module' => 'Settings'],
            ['name' => 'view_languages', 'label' => 'View Languages', 'module' => 'Settings'],
            ['name' => 'edit_languages', 'label' => 'Edit Languages', 'module' => 'Settings'],

            // Jobs
            ['name' => 'view_jobs', 'label' => 'View Jobs', 'module' => 'Jobs'],
            ['name' => 'add_jobs', 'label' => 'Add Jobs', 'module' => 'Jobs'],
            ['name' => 'edit_jobs', 'label' => 'Edit Jobs', 'module' => 'Jobs'],
            ['name' => 'delete_jobs', 'label' => 'Delete Jobs', 'module' => 'Jobs'],
            ['name' => 'view_workdesk', 'label' => 'View WorkDesk', 'module' => 'Jobs'],

            // Clients
            ['name' => 'view_clients', 'label' => 'View Clients', 'module' => 'Clients'],
            ['name' => 'add_clients', 'label' => 'Add Clients', 'module' => 'Clients'],
            ['name' => 'edit_clients', 'label' => 'Edit Clients', 'module' => 'Clients'],
            ['name' => 'delete_clients', 'label' => 'Delete Clients', 'module' => 'Clients'],

            // Cars
            ['name' => 'view_cars', 'label' => 'View Cars', 'module' => 'Cars'],
            ['name' => 'add_cars', 'label' => 'Add Cars', 'module' => 'Cars'],
            ['name' => 'edit_cars', 'label' => 'Edit Cars', 'module' => 'Cars'],
            ['name' => 'delete_cars', 'label' => 'Delete Cars', 'module' => 'Cars'],

            // Payments
            ['name' => 'view_payments', 'label' => 'View Payments', 'module' => 'Payments'],
            ['name' => 'add_payments', 'label' => 'Add Payments', 'module' => 'Payments'],
            ['name' => 'edit_payments', 'label' => 'Edit Payments', 'module' => 'Payments'],
            ['name' => 'delete_payments', 'label' => 'Delete Payments', 'module' => 'Payments'],

            // Expenses (Shpenzime)
            ['name' => 'view_expenses', 'label' => 'View Expenses', 'module' => 'Expenses'],
            ['name' => 'add_expenses', 'label' => 'Add Expenses', 'module' => 'Expenses'],
            ['name' => 'edit_expenses', 'label' => 'Edit Expenses', 'module' => 'Expenses'],
            ['name' => 'delete_expenses', 'label' => 'Delete Expenses', 'module' => 'Expenses'],

            // Reports (Raporte)
            ['name' => 'view_reports', 'label' => 'View Reports', 'module' => 'Reports'],

            // Services
            ['name' => 'view_services', 'label' => 'View Services', 'module' => 'Services'],
            ['name' => 'add_services', 'label' => 'Add Services', 'module' => 'Services'],
            ['name' => 'edit_services', 'label' => 'Edit Services', 'module' => 'Services'],
            ['name' => 'delete_services', 'label' => 'Delete Services', 'module' => 'Services'],

            // Materials
            ['name' => 'view_materials', 'label' => 'View Materials', 'module' => 'Materials'],
            ['name' => 'add_materials', 'label' => 'Add Materials', 'module' => 'Materials'],
            ['name' => 'edit_materials', 'label' => 'Edit Materials', 'module' => 'Materials'],
            ['name' => 'delete_materials', 'label' => 'Delete Materials', 'module' => 'Materials'],

            // Parts
            ['name' => 'view_parts', 'label' => 'View Parts', 'module' => 'Parts'],
            ['name' => 'add_parts', 'label' => 'Add Parts', 'module' => 'Parts'],
            ['name' => 'edit_parts', 'label' => 'Edit Parts', 'module' => 'Parts'],
            ['name' => 'delete_parts', 'label' => 'Delete Parts', 'module' => 'Parts'],

            // Suppliers
            ['name' => 'view_suppliers', 'label' => 'View Suppliers', 'module' => 'Suppliers'],
            ['name' => 'add_suppliers', 'label' => 'Add Suppliers', 'module' => 'Suppliers'],
            ['name' => 'edit_suppliers', 'label' => 'Edit Suppliers', 'module' => 'Suppliers'],
            ['name' => 'delete_suppliers', 'label' => 'Delete Suppliers', 'module' => 'Suppliers'],

            // Purchases
            ['name' => 'view_purchases', 'label' => 'View Purchases', 'module' => 'Purchases'],
            ['name' => 'add_purchases', 'label' => 'Add Purchases', 'module' => 'Purchases'],
            ['name' => 'edit_purchases', 'label' => 'Edit Purchases', 'module' => 'Purchases'],
            ['name' => 'delete_purchases', 'label' => 'Delete Purchases', 'module' => 'Purchases'],

            // Vehicle Brands
            ['name' => 'view_vehicle_brands', 'label' => 'View Vehicle Brands', 'module' => 'Vehicle Brands'],
            ['name' => 'add_vehicle_brands', 'label' => 'Add Vehicle Brands', 'module' => 'Vehicle Brands'],
            ['name' => 'edit_vehicle_brands', 'label' => 'Edit Vehicle Brands', 'module' => 'Vehicle Brands'],
            ['name' => 'delete_vehicle_brands', 'label' => 'Delete Vehicle Brands', 'module' => 'Vehicle Brands'],

            // Vehicle Models
            ['name' => 'view_vehicle_models', 'label' => 'View Vehicle Models', 'module' => 'Vehicle Models'],
            ['name' => 'add_vehicle_models', 'label' => 'Add Vehicle Models', 'module' => 'Vehicle Models'],
            ['name' => 'edit_vehicle_models', 'label' => 'Edit Vehicle Models', 'module' => 'Vehicle Models'],
            ['name' => 'delete_vehicle_models', 'label' => 'Delete Vehicle Models', 'module' => 'Vehicle Models'],
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate($permission);
        }

        // Optional: Assign all permissions to 'Admin' role if it exists
        $adminRole = \App\Models\Role::where('name', 'Admin')->first();
        if ($adminRole) {
            $adminRole->givePermissionTo(Permission::all());
        }
    }
}
