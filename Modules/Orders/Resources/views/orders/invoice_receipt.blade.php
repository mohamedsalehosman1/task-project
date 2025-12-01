<!DOCTYPE html>
<html dir="{{ Locales::getDir() }}" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@lang('orders::orders.invoice_details.print-receipt')</title>
    <link rel="stylesheet" href="{{ asset('backend/css/print.css') }}" />
</head>

<body>
    <div>
        {{--    <button type="button" class="print-receipt-btn"> --}}
        {{--        @lang('orders::orders.invoice_details.print-receipt') --}}
        {{--    </button> --}}
    </div>
    <div id="print-receipt-holder">
        @php
            $kt_logo_image = 'Logo-Horizontal@1x.png';
            \Date::setLocale(app()->getLocale());
            $date = \Date::createFromDate($order->created_at)->format('l j F Y');
        @endphp
        <div id="print-receipt-area">
            <div class="receipt-header">
                <img class="store-logo" src="{{ app_logo() ?? asset('backend/images/logos/' . $kt_logo_image) }}" />
                <p class="store-title">
                    >{{ \Laraeast\LaravelSettings\Facades\Settings::get('name:' . app()->getLocale()) ?? config('app.name') }}
                </p>
                <p class="store-phone">{{ \Laraeast\LaravelSettings\Facades\Settings::get('phone', null) }}</p>
                <p class="store-email">{{ \Laraeast\LaravelSettings\Facades\Settings::get('email', null) }}</p>
                <p class="invoice-num">@lang('orders::orders.invoice_details.title', ['order_id' => $order->id])</p>
            </div>
            <table class="receipt-table">
                <tbody>
                    <tr class="b-bottom">
                        <td class="p-t-b-1mm w-50">@lang('orders::orders.invoice_details.date')</td>
                        <td class="p-t-b-1mm w-50 ta-end fw-bold">{{ $date }}</td>
                    </tr>
                    <tr class="b-bottom">
                        <td class="p-t-b-1mm w-50">@lang('orders::orders.invoice_details.order_number')</td>
                        <td class="p-t-b-1mm w-50 ta-end fw-bold">{{ $order->id }}</td>
                    </tr>
                    <tr class="b-bottom">
                        <td class="p-t-b-1mm w-50">@lang('orders::orders.invoice_details.order_payment_type')</td>
                        <td class="p-t-b-1mm w-50 ta-end fw-bold">
                            {{ optional($order->payment)->name }}
                        </td>
                    </tr>
                    <tr>
                        <td class="p-t-b-1mm w-50">@lang('orders::orders.invoice_details.order_address')</td>
                        <td class="p-t-b-1mm w-50 ta-end fw-bold">
                            {{ optional($order->customer)->name }}
                            <br />{{ optional($order->customer)->phone }} <br />
                            {{ optional($order->address)->address }},
                            {{ optional(optional($order->address)->region)->name }},
                            {{ optional(optional($order->address)->city)->name }},
                            {{ optional(optional(optional($order->address)->city)->country)->name }}
                        </td>
                    </tr>
                </tbody>
            </table>

            <div class="row justify-content-center py-8 px-8 py-md-10 px-md-0">
                <div class="col-md-9">
                    <h2>@lang('services::services.singular')</h2>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="pl-0 font-weight-bold text-uppercase">@lang('services::services.attributes.name')</th>
                                    <th class="text-right font-weight-bold text-uppercase">@lang('additions::additions.attributes.price')</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="font-weight-boldest">
                                    <td class="pl-0 pt-7">{{ $order->service->name }}</td>
                                    <td class="text-right pt-7">{{ $order->service_price }}</td>
                                </tr>
                            </tbody>
                        </table>

                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="pl-0 font-weight-bold text-uppercase">@lang('additions::additions.attributes.name')</th>
                                    <th class="text-right font-weight-bold text-uppercase">@lang('additions::additions.attributes.quantity')</th>
                                    <th class="text-right font-weight-bold text-uppercase">@lang('additions::additions.attributes.price')</th>
                                    <th class="text-right pr-0 font-weight-bold text-uppercase">@lang('additions::additions.attributes.total')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->orderAdditions as $orderAddition)
                                    <tr class="font-weight-boldest">
                                        <td class="pl-0 pt-7">{{ $orderAddition->addition->name }}</td>
                                        <td class="text-right pt-7">{{ $orderAddition->quantity }}</td>
                                        <td class="text-right pt-7">{{ $orderAddition->price . ' ₺' }}</td>
                                        <td class="text-danger pr-0 pt-7 text-right">{{ $orderAddition->total . ' ₺' }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>


                        <table class="w-100 b-top b-bottom receipt-table">
                            <tbody>
                                <tr>
                                    <td class="w-50 ta-start">@lang('orders::orders.attributes.sub_total'):</td>
                                    <td class="w-50 ta-end fw-bold">{{ $order->subtotal . ' ₺' }}</td>
                                </tr>
                                <tr>
                                    <td class="w-50 ta-start">@lang('orders::orders.attributes.shipping_cost'):</td>
                                    <td class="w-50 ta-end fw-bold">{{ $order->shipping_cost . ' ₺' }}</td>
                                </tr>
                                <tr>
                                    <td class="w-50 ta-start">@lang('orders::orders.attributes.tax_total'):</td>
                                    <td class="w-50 ta-end fw-bold">{{ $order->tax_total . ' ₺' }}</td>
                                </tr>
                                <tr>
                                    <td class="w-50 ta-start">@lang('orders::orders.attributes.discount'):</td>
                                    <td class="w-50 ta-end fw-bold">{{ $order->discount . ' ₺' }}</td>
                                </tr>
                                <tr class="b-top b-bottom total-row">
                                    <td class="w-50 ta-start fw-bold p-t-b-1mm">@lang('orders::orders.attributes.total'):</td>
                                    <td class="w-50 ta-end fw-bolder p-t-b-1mm">{{ $order->total . ' ₺' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/printThis/1.15.0/printThis.js"></script>
                <script type="text/javascript">
                    // $(document).on('click', '.print-receipt-btn', function (e) {
                    //     e.preventDefault();
                    //     $('#print-receipt-holder').printThis();
                    // });
                    $(document).ready(function() {
                        window.print();
                        // window.onafterprint = window.close;
                    })
                </script>
</body>

</html>
