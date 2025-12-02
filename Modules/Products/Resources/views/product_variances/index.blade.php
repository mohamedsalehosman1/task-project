@extends('dashboard::layouts.default')

@section('title')
    @lang('products::product_variances.plural')
@endsection

@section('content')
@component('dashboard::layouts.components.page')
        @slot('title', trans('products::product_variances.plural'))
        @slot('breadcrumbs', ['dashboard.product_variances.index', $product])

        @include('products::product_variances.partials.filter')

        @component('dashboard::layouts.components.table-box')
            @slot('title', trans('products::product_variances.actions.list'))
            @slot('tools')
                @include('products::product_variances.partials.actions.create')
            @endslot

            <thead>
                <tr>
                    <th>@lang('products::product_variances.attributes.name')</th>
                    <th style="width: 160px">...</th>
                </tr>
            </thead>
            <tbody>
                @forelse($product_variances as $product_variance)
                    <tr>

                        <td class="d-none d-md-table-cell">
                            {{ $product_variance->size?->name }}
                        </td>

                        <td style="width: 160px">
                            {{-- @include('products::products.partials.actions.show') --}}
                            @include('products::product_variances.partials.actions.edit')
                            @include('products::product_variances.partials.actions.delete')
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="100" class="text-center">@lang('products::product_variances.empty')</td>
                    </tr>
                @endforelse

                @if ($product_variances->hasPages())
                    @slot('footer')
                        {{ $product_variances->links() }}
                    @endslot
                @endif
            @endcomponent
        @endcomponent
    @endsection
