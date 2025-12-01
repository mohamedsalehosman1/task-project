@php
    use Modules\Vendors\Entities\vendor;
@endphp
@component('dashboard::layouts.components.sidebarItem')
    @slot('can', ['permission' => 'read_vendors'])
    @slot('url', route('dashboard.vendors.index'))
    @slot('name', trans('vendors::vendors.plural'))
    @slot('isActive', request()->routeIs('*vendors*'))
    @slot('icon', 'fas fa-store-alt')
    @slot('tree', [
        [
            'name' => trans('vendors::vendors.plural'),
            'url' => route('dashboard.vendors.index'),
            'can' => ['permission' => 'read_vendors'],
            'isActive' => request()->routeIs('*vendors*'),
            'module' => 'Vendors',
        ],
          [
        'name' => trans('vendors::vendors.requests'),
        'url' => route('dashboard.vendors.requests'),
        'can' => ['permission' => 'update_vendors'],
        'badge' => Vendor::whereStatus('pending')->count(),
        'isActive' => request()->routeIs('*vendors.requests'),
        'module' => 'Vendors',
        ],
        [
            'name' => trans('vendors::vendors.actions.create'),
            'url' => route('dashboard.vendors.create'),
            'can' => ['permission' => 'create_vendors'],
            'isActive' => request()->routeIs('dashboard.vendors.create'),
            'module' => 'Vendors',
        ],
    ])
@endcomponent
