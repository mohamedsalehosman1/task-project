@component('dashboard::layouts.components.sidebarItem')
    @slot('can', [
    'permission' =>
     'read_patients',
     ])
    @slot('name', trans('patient::patients.plural'))
    @slot('isActive', request()->routeIs('*patients*'))
    @slot('icon', 'fas fa-hospital-user')
    @php($trees = [
    // patients
        [
            'name' => trans('patient::patients.actions.list'),
            'url' => route('dashboard.patients.index'),
            'can' => ['permission' => 'read_patients'],
            'isActive' => request()->routeIs('*patients.index'),
            'module' => 'Patient',
        ],
        [
            'name' => trans('patient::patients.actions.create'),
            'url' => route('dashboard.patients.create'),
            'can' => ['permission' => 'create_patients'],
            'isActive' => request()->routeIs('*patients.create'),
            'module' => 'Patient',
        ],
    ])
    @slot('tree', $trees)
@endcomponent
