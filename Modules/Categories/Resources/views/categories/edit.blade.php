@extends('dashboard::layouts.default')

@section('title')
    {{ $category->name }}
@endsection

@section('content')
    @component('dashboard::layouts.components.page')
        @slot('title', $category->name)
        @slot('breadcrumbs', ['dashboard.categories.edit', $category])

        {{ BsForm::resource('categories::categories')->putModel($category, route('dashboard.categories.update', $category), ['files' => true,'data-parsley-validate']) }}
        @component('dashboard::layouts.components.box')
            @slot('title', trans('categories::categories.actions.edit'))

            @include('categories::categories.partials.form')

            @slot('footer')
                {{ BsForm::submit()->label(trans('categories::categories.actions.save')) }}
            @endslot
        @endcomponent
        {{ BsForm::close() }}

    @endcomponent
@endsection
