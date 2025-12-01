@component('dashboard::layouts.components.sidebarItem')
    @slot('can', [
    'permission' =>
     'read_branches',
     ])
    @slot('name', trans('branches::branches.plural'))
    @slot('isActive', request()->routeIs('*branches*') || request()->routeIs('*rooms*'))
    @slot('icon', 'mdi mdi-map-marker-multiple')
    @php($trees = [
    // branches
        [
            'name' => trans('branches::branches.plural'),
            'url' => route('dashboard.branches.index'),
            'can' => ['permission' => 'read_branches'],
            'isActive' => request()->routeIs('*branches*'),
            'module' => 'Branches',
            'icon' => 'fas fa-map-marked',
            'tree' => [
                [
                    'name' => trans('branches::branches.actions.list'),
                    'url' => route('dashboard.branches.index'),
                    'can' => ['permission' => 'read_branches'],
                    'isActive' => request()->routeIs('*branches.index'),
                    'module' => 'Branches',
                ],
                [
                    'name' => trans('branches::branches.actions.create'),
                    'url' => route('dashboard.branches.create'),
                    'can' => ['permission' => 'create_branches'],
                    'isActive' => request()->routeIs('*branches.create'),
                    'module' => 'Branches',
                ],
            ],
        ],
    ])
    @slot('tree', $trees)
@endcomponent
