@extends('dashboard::layouts.default')

@section('title')
    @lang('categories::categories.plural')
@endsection

@section('content')
    @component('dashboard::layouts.components.page')
        @slot('title', trans('categories::categories.plural'))
        @slot('breadcrumbs', ['dashboard.categories.index'])

        @include('dashboard::layouts.apps.module-activate', [
            'model' => 'Category',
        ])

        @include('categories::categories.partials.filter')

        @component('dashboard::layouts.components.table-box')
            @slot('title', trans('categories::categories.actions.list'))
            @slot('tools')
                @include('categories::categories.partials.actions.create')
            @endslot

            <thead>
                <tr>
                    {{-- <th>@lang('categories::categories.attributes.image')</th> --}}
                    <th>@lang('categories::categories.attributes.name')</th>
                    <th>@lang('categories::categories.attributes.type')</th>

                    <th style="width: 160px">...</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                    <tr>
                        {{-- <td class="d-none d-md-table-cell">
                            <img src="{{ $category->getImage() }}" alt="Product 1" class="img-circle img-size-32 mr-2"
                                style="height: 32px;">
                        </td> --}}
                        <td class="d-none d-md-table-cell">
                            {{ $category->name }}
                        </td>

                        <td class="d-none d-md-table-cell">
                            {{ $category->type }}
                        </td>

                        <td style="width: 160px">
                            {{-- @include('categories::categories.partials.actions.show') --}}
                            @include('categories::categories.partials.actions.edit')
                            @include('categories::categories.partials.actions.delete')
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="100" class="text-center">@lang('categories::categories.empty')</td>
                    </tr>
                @endforelse

                @if ($categories->hasPages())
                    @slot('footer')
                        {{ $categories->links() }}
                    @endslot
                @endif
            @endcomponent
        @endcomponent
    @endsection
