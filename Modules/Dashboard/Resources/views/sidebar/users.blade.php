@component('dashboard::layouts.components.sidebarItem')
    @slot('can', [
    'permission' =>
     'read_users',
     'read_usertypes',
     ])
    @slot('name', trans('accounts::users.plural'))
    @slot('isActive', request()->routeIs('*users*') || request()->routeIs('*usertypes*'))
    @slot('icon', 'fas fa-users')
    @php($trees = [
        // users
        [
            'name' => trans('accounts::user.plural'),
            'url' => route('dashboard.users.index'),
            'can' => ['permission' => 'read_users'],
            'isActive' => request()->routeIs('*users*'),
            'module' => 'Accounts',
            'icon' => 'fas fa-user-shield',
            'tree' => [
                [
                    'name' => trans('accounts::user.actions.list'),
                    'url' => route('dashboard.users.index'),
                    'can' => ['permission' => 'read_users'],
                    'isActive' => request()->routeIs('*users.index'),
                    'module' => 'Accounts',
                ],
                [
                    'name' => trans('accounts::user.actions.create'),
                    'url' => route('dashboard.users.create'),
                    'can' => ['permission' => 'create_users'],
                    'isActive' => request()->routeIs('*users.create'),
                    'module' => 'Accounts',
                ],
            ],
        ],
        // user types
        [
            'name' => trans('usertype::usertypes.plural'),
            'url' => route('dashboard.usertypes.index'),
            'can' => ['permission' => 'read_usertypes'],
            'isActive' => request()->routeIs('*usertypes*'),
            'module' => 'UserType',
            'icon' => 'fas fa-user-tag',
            'tree' => [
                [
                    'name' => trans('usertype::usertypes.actions.list'),
                    'url' => route('dashboard.usertypes.index'),
                    'can' => ['permission' => 'read_usertypes'],
                    'isActive' => request()->routeIs('*usertypes.index'),
                    'module' => 'UserType',
                ],
                [
                    'name' => trans('usertype::usertypes.actions.create'),
                    'url' => route('dashboard.usertypes.create'),
                    'can' => ['permission' => 'create_usertypes'],
                    'isActive' => request()->routeIs('*usertypes.create'),
                    'module' => 'UserType',
                ],
            ],
        ],
    ])
    @slot('tree', $trees)
@endcomponent
