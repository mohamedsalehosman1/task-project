@component('dashboard::layouts.components.sidebarItem')
    @slot('can', [
    'permission' =>
     'read_jobtitles',
     'read_employees',
     'read_training_materials',
     'read_tasks',
     ])
    @slot('name', trans('dashboard::sidebar.hr'))
    @slot('isActive', request()->routeIs('*jobtitle*') || request()->routeIs('*employee*') || request()->routeIs('*training-materials*') || request()->routeIs('*tasks*'))
    @slot('icon', 'fas fa-briefcase')
    @php($trees = [
    // job titles
        [
            'name' => trans('employee::jobtitles.plural'),
            'url' => route('dashboard.jobtitle.index'),
            'can' => ['permission' => 'read_jobtitles'],
            'isActive' => request()->routeIs('*jobtitle*'),
            'module' => 'Employee',
            'icon' => 'fas fa-user-tag',
            'tree' => [
                [
                    'name' => trans('employee::jobtitles.actions.list'),
                    'url' => route('dashboard.jobtitle.index'),
                    'can' => ['permission' => 'read_jobtitles'],
                    'isActive' => request()->routeIs('*jobtitle.index'),
                    'module' => 'Employee',
                ],
                [
                    'name' => trans('employee::jobtitles.actions.create'),
                    'url' => route('dashboard.jobtitle.create'),
                    'can' => ['permission' => 'create_jobtitles'],
                    'isActive' => request()->routeIs('*jobtitle.create'),
                    'module' => 'Employee',
                ],
            ],
        ],
        // employees
        [
            'name' => trans('employee::employees.plural'),
            'url' => route('dashboard.employee.index'),
            'can' => ['permission' => 'read_employees'],
            'isActive' => request()->routeIs('*employee*'),
            'module' => 'Employee',
            'icon' => 'fas fa-user-tie',
            'tree' => [
                [
                    'name' => trans('employee::employees.actions.list'),
                    'url' => route('dashboard.employee.index'),
                    'can' => ['permission' => 'read_employees'],
                    'isActive' => request()->routeIs('*employee.index'),
                    'module' => 'Employee',
                ],
                [
                    'name' => trans('employee::employees.actions.create'),
                    'url' => route('dashboard.employee.create'),
                    'can' => ['permission' => 'create_employees'],
                    'isActive' => request()->routeIs('*employee.create'),
                    'module' => 'Employee',
                ],
            ],
        ],
        // training materials
        [
            'name' => trans('trainingmaterials::materials.plural'),
            'can' => ['permission' => 'read_training_materials'],
            'isActive' => request()->routeIs('*training-materials*'),
            'module' => 'TrainingMaterials',
            'icon' => 'fas fa-photo-video',
            'tree' => [
                [
                    'name' => trans('trainingmaterials::categories.actions.list'),
                    'url' => route('dashboard.training-material-categories.index'),
                    'can' => ['permission' => 'read_training_material_categories'],
                    'isActive' => request()->routeIs('*training-material-categories.index'),
                    'module' => 'TrainingMaterials',
                ],
                [
                    'name' => trans('trainingmaterials::categories.actions.create'),
                    'url' => route('dashboard.training-material-categories.create'),
                    'can' => ['permission' => 'create_training_material_categories'],
                    'isActive' => request()->routeIs('*training-material-categories.create'),
                    'module' => 'TrainingMaterials',
                ],
                [
                    'name' => trans('trainingmaterials::materials.actions.list'),
                    'url' => route('dashboard.training-materials.index'),
                    'can' => ['permission' => 'read_training_materials'],
                    'isActive' => request()->routeIs('*training-materials.index'),
                    'module' => 'TrainingMaterials',
                ],
                [
                    'name' => trans('trainingmaterials::materials.actions.create'),
                    'url' => route('dashboard.training-materials.create'),
                    'can' => ['permission' => 'create_training_materials'],
                    'isActive' => request()->routeIs('*training-materials.create'),
                    'module' => 'TrainingMaterials',
                ],
            ],
        ],
        // tasks
        [
            'name' => trans('task::tasks.plural'),
            'can' => ['permission' => 'read_tasks'],
            'isActive' => request()->routeIs('*tasks*'),
            'module' => 'Task',
            'icon' => 'fas fa-tasks',
            'tree' => [
                [
                    'name' => trans('task::tasks.actions.list'),
                    'url' => route('dashboard.tasks.index'),
                    'can' => ['permission' => 'read_tasks'],
                    'isActive' => request()->routeIs('*tasks.index'),
                    'module' => 'Task',
                ],
                [
                    'name' => trans('task::tasks.actions.create'),
                    'url' => route('dashboard.tasks.create'),
                    'can' => ['permission' => 'create_tasks'],
                    'isActive' => request()->routeIs('*tasks.create'),
                    'module' => 'Task',
                ],
                [
                    'name' => trans('task::tasks.tasksStatus'),
                    'url' => route('dashboard.tasks.status'),
                    'can' => ['permission' => 'status_tasks'],
                    'isActive' => request()->routeIs('*tasks.status'),
                    'module' => 'Task',
                ],
            ],
        ],
    ])
    @slot('tree', $trees)
@endcomponent
