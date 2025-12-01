@component('dashboard::layouts.components.sidebarItem')
    @slot('can', ['permission' => 'read_packages'])
    @slot('url', route('dashboard.package.index'))
    @slot('name', trans('package::packages.plural'))
    @slot('isActive', request()->routeIs('*package*'))
    @slot('icon', 'fas fa-box')
    @slot('tree', [
        [
            'name' => trans('package::packages.actions.list'),
            'url' => route('dashboard.package.index'),
            'can' => ['permission' => 'read_packages'],
            'isActive' => request()->routeIs('*package.index'),
            'module' => 'Package',
        ],
        [
            'name' => trans('package::packages.actions.create'),
            'url' => route('dashboard.package.create'),
            'can' => ['permission' => 'create_packages'],
            'isActive' => request()->routeIs('*package.create'),
            'module' => 'Package',
        ],
    ])
@endcomponent
