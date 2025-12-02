@extends('dashboard::layouts.default')

@section('title')
    @lang('vendors::vendors.requests')
@endsection

@section('content')

@component('dashboard::layouts.components.page')
        @slot('title', trans('vendors::vendors.requests'))

        @slot('breadcrumbs', ['dashboard.vendors.index'])

        @include('vendors::vendors.partials.filter')

        @component('dashboard::layouts.components.table-box')
            @slot('title', trans('vendors::vendors.requests'))

            @slot('tools')
            @endslot

            <thead>
                <tr>
                    <th>@lang('vendors::vendors.attributes.name')</th>
                    <th>@lang('vendors::vendors.attributes.phone')</th>
                    <th>@lang('vendors::vendors.attributes.email')</th>
                    <th>@lang('vendors::vendors.attributes.verified')</th>
                    <th>@lang('vendors::vendors.attributes.status')</th>
                    <th>...</th>
                </tr>
            </thead>

            <tbody>
                @forelse($vendors as $vendor)
                    <tr>
                        <td>
                            <a href="{{ route('dashboard.vendors.show', $vendor) }}" class="text-decoration-none">
                                <div class="d-flex align-items-center">
                                    <div class="symbol symbol-30 symbol-circle symbol-xl-30">
                                        <img src="{{ $vendor->getImage() }}" width="40" class="rounded-circle">
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-dark-75 mb-0">
                                            {{ $vendor->name }}
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </td>
                        <td>{{ $vendor->phone }}</td>
                        <td>{{ $vendor->email }}</td>
                        <td>@include('vendors::vendors.partials.flags.verified')</td>
                        <td>{!! $vendor->getStatus() !!}</td>


                        <td>
                            @include('vendors::vendors.partials.actions.show')
                            @include('vendors::vendors.partials.actions.approved')
                            @include('vendors::vendors.partials.actions.reject')
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="100" class="text-center">@lang('vendors::vendors.empty')</td>
                    </tr>
                @endforelse

                @if ($vendors->hasPages())
                    @slot('footer')
                        {{ $vendors->links() }}
                    @endslot
                @endif
            @endcomponent
        @endcomponent
    @endsection
