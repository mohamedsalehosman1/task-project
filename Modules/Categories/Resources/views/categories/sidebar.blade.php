@component('dashboard::layouts.components.sidebarItem')
    @slot('can', ['permission' => 'read_categories'])
    @slot('url', route('dashboard.categories.index'))
    @slot('name', trans('categories::categories.plural'))
    @slot('isActive', request()->routeIs('*categories*'))
    @slot('icon', 'fas fa-handshake')
    @slot('tree', [
        [
            'name' => trans('categories::categories.actions.list'),
            'url' => route('dashboard.categories.index'),
            'can' => ['permission' => 'read_categories'],
            'isActive' => request()->routeIs('*categories.index'),
            'module' => 'Categories',
        ],
        [
            'name' => trans('categories::categories.actions.create'),
            'url' => route('dashboard.categories.create'),
            'can' => ['permission' => 'create_categories'],
            'isActive' => request()->routeIs('*categories.create'),
            'module' => 'Categories',
        ],
        [
            'name' => trans('categories::categories.actions.order'),
            'url' => route('dashboard.order.form.categories'),
            'can' => ['permission' => 'read_categories'],
            'isActive' => request()->routeIs('*order.form.categories'),
            'module' => 'Categories',
        ],
    ])
@endcomponent
