@extends('dashboard::layouts.default')

@section('title')
    @lang('vendors::vendors.plural')
@endsection

@section('content')

        {{-- @component('dashboard::layouts.components.page') --}}

        @slot('title', trans('vendors::vendors.plural'))

        @slot('breadcrumbs', ['dashboard.vendors.index'])

        @include('vendors::vendors.partials.filter')

        @component('dashboard::layouts.components.table-box')
            @slot('title', trans('vendors::vendors.actions.list'))

            @slot('tools')
                @include('vendors::vendors.partials.actions.create')
                @include('vendors::vendors.partials.actions.trashed')

            @endslot

            <thead>
                <tr>
                    <th>@lang('vendors::vendors.attributes.name')</th>
                    <th>@lang('vendors::vendors.attributes.email')</th>
                    <th>@lang('vendors::vendors.attributes.phone')</th>
                    <th>@lang('vendors::vendors.attributes.blocked')</th>
                    <th>@lang('vendors::vendors.attributes.status')</th>
                    <th>...</th>
                </tr>
            </thead>

            <tbody>
                @forelse($vendors as $vendor)
                    <tr class="align-middle">
                        <td>
                            <a href="{{ route('dashboard.vendors.show', $vendor) }}" class="text-decoration-none">
                                <div class="d-flex align-items-center">
                                    <div class="symbol symbol-30 symbol-circle symbol-xl-30">
                                        <img src="{{ $vendor->getImage() }}" class="rounded img-size-64 mr-2" height="64">
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-dark-75 mb-0">
                                            {{ $vendor->name }}
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </td>
                        <td class="align-middle">{{ $vendor->email }}</td>
                        <td class="align-middle">{{ $vendor->phone }}</td>
                        <td class="align-middle">@include('vendors::vendors.partials.flags.blocked')</td>
                        <td>{!! $vendor->getStatus() !!}</td>


                        @if(!$vendor->status == 'pending')
                            @include('vendors::vendors.partials.actions.show')
                            @include('vendors::vendors.partials.actions.block')
                            @include('vendors::vendors.partials.actions.delete')
                            @include('vendors::vendors.partials.actions.approved')
                        @else
                        <td class="align-middle">
                            @include('vendors::vendors.partials.actions.show')
                            @include('vendors::vendors.partials.actions.edit')
                            @include('vendors::vendors.partials.actions.block')
                            @include('vendors::vendors.partials.actions.delete')
                        </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="100" class="text-center">@lang('vendors::vendors.empty')</td>
                    </tr>
                @endforelse
            </tbody>
            @if ($vendors->hasPages())
                @slot('footer')
                    {{ $vendors->links() }}
                @endslot
            @endif
        @endcomponent
    @endcomponent
@endsection
