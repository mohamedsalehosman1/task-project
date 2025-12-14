@component('dashboard::layouts.components.page-form')
    @slot('title', '')
    {{ BsForm::post(route('dashboard.sub_services.store', $service), ['files' => true, 'data-parsley-validate']) }}
    @component('dashboard::layouts.components.box')
        @slot('title', trans('services::sub_services.actions.create'))

        @include('services::sub_services.partials.form')

        @slot('footer')
            {{ BsForm::submit()->label(trans('services::sub_services.actions.save')) }}
        @endslot
    @endcomponent
    {{ BsForm::close() }}
@endcomponent
