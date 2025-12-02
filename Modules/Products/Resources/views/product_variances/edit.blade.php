@extends('dashboard::layouts.default')

@section('title')
    {{ $product->name }}
@endsection

@section('content')
@component('dashboard::layouts.components.page')
        @slot('title', $product->name)
        @slot('breadcrumbs', ['dashboard.products.edit', $product])

        {{ BsForm::resource('products::products')->putModel($productVariance, route('dashboard.product_variances.update', [$product, $productVariance]), ['files' => true, 'data-parsley-validate', 'class' => 'repeater']) }}
        @component('dashboard::layouts.components.box')
            @slot('title', trans('products::product_variances.actions.edit'))

            @include('products::product_variances.partials.form')

            @slot('footer')
                {{ BsForm::submit()->label(trans('products::product_variances.actions.save')) }}
            @endslot
        @endcomponent
        {{ BsForm::close() }}
    @endcomponent
@endsection
