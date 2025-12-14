@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@php
    use Modules\Services\Entities\Price;
@endphp

@if (isset($vendorService))
    <input type="hidden" id='has_express' value="{{ $has_express }}" name="">
@endif

@isset($vendorService)
    <input type="hidden" name="vendor_id" value="{{ $vendorService->vendor->id }}">
    <input type="hidden" name="service_id" value="{{ $vendorService->service_id }}">
@endisset


<div class="row">
    @if (auth()->user()->isVendor())
    @else
        <div class="col-4">
            {{ BsForm::select('vendor_id')->options($vendors)->label(__('vendors::vendors.singular'))->attribute(['id' => 'vendor_id', 'data_step' => '1', 'class' => 'form-control main-select vendor_div'])->placeholder(__('Select one')) }}
        </div>
    @endif


    @include('dashboard::layouts.components.ajax', [
        'step' => '2',
        'action' => 'vendor',
        'trans' => 'services::services.singular',
        'selector' => 'service',
        'data_addition' => isset($data_addition) ? $data_addition : [],
        'required' => true,
        'multiple' => false,
        'class' => isset($vendorService) || old('service_id') || auth()->user()->isVendor() ? 'col' : 'd-none col',
        'options' => isset($services) ? $services : [],
        'chosenOptionIds' => isset($vendorService) ? [$vendorService->service_id] : [],
        'routeUrl' => 'api/select/services/get-new-vendor-services',
    ])


    @include('dashboard::layouts.components.ajax', [
        'step' => '3',
        'action' => 'service',
        'trans' => 'items::items.plural',
        'selector' => 'item',
        'required' => true,
        'multiple' => true,
        'class' => isset($vendorService) || old('item_id') ? 'col' : 'd-none col',
        'options' => isset($vendorService)
            ? $vendorService->service->items()->listsTranslations('name')->pluck('name', 'id')->toArray()
            : [],
        'chosenOptionIds' => isset($vendorService) ? $vendorService->prices()->pluck('item_id')->toArray() : [],
        'routeUrl' => 'api/select/get-service-items',
    ])

    <div class="row w-100" id="vir-prices">
        @if(isset($vendorService) && is_null(old('prices')) )
            @foreach ($vendorService->prices as $price)
                <div class="col-6 select-{{ $price->item_id }}">
                    {{ BsForm::number("prices[$price->item_id]")->min($price->offerPrice ?? 1)->step(0.01)->value($price->price)->label($price->label)->attribute(['data-parsley-type' => 'number'])->required() }}
                </div>
                @if ($vendorService->service->has_express)
                    <div class="col-6 select-{{ $price->item_id }}">
                        {{ BsForm::number("express_prices[$price->item_id]")->min($price->price)->step(0.01)->value($price->express_price)->label($price->item->name . ' ' . trans('services::services.attributes.express_price'))->attribute(['data-parsley-type' => 'number'])->required() }}
                    </div>
                @endif
            @endforeach
        @endif


        @if (old('prices'))
            @php
                $items = json_decode(old('item_options'), true);
            @endphp

            @foreach (old('prices') as $id => $value)
                @php
                    $basicLabel = $items[$id] . ' ' . trans('services::services.attributes.price');
                    $price = Price::find($id);
                    $label = isset($vendorService) ? $price?->label : $basicLabel;
                    $min = isset($vendorService) ? $price->offerPrice : 1;
                @endphp

                <div class="col-6 select-{{ $id }}">
                    {{ BsForm::number("prices[$id]")->min($min)->step(0.01)->value($value)->label($label)->attribute(['data-parsley-type' => 'number'])->required() }}
                </div>

                @if (data_get(old('express_prices'), $id, false))
                    <div class="col-6 select-{{ $id }}">
                        {{ BsForm::number("express_prices[$id]")->min($value)->step(0.01)->value(data_get(old('express_prices'), $id, null))->label($items[$id] . ' ' . trans('services::services.attributes.express_price'))->attribute(['data-parsley-type' => 'number'])->required() }}
                    </div>
                @endif
            @endforeach

        @endif
    </div>


</div>

@push('js')
    <script>
        var url = window.location.origin;

        has_express = $('has_express').val() ?? false

        $(document).ready(function() {
            $("#service_id").select2();
        });

        var vendorService = @json($vendorService ?? null);

        if (vendorService) {
            $('#vendor_id , #service_id').attr('disabled', 'disabled');
        }

        $('#service_id').on('select2:select select2:unselect', function(e) {
            has_express = JSON.parse(e.params.data.element.attributes.data_addition.value).has_express;
        });

        $('#item_id').on('select2:select select2:unselect', function(e) {
            data = e.params.data;
            id = data.id;
            name = data.text;
            if (data.selected) {

                price = `<div class='col-6 select-${id}'>
                                <div class="form-group">
                                    <label for="prices[${id}]">${name} {{ ' ' . trans('services::services.attributes.price') }} </label>
                                    <input data-parsley-type="number" name="prices[${id}]" type="number" min="1" step=".01" value="" id="prices[${id}]" class="form-control" required >
                                    <small class="form-text text-muted"></small>
                                </div>
                                </div>`;

                express_price = `<div class='col-6 select-${id}'>
                    <div class="form-group">
                        <label for="express_prices[${id}]">${name} {{ ' ' . trans('services::services.attributes.express_price') }} </label>
                        <input data-parsley-type="number" name="express_prices[${id}]" type="number" min="1" step=".01" value="" id="express_prices[${id}]" class="form-control" required >
                        <small class="form-text text-muted"></small>
                        </div>
                        </div>`;

                $result = has_express ? price + express_price : price;

                $('#vir-prices').append($result)

            } else {
                $(`#vir-prices  .select-${id}`).remove()
            }

        });

        $('#service_id,#vendor_id').on('change', function(e) {
            $('#vir-prices').empty();
        });
    </script>
@endpush
