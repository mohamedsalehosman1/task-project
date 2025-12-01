{{-- @component('dashboard::layouts.components.sidebarItem')
    @slot('can', [
        'permission' => 'read_settings',
        'read_countries',
        'read_roles',
        'read_users',
        ])
        @slot('name', trans('settings::settings.plural'))
        @slot('isActive', request()->routeIs('*settings*') || request()->routeIs('*operative-history*') ||
            request()->routeIs('*roles*') || request()->routeIs('*roles*') ||
            request()->routeIs('*labs*') || request()->routeIs('*branches*') || request()->routeIs('*rooms*') ||
            request()->routeIs('*users*') || request()->routeIs('*usertypes*'))
            @slot('icon', 'fas fa-cogs')
            @php(
    $trees = [
        // settings main
        [
            'name' => trans('settings::settings.tabs.main'),
            'url' => route('dashboard.settings.index', ['tab' => 'main']),
            'can' => ['permission' => 'read_settings'],
            'isActive' => request()->routeIs('*settings*') && request('tab') == 'main',
            'module' => 'Settings',
            'icon' => 'fas fa-cog',
        ],
        // settings contacts
        [
            'name' => trans('settings::settings.tabs.contacts'),
            'url' => route('dashboard.settings.index', ['tab' => 'contacts']),
            'can' => ['permission' => 'read_settings'],
            'isActive' => request()->routeIs('*settings*') && request('tab') == 'contacts',
            'module' => 'Settings',
            'icon' => 'fas fa-address-card',
        ],
        // settings social
        [
            'name' => trans('settings::settings.tabs.social'),
            'url' => route('dashboard.settings.index', ['tab' => 'social']),
            'can' => ['permission' => 'read_settings'],
            'isActive' => request()->routeIs('*settings*') && request('tab') == 'social',
            'module' => 'Settings',
            'icon' => 'fab fa-facebook',
        ],
    ]
)
            @slot('tree', $trees)
        @endcomponent --}}



        @component('dashboard::layouts.components.sidebarItem')
    @slot('can', [
        'permission' => 'read_settings',
        'read_countries',
        'read_roles',
        'read_users',
        ])
        @slot('name', trans('settings::settings.plural'))
        @slot('isActive', request()->routeIs('*settings*') || request()->routeIs('*operative-history*') ||
            request()->routeIs('*roles*') ||
            request()->routeIs('*roles*') || request()->routeIs('*labs*') || request()->routeIs('*branches*') ||
            request()->routeIs('*rooms*') || request()->routeIs('*users*') || request()->routeIs('*usertypes*'))
            @slot('icon', 'fas fa-cogs')
            @php(
    $trees = [
        // settings main
        [
            'name' => trans('settings::settings.tabs.main'),
            'url' => route('dashboard.settings.index', ['tab' => 'main']),
            'can' => ['permission' => 'read_settings'],
            'isActive' => request()->routeIs('*settings*') && request('tab') == 'main',
            'module' => 'Settings',
            'icon' => 'fas fa-cog',
        ],
        // Map
        [
            'name' => trans('Google Map'),
            'url' => route('dashboard.map1'),
            'can' => ['permission' => 'read_settings'],
            'isActive' => request()->routeIs('dashboard.map1'),
            'module' => 'Settings',
            'icon' => 'fas fa-map-marker-alt',
        ],
        // settings contacts
        [
            'name' => trans('settings::settings.tabs.contacts'),
            'url' => route('dashboard.settings.index', ['tab' => 'contacts']),
            'can' => ['permission' => 'read_settings'],
            'isActive' => request()->routeIs('*settings*') && request('tab') == 'contacts',
            'module' => 'Settings',
            'icon' => 'fas fa-address-card',
        ],
        // settings social
        [
            'name' => trans('settings::settings.tabs.social'),
            'url' => route('dashboard.settings.index', ['tab' => 'social']),
            'can' => ['permission' => 'read_settings'],
            'isActive' => request()->routeIs('*settings*') && request('tab') == 'social',
            'module' => 'Settings',
            'icon' => 'fab fa-facebook',
        ],
        // settings seo
        [
            'name' => trans('settings::settings.tabs.seo'),
            'url' => route('dashboard.settings.index', ['tab' => 'seo']),
            'can' => ['permission' => 'read_settings'],
            'isActive' => request()->routeIs('*settings*') && request('tab') == 'seo',
            'module' => 'Settings',
            'icon' => 'fas fa-search',
        ],
        // mail
        // [
        //     'name' => trans('settings::settings.tabs.mail'),
        //     'url' => route('dashboard.settings.index', ['tab' => 'mail']),
        //     'can' => ['permission' => 'read_settings'],
        //     'isActive' => request()->routeIs('*settings*') && request('tab') == 'mail',
        //     'module' => 'Settings',
        //     'icon' => 'far fa-envelope',
        // ],
        // mail templates
        // [
        //     'name' => trans('settings::settings.tabs.mail-templates'),
        //     'url' => route('dashboard.settings.index', ['tab' => 'mail-templates']),
        //     'can' => ['permission' => 'read_settings'],
        //     'isActive' => request()->routeIs('*settings*') && request('tab') == 'mail-templates',
        //     'module' => 'Settings',
        //     'icon' => 'fas fa-envelope',
        // ],
          // Google Analytics and Facebook Pixel
        [
            'name' => trans('Google Analytics and Facebook Pixel'),
            'url' => route('dashboard.settings.index', ['tab' => 'pixel']),
            'can' => ['permission' => 'read_settings'],
            'isActive' => request()->routeIs('*settings*') && request('tab') == 'pixel',
            'module' => 'Settings',
            'icon' => 'fas fa-chart-line',
        ],
        // settings contacts
        // [
        //     'name' => 'Thanks Page',
        //     'url' => route('dashboard.settings.index', ['tab' => 'titles']),
        //     'can' => ['permission' => 'read_settings'],
        //     'isActive' => request()->routeIs('*settings*') && request('tab') == 'titles',
        //     'module' => 'Settings',
        //     'icon' => 'fas fa-thumbs-up',
        // ],
    ]
)
            @slot('tree', $trees)
        @endcomponent
