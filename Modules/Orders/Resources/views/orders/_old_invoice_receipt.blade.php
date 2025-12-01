<div class="billbox" id="print-receipt-area"
     style="margin: 0.5mm;background-color: #fff;color: #000">
    <div style="text-align: center;margin: 0 0 30px;">
        <img width="200"
             src="{{ \Modules\Settings\Entities\Setting::first() ? \Modules\Settings\Entities\Setting::first()->getFirstMediaUrl('logo') : asset('backend/images/logos/'.$kt_logo_image) }}"
             alt="">
        <p style="margin:0 0 5px;font-size: 15px;">{{  \Modules\Settings\Entities\Setting::get('name:' . app()->getLocale()) ?? config('app.name') }}</p>
        <p style="margin:0 0 5px;font-size: 15px;direction:ltr;">{{  \Modules\Settings\Entities\Setting::get('phone',null) }}</p>
        <p style="margin:0 0 5px;font-size: 15px;">{{  \Modules\Settings\Entities\Setting::get('email',null) }}</p>
        <p style="margin:0 0 5px;font-size: 15px;font-weight: bold;">@lang('orders::orders.invoice_details.title',['order_id' => $order->id])</p>
    </div>
    <table style="width: 85%;margin: 15px;padding: 0 0 10px 0;">
        <tr style=";border-bottom: 1px dashed #000;">
            <td style="width: 40%;">@lang('orders::orders.invoice_details.date')</td>
            <td style="width: 60%;text-align: right;">{{ $date }}</td>
        </tr>
        <tr style=";border-bottom: 1px dashed #000;">
            <td style="width: 40%;">@lang('orders::orders.invoice_details.order_number')</td>
            <td style="width: 60%;text-align: right;">{{ $order->id }}</td>
        </tr>
        <tr style=";border-bottom: 1px dashed #000;">
            <td style="width: 40%;">@lang('orders::orders.invoice_details.order_payment_type')</td>
            <td style="width: 60%;text-align: right;">{{ optional($order->payment)->name }}</td>
        </tr>
        <tr>
            <td style="width: 40%;">@lang('orders::orders.invoice_details.order_address')</td>
            <td style="width: 60%;text-align: right;">
                {{ optional($order->customer)->name }}
                <br>{{ optional($order->customer)->phone }}
                <br>{{ optional($order->address)->address }}, {{ optional(optional($order->address)->region)->name }}
                , {{ optional(optional($order->address)->city)->name }}
                , {{ optional(optional(optional($order->address)->city)->country)->name }}
            </td>
        </tr>
    </table>
    <table
        style="width: 85%;margin: 15px;border-top: 1px dashed #000;border-bottom: 1px dashed #000;padding: 10px 0;text-align: center;">
        <thead style="border-bottom: 1px dashed #000;">
        <tr>
            <th style="width: 40%;font-size:14px;">@lang('orders::orders.attributes.products.print.receipt_name')</th>
            <th style="width: 20%;">@lang('orders::orders.attributes.products.print.receipt_quantity')</th>
            <th style="width: 25%;">@lang('orders::orders.attributes.products.print.receipt_price')</th>
            <th style="width: 15%;">@lang('orders::orders.attributes.products.print.receipt_total')</th>
        </tr>
        </thead>
        <tbody>
        @foreach($order->products as $product)
            <tr>
                <td style="width: 40%;font-size:14px;">
                    {{ $product->product->name }}
                </td>
                <td style="width: 20%;">{{ $product->quantity }}</td>
                <td style="width: 25%;">{{ $product->price . ' ₺' }}</td>
                <td style="width: 15%;">{{ $product->quantity * $product->price . ' ₺' }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <table style="width: 85%;margin: 15px;padding: 0 0 10px 0;">
        <tr>
            <td style="width: 60%;">@lang('orders::orders.attributes.sub_total'):</td>
            <td style="width: 40%;text-align: right;">{{ $order->subtotal . ' ₺' }}</td>
        </tr>
        <tr>
            <td style="width: 60%;">@lang('orders::orders.attributes.shipping_cost'):</td>
            <td style="width: 40%;text-align: right;">{{ $order->shipping_cost . ' ₺' }}</td>
        </tr>
        <tr>
            <td style="width: 60%;">@lang('orders::orders.attributes.tax_total'):</td>
            <td style="width: 40%;text-align: right;">{{ $order->tax_total . ' ₺' }}</td>
        </tr>
        <tr>
            <td style="width: 60%;">@lang('orders::orders.attributes.discount'):</td>
            <td style="width: 40%;text-align: right;">{{ $order->discount . ' ₺' }}</td>
        </tr>
        <tr style="border-top: 1px dashed #000;">
            <td style="width: 70%;">@lang('orders::orders.attributes.total'):</td>
            <td style="width: 30%;text-align: right;">{{ $order->total . ' ₺' }}</td>
        </tr>
    </table>
</div>
