@extends('dashboard::layouts.default')

@section('title')
    {{ $vendorService->vendor->name }}
@endsection

@section('content')
    @component('dashboard::layouts.components.page')
        @slot('title', $vendorService->vendor->name)
        @slot('breadcrumbs', ['dashboard.vendor-services.edit', $vendorService->vendor])

        {{ BsForm::resource('services::services')->putModel($vendorService, route('dashboard.vendor-services.update', $vendorService), ['files' => true,'data-parsley-validate']) }}
        @component('dashboard::layouts.components.box')
            @slot('title', trans('services::services.actions.edit'))

            @include('services::vendor-services.partials.form')

            @slot('footer')
                {{ BsForm::submit()->label(trans('services::services.actions.save')) }}
            @endslot
        @endcomponent
        {{ BsForm::close() }}

    @endcomponent
@endsection
