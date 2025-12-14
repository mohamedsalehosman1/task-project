@extends('dashboard::layouts.default')

@section('title')
    {{ $service->name }}
@endsection

@section('content')
    @component('dashboard::layouts.components.page')
        @slot('title', $service->name)
        @slot('breadcrumbs', ['dashboard.services.edit', $service])

        {{ BsForm::resource('services::services')->putModel($service, route('dashboard.sub_services.update', ['service' => $service->parent , 'sub_service' => $service]), ['files' => true,'data-parsley-validate']) }}
        @component('dashboard::layouts.components.box')
            @slot('title', trans('services::services.actions.edit'))

            @include('services::sub_services.partials.form')

            @slot('footer')
                {{ BsForm::submit()->label(trans('services::services.actions.save')) }}
            @endslot
        @endcomponent
        {{ BsForm::close() }}

    @endcomponent
@endsection
