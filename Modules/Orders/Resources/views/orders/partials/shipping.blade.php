@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<select2 name="shipping_company_id"
         label="@lang('shipping::shippingCompanies.attributes.name')"
         remote-url="{{ route('companies.select',$order->address->city->id) }}"
         value="{{ $order->shipping_company_id ?? old('shipping_company_id') }}"
></select2>

{{ BsForm::textarea('shipping_company_notes')->rows(3)->attribute('class','form-control') }}

