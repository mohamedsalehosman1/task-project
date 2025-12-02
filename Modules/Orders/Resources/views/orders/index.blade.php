@extends('dashboard::layouts.default')

@section('title')
    @lang('orders::orders.plural')
@endsection

@section('content')
         @component('dashboard::layouts.components.page')

        @slot('title', trans('orders::orders.plural'))
        @slot('breadcrumbs', ['dashboard.orders.index'])

        @include('orders::orders.partials.filter')

        @component('dashboard::layouts.components.table-box')
            @slot('title', trans('orders::orders.actions.list'))
            {{--            @slot('tools') --}}
            {{--                @include('orders::orders.partials.actions.create') --}}
            {{--            @endslot --}}

            <thead>
                <tr>
                    <th>@lang('orders::orders.attributes.id')</th>
                    <th>@lang('orders::orders.attributes.statuses.status')</th>
                    <th>@lang('accounts::user.singular')</th>
                                        <th>@lang('products::products.attributes.vendor')</th>

                    @if (auth()->user()->hasPermission('show_orders'))
                        <th>@lang('orders::orders.userPhone')</th>
                        <th>@lang('orders::orders.attributes.total')</th>
                    @endcan
                    <th>@lang('orders::orders.attributes.created_at')</th>
                    <th style="width: 160px">...</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
                <tr>
                    <td>
                        <a href="{{ route('dashboard.orders.show', $order) }}" class="text-decoration-none text-ellipsis">
                            {{ $order->id }}
                        </a>
                    </td>
                    <td>
                        {{ __('orders::orders.status.' . $order->status) }}
                    </td>
                    <td>
                        {{ $order->user?->name }}

                    </td>
                    <td class="d-none d-md-table-cell">
    @if($order->vendor)
        <a href="{{ route('dashboard.vendors.show', $order->vendor->id) }}">
            {{ $order->vendor->name }}
        </a>
    @else
        -
    @endif
</td>



                    @if (auth()->user()->hasPermission('show_orders'))

                        <td>
                            {{ $order->user->phone }}
                        </td>

                        <td>
                            {{ $order->total }}
                        </td>


                    @endcan
                    <td>
                        {{ date('Y-m-d h:i A', strtotime($order->created_at)) }}
                    </td>
                    <td style="width: 160px">
                        @include('orders::orders.partials.actions.show')
                        {{-- @include('orders::orders.partials.actions.invoice') --}}
                    </td>
            </tr>
        @empty
            <tr>
                <td colspan="100" class="text-center">@lang('orders::orders.empty')</td>
            </tr>
        @endforelse

        @if ($orders->hasPages())
            @slot('footer')
                {{ $orders->links() }}
            @endslot
        @endif
    @endcomponent
@endcomponent
@endsection
