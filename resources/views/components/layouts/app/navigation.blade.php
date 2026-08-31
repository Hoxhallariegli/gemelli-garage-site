@can('view_dashboard')
    <x-nav.link route="dashboard" icon="home">{{ __('admin.Dashboard') }}</x-nav.link>
@endcan

@can('view_workdesk')
    <x-nav.link route="admin.work-desk" icon="computer-desktop">{{ __('workdesk.Work Desk') }}</x-nav.link>
@endcan

<x-nav.divider>{{ __('admin.Modules') }}</x-nav.divider>

@can('view_jobs')
    <x-nav.link route="admin.jobs.index" icon="clipboard-document-list">{{ __('jobs.Jobs') }}</x-nav.link>
@endcan

@can('view_job_requests')
    <x-nav.link route="admin.job-requests.index" icon="chat-bubble-bottom-center-text">{{ __('job-requests.JobRequests') }}</x-nav.link>
@endcan

@can('view_clients')
    <x-nav.link route="admin.clients.index" icon="users">{{ __('clients.Clients') }}</x-nav.link>
@endcan

@can('view_cars')
    <x-nav.link route="admin.cars.index" icon="truck">{{ __('cars.Cars') }}</x-nav.link>
@endcan

@can('view_payments')
    <x-nav.link route="admin.payments.index" icon="banknotes">{{ __('payments.Payments') }}</x-nav.link>
@endcan

@can('view_expenses')
    <x-nav.link route="admin.expenses.index" icon="arrow-trending-down">{{ __('expenses.Expenses') }}</x-nav.link>
@endcan

@can('view_reports')
    <x-nav.link route="admin.reports.index" icon="chart-bar">{{ __('reports.Reports') }}</x-nav.link>
@endcan

@can('view_services')
    <x-nav.link route="admin.services.index" icon="wrench-screwdriver">{{ __('services.Services') }}</x-nav.link>
@endcan

@can('view_materials')
    <x-nav.link route="admin.materials.index" icon="square-3-stack-3d">{{ __('materials.Materials') }}</x-nav.link>
@endcan

@can('view_material_brands')
    <x-nav.link route="admin.material-brands.index" icon="archive-box">{{ __('material-brands.MaterialBrands') }}</x-nav.link>
@endcan

@can('view_parts')
    <x-nav.link route="admin.parts.index" icon="cog-6-tooth">{{ __('parts.Parts') }}</x-nav.link>
@endcan

@can('view_suppliers')
    <x-nav.link route="admin.suppliers.index" icon="building-office-2">{{ __('suppliers.Suppliers') }}</x-nav.link>
@endcan

@can('view_purchases')
    <x-nav.link route="admin.purchases.index" icon="shopping-cart">{{ __('purchases.Purchases') }}</x-nav.link>
@endcan

@can('view_sms_gateway')
    <x-nav.group icon="chat-bubble-bottom-center-text" label="SMS Gateway" route="admin.sms.">
        <x-nav.group-item route="admin.sms.index">Settings</x-nav.group-item>
        <x-nav.group-item route="admin.sms.logs">Logs</x-nav.group-item>
        <x-nav.group-item route="admin.sms.devices">Devices</x-nav.group-item>
        <x-nav.group-item route="admin.sms.templates">Templates</x-nav.group-item>
        <x-nav.group-item route="admin.calls.index">Call Logs</x-nav.group-item>
    </x-nav.group>
@endcan

@can('view_vehicle_brands')
    <x-nav.link route="admin.vehicle-brands.index" icon="circle-stack">{{ __('vehicle-brands.VehicleBrands') }}</x-nav.link>
@endcan
@can('view_vehicle_models')
    <x-nav.link route="admin.vehicle-models.index" icon="circle-stack">{{ __('vehicle-models.VehicleModels') }}</x-nav.link>
@endcan
@can('view_body_types')
    <x-nav.link route="admin.body-types.index" icon="rectangle-group">{{ __('body-types.BodyTypes') }}</x-nav.link>
@endcan

@if(can('view_system_settings') || can('view_roles') || can('view_audit_trails') || can('view_ai_assistant') || can('view_languages'))
    <x-nav.divider>{{ __('admin.Settings') }}</x-nav.divider>
@endif

@can('view_audit_trails')
    <x-nav.link route="admin.settings.audit-trails.index" icon="identification">{{ __('admin.Audit Trails') }}</x-nav.link>
@endcan

@can('view_roles')
    <x-nav.link route="admin.settings.roles.index" icon="archive-box">{{ __('admin.Roles') }}</x-nav.link>
@endcan

@can('view_system_settings')
    <x-nav.link route="admin.settings" icon="wrench-screwdriver">{{ __('admin.System Settings') }}</x-nav.link>
@endcan

@can('view_ai_assistant')
    <x-nav.link route="admin.settings.ai-assistant" icon="cpu-chip">{{ __('AI Assistant') }}</x-nav.link>
@endcan

@can('view_languages')
    <x-nav.link route="admin.settings.languages.index" icon="language">{{ __('admin.Languages') }}</x-nav.link>
@endcan

@can('view_notifications')
    <x-nav.link route="admin.settings.notifications" icon="bell">{{ __('admin.Notifications') }}</x-nav.link>
@endcan

@can('view_users')
    <x-nav.link route="admin.users.index" icon="users">{{ __('admin.Users') }}</x-nav.link>
@endcan
