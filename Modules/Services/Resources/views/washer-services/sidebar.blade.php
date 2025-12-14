@component('dashboard::layouts.components.sidebarItem')
    @slot('can', ['permission' => 'read_services'])
    @slot('url', route('dashboard.services.index'))
    @slot('name', trans('services::services.plural'))
    @slot('isActive', request()->routeIs('*services*'))
    @slot('icon', 'fas fa-tasks')
    @slot('tree', [
        [
            'name' => trans('services::services.actions.list'),
            'url' => route('dashboard.services.index'),
            'can' => ['permission' => 'read_services'],
            'isActive' => request()->routeIs('*services.index'),
            'module' => 'Services',
        ],
        [
            'name' => trans('services::services.actions.create'),
            'url' => route('dashboard.services.create'),
            'can' => ['permission' => 'create_services'],
            'isActive' => request()->routeIs('*services.create'),
            'module' => 'Services',
        ],
    ])
@endcomponent
