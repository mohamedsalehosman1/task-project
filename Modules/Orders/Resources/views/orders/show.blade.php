@extends('dashboard::layouts.default')

@section('title')
    {{ $order->user->name }}
@endsection

@section('content')
         @component('dashboard::layouts.components.page')

        @slot('title', $order->user->name)
        @slot('breadcrumbs', ['dashboard.orders.show', $order])

        <div class="row">
            <div class="col-md-6">
                @component('dashboard::layouts.components.box')
                    @slot('bodyClass', 'p-0')

                    <table class="table table-middle">
                        <tbody>
                            <tr>
                                <th width="200">@lang('orders::orders.attributes.id')</th>
                                <td>{{ $order->id }}</td>
                            </tr>

                            <tr>
                                <th width="200">@lang('orders::orders.attributes.statuses.status')</th>
                                <td>{{ $order->status }}</td>
                            </tr>

                            @if ($order->status == 'cancelled')
                                <tr>
                                    <th width="200">@lang('orders::orders.attributes.reason')</th>
                                    <td>{{ $order->reason ?? '---' }}</td>
                                </tr>

                                <tr>
                                    <th width="200">@lang('orders::orders.attributes.is_refunded')</th>
                                    <td>

                                        @include('dashboard::layouts.apps.flag', [
                                            'bool' => $order->is_refunded,
                                        ])

                                    </td>
                                </tr>
                            @endif

                            <tr>
                                <th width="200">@lang('accounts::user.singular')</th>
                                <td>
                                    <a href="{{ route('dashboard.users.show', $order->user) }}"
                                        class="text-decoration-none text-ellipsis">
                                        {{ $order->user->name }}
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <th width="200">@lang('orders::orders.attributes.sub_total')</th>
                                <td>{{ $order->subtotal }}</td>
                            </tr>

                            <tr>
                                <th width="200">@lang('orders::orders.attributes.tax_total')</th>
                                <td>{{ $order->tax }}</td>
                            </tr>

                            <tr>
                                <th width="200">@lang('orders::orders.attributes.total')</th>
                                <td>{{ $order->total }}</td>
                            </tr>

                            <tr>
                                <th width="200">@lang('orders::orders.attributes.created_at')</th>
                                <td>{{ date('Y-m-d h:i A', strtotime($order->created_at)) }}</td>
                            </tr>
                        </tbody>
                    </table>

                    @slot('footer')
                        {{-- @include('orders::orders.partials.actions.invoice') --}}
                    @endslot
                @endcomponent


                @if (auth()->user()->hasPermission('update_orders') && $order->isPending())
                    {{ BsForm::resource('orders::orders')->post(route('dashboard.orders.status', $order)) }}
                    @component('dashboard::layouts.components.accordion')
                        @slot('title', trans('orders::orders.actions.status'))
                        @include('dashboard::errors')

                        @include('orders::orders.partials.status')
                    @endcomponent
                    {{ BsForm::close() }}
                @endif


            </div>
            <div class="col-md-6">
                {{-- taxes table --}}
                @if (count($order->taxes) > 0)
                    @component('dashboard::layouts.components.accordion-table')
                        @slot('bodyClass', 'p-0')
                        @slot('title', trans('taxes::taxes.plural'))
                        <tr>
                            <th width="100">#</th>
                            <th>@lang('taxes::taxes.attributes.name')</th>
                            <th>@lang('taxes::taxes.attributes.percentage')</th>
                            <th>@lang('taxes::taxes.attributes.total')</th>
                        </tr>
                        @foreach ($order->taxes as $tax)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $tax->name }}</td>
                                <td>{{ $tax->percentage . ' %' }}</td>
                                <td>{{ ($tax->percentage * $order->subtotal) / 100 }}</td>
                            </tr>
                        @endforeach
                    @endcomponent
                @endif



                {{-- items table --}}
                @if (count($order->items) > 0)
                    @component('dashboard::layouts.components.accordion-table')
                        @slot('bodyClass', 'p-0')
                        @slot('title', trans('orders::orders.singular'))
                        <tr>
                            <th width="100">#</th>
                            <th>@lang('orders::orders.items.name')</th>
                            <th>@lang('orders::orders.items.quantity')</th>
                            <th>@lang('orders::orders.items.price')</th>
                            <th>@lang('orders::orders.items.color')</th>
                            <th>@lang('orders::orders.items.size')</th>
                            <th>@lang('orders::orders.items.vendor')</th>
                        </tr>
                        @foreach ($order->items as $orderItem)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $orderItem->product->name }}</td>
                                <td>{{ $orderItem->quantity }}</td>
                                <td>{{ $orderItem->price }}</td>
                                <td>{{ $orderItem->size->name }}</td>
                                <td>{{ $orderItem->color->name }}</td>
                                <td>{{ $orderItem->product->vendor->name }}</td>
                            </tr>
                        @endforeach
                    @endcomponent
                @endif


            </div>
        </div>
    @endcomponent
@endsection
