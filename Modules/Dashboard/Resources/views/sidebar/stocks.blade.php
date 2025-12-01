@component('dashboard::layouts.components.sidebarItem')
    @slot('can', [
    'permission' =>
     'read_categories',
     'read_suppliers',
     'read_products',
     ])
    @slot('name', trans('stock::stock.stocks'))
    @slot('isActive', request()->routeIs('*stocks*') || request()->routeIs('*categories*') || request()->routeIs('*suppliers*') || request()->routeIs('*products*') )
    @slot('icon', 'fas fa-cubes')
    @php($trees = [
        // suppliers
        [
            'name' => trans('stock::suppliers.plural'),
            'url' => route('dashboard.suppliers.index'),
            'can' => ['permission' => 'read_suppliers'],
            'isActive' => request()->routeIs('*suppliers*'),
            'module' => 'Stock',
            'icon' => 'fas fa-boxes',
            'tree' => [
                [
                    'name' => trans('stock::suppliers.actions.list'),
                    'url' => route('dashboard.suppliers.index'),
                    'can' => ['permission' => 'read_suppliers'],
                    'isActive' => request()->routeIs('*suppliers.index'),
                    'module' => 'Stock',
                ],
                [
                    'name' => trans('stock::suppliers.actions.create'),
                    'url' => route('dashboard.suppliers.create'),
                    'can' => ['permission' => 'read_suppliers'],
                    'isActive' => request()->routeIs('*suppliers.create'),
                    'module' => 'Stock',
                ],
            ],
        ],
        // categories
        [
            'name' => trans('stock::categories.plural'),
            'url' => route('dashboard.categories.index'),
            'can' => ['permission' => 'read_categories'],
            'isActive' => request()->routeIs('*categories*'),
            'module' => 'Stock',
            'icon' => 'fas fa-bars',
            'tree' => [
                [
                    'name' => trans('stock::categories.actions.list'),
                    'url' => route('dashboard.categories.index'),
                    'can' => ['permission' => 'read_categories'],
                    'isActive' => request()->routeIs('*categories.index'),
                    'module' => 'Stock',
                ],
                [
                    'name' => trans('stock::categories.actions.create'),
                    'url' => route('dashboard.categories.create'),
                    'can' => ['permission' => 'read_categories'],
                    'isActive' => request()->routeIs('*categories.create'),
                    'module' => 'Stock',
                ],
            ],
        ],
        // products
        [
            'name' => trans('stock::products.plural'),
            'url' => route('dashboard.products.index'),
            'can' => ['permission' => 'read_products'],
            'isActive' => request()->routeIs('*products*'),
            'module' => 'Stock',
            'icon' => 'fas fa-box',
            'tree' => [
                [
                    'name' => trans('stock::products.actions.list'),
                    'url' => route('dashboard.products.index'),
                    'can' => ['permission' => 'read_products'],
                    'isActive' => request()->routeIs('*products.index'),
                    'module' => 'Stock',
                ],
                [
                    'name' => trans('stock::products.actions.create'),
                    'url' => route('dashboard.products.create'),
                    'can' => ['permission' => 'read_products'],
                    'isActive' => request()->routeIs('*products.create'),
                    'module' => 'Stock',
                ],
            ],
        ],
    ])
    @slot('tree', $trees)
@endcomponent
