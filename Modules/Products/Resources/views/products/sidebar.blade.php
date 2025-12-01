@component('dashboard::layouts.components.sidebarItem')
    @slot('can', ['permission' => 'read_products'])
    @slot('url', route('dashboard.products.index'))
    @slot('name', trans('products::products.plural'))
    @slot('isActive', request()->routeIs('*products*'))
    @slot('icon', 'fas fa-tshirt')
    @slot('tree', [
        [
        'name' => trans('products::products.actions.list'),
        'url' => route('dashboard.products.index'),
        'can' => ['permission' => 'read_products'],
        'isActive' => request()->routeIs('*products.index'),
        'module' => 'Products',
        ],
        [
        'name' => trans('products::products.actions.create'),
        'url' => route('dashboard.products.create'),
        'can' => ['permission' => 'create_products'],
        'isActive' => request()->routeIs('*products.create'),
        'module' => 'Products',
        ],
        [
        'name' => trans('products::products.actions.pending_requests'),
        'url' => route('requests'),
        'can' => ['permission' => 'read_products'],
'badge' => auth()->user()->can('read_products')
    ? \Modules\Products\Entities\Product::where('status', 'pending')->count()
    : 0,
        'isActive' => request()->routeIs('*dashboard.products.requests'),
        'module' => 'Products',
        ],
        ])
    @endcomponent
