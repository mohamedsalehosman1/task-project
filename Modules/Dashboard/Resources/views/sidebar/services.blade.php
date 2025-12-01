@component('dashboard::layouts.components.sidebarItem')
    @slot('can',[
    'permission' =>
        'read_examinations',
        'read_sessions',
        'read_diets',
        'read_medical_analysis',
        'read_regions',
        'read_packages',

    ])
    @slot('name', trans('service::services.plural'))
    @slot('isActive', request()->routeIs('*service*') || request()->routeIs('*examinations*') || request()->routeIs('*sessions*')
|| request()->routeIs('*diets*') || request()->routeIs('*regions*') || request()->routeIs('*package*') )
    @slot('icon', 'mdi mdi-view-grid-outline')
    @php($trees = [
        // examinations
        [
            'name' => trans('examinations::examinations.plural'),
            'url' => route('dashboard.examinations.index'),
            'can' => ['permission' => 'read_examinations'],
            'isActive' => request()->routeIs('*examinations*'),
            'module' => 'Examinations',
            'icon' => 'mdi mdi-clock-check',
            'tree' => [
                [
                    'name' => trans('examinations::examinations.actions.list'),
                    'url' => route('dashboard.examinations.index'),
                    'can' => ['permission' => 'read_examinations'],
                    'isActive' => request()->routeIs('*examinations.index'),
                    'module' => 'Examinations',
                ],
                [
                    'name' => trans('examinations::examinations.actions.create'),
                    'url' => route('dashboard.examinations.create'),
                    'can' => ['permission' => 'create_examinations'],
                    'isActive' => request()->routeIs('*examinations.create'),
                    'module' => 'Examinations',
                ],
            ],
        ],
        // sessions
        [
            'name' => trans('sessions::sessions.plural'),
            'url' => route('dashboard.sessions.index'),
            'can' => ['permission' => 'read_sessions'],
            'isActive' => request()->routeIs('*sessions*'),
            'module' => 'Sessions',
            'icon' => 'mdi mdi-file-document-box-check',
            'tree' => [
                [
                    'name' => trans('sessions::sessions.actions.list'),
                    'url' => route('dashboard.sessions.index'),
                    'can' => ['permission' => 'read_sessions'],
                    'isActive' => request()->routeIs('*sessions.index'),
                    'module' => 'Sessions',
                ],
                [
                    'name' => trans('sessions::sessions.actions.create'),
                    'url' => route('dashboard.sessions.create'),
                    'can' => ['permission' => 'create_sessions'],
                    'isActive' => request()->routeIs('*sessions.create'),
                    'module' => 'Sessions',
                ],
                [
                    'name' => trans('region::regions.plural'),
                    'url' => route('dashboard.regions.index'),
                    'can' => ['permission' => 'read_regions'],
                    'isActive' => request()->routeIs('*regions*'),
                    'module' => 'Region',
                    'icon' => 'fas fa-child',
                    'tree' => [
                        [
                            'name' => trans('region::regions.actions.list'),
                            'url' => route('dashboard.regions.index'),
                            'can' => ['permission' => 'read_regions'],
                            'isActive' => request()->routeIs('*regions.index'),
                            'module' => 'Region',
                        ],
                        [
                            'name' => trans('region::regions.actions.create'),
                            'url' => route('dashboard.regions.create'),
                            'can' => ['permission' => 'create_regions'],
                            'isActive' => request()->routeIs('*regions.create'),
                            'module' => 'Region',
                        ],
                    ],
                ],
            ],
        ],
        // diets
        [
            'name' => trans('diet::diets.plural'),
            'url' => route('dashboard.diets.index'),
            'can' => ['permission' => 'read_diets'],
            'isActive' => request()->routeIs('*diets*'),
            'module' => 'Diet',
            'icon' => 'fas fa-utensils',
            'tree' => [
                [
                    'name' => trans('diet::diets.actions.list'),
                    'url' => route('dashboard.diets.index'),
                    'can' => ['permission' => 'read_diets'],
                    'isActive' => request()->routeIs('*diets.index'),
                    'module' => 'Diet',
                ],
                [
                    'name' => trans('diet::diets.actions.create'),
                    'url' => route('dashboard.diets.create'),
                    'can' => ['permission' => 'create_diets'],
                    'isActive' => request()->routeIs('*diets.create'),
                    'module' => 'Diet',
                ],
            ],
        ],
        // medical_analysis
        [
            'name' => trans('analysis::medical_analysis.plural'),
            'url' => route('dashboard.medical-analyses.index'),
            'can' => ['permission' => 'read_medical_analysis'],
            'isActive' => request()->routeIs('*medical-analyses*'),
            'module' => 'Analysis',
            'icon' => 'fas fa-file-medical-alt',
            'tree' => [
                [
                    'name' => trans('analysis::medical_analysis.actions.list'),
                    'url' => route('dashboard.medical-analyses.index'),
                    'can' => ['permission' => 'read_medical_analysis'],
                    'isActive' => request()->routeIs('*medical-analyses.index'),
                    'module' => 'Analysis',
                ],
                [
                    'name' => trans('analysis::medical_analysis.actions.create'),
                    'url' => route('dashboard.medical-analyses.create'),
                    'can' => ['permission' => 'create_medical_analysis'],
                    'isActive' => request()->routeIs('*medical-analyses.create'),
                    'module' => 'Analysis',
                ],
            ],
        ],
        // services
        [
            'name' => trans('service::services.plural'),
            'url' => route('dashboard.service.index'),
            'can' => ['permission' => 'read_services'],
            'isActive' => request()->routeIs('*services*'),
            'module' => 'Service',
            'icon' => 'mdi mdi-file-document-box-plus-outline',
            'tree' => [
                [
                    'name' => trans('service::services.actions.list'),
                    'url' => route('dashboard.service.index'),
                    'can' => ['permission' => 'read_services'],
                    'isActive' => request()->routeIs('*service.index'),
                    'module' => 'Service',
                ],
                [
                    'name' => trans('service::services.actions.create'),
                    'url' => route('dashboard.service.create'),
                    'can' => ['permission' => 'create_services'],
                    'isActive' => request()->routeIs('*service.create'),
                    'module' => 'Service',
                ],
            ],
        ],
    ])
    @slot('tree', $trees)
@endcomponent
