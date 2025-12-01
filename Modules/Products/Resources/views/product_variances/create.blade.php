@extends('dashboard::layouts.default')

@section('title')
    @lang('products::product_variances.actions.create')
@endsection

@section('content')
        {{-- @component('dashboard::layouts.components.page') --}}

        @slot('title', trans('products::product_variances.plural'))
        @slot('breadcrumbs', ['dashboard.product_variances.create' , $product])

        {{ BsForm::resource('products::products')->post(route('dashboard.product_variances.store' , $product), ['files' => true,'data-parsley-validate', 'class' => 'repeater']) }}
        @component('dashboard::layouts.components.box')
            @slot('title', trans('products::product_variances.actions.create'))

            @include('products::product_variances.partials.form')

            @slot('footer')
                {{ BsForm::submit()->label(trans('products::product_variances.actions.save')) }}
            @endslot
        @endcomponent
        {{ BsForm::close() }}

    @endcomponent
@endsection
