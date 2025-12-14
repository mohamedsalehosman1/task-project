@extends('dashboard::layouts.default')

@section('title')
    @lang('services::services.plural')
@endsection

@section('content')
    @component('dashboard::layouts.components.page')
        @slot('title', trans('services::services.plural'))
        @slot('breadcrumbs', ['dashboard.services.index'])

        @include('services::vendor-services.partials.filter')

        @component('dashboard::layouts.components.table-box')
            @slot('title', trans('services::services.actions.list'))
            @slot('tools')
                @include('services::vendor-services.partials.actions.create')
            @endslot

            <thead>
                <tr>
                    <th>@lang('services::services.attributes.image')</th>
                    <th>@lang('services::services.attributes.name')</th>
                    <th>@lang('vendors::vendors.singular')</th>

                    <th style="width: 160px">...</th>
                </tr>
            </thead>
            <tbody>
                @forelse($vendorServices as $vendorService)
                    <tr>
                        <td class="d-none d-md-table-cell">
                            <img src="{{ $vendorService->service->getImage() }}" alt="{{ $vendorService->service->name }}" class="mr-2 rounded" width="64"
                                height="64">
                        </td>
                        <td class="d-none d-md-table-cell">
                            {{ $vendorService->service->name }}
                        </td>
                        <td class="d-none d-md-table-cell">
                            {{ $vendorService->vendor->name }}
                        </td>

                        <td style="width: 160px">
                            @include('services::vendor-services.partials.actions.show')
                            @include('services::vendor-services.partials.actions.edit')
                            @include('services::vendor-services.partials.actions.delete')
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="100" class="text-center">@lang('services::services.empty')</td>
                    </tr>
                @endforelse

                @if ($vendorServices->hasPages())
                    @slot('footer')
                        {{ $vendorServices->links() }}
                    @endslot
                @endif

            @endcomponent
        @endcomponent

    @endsection
