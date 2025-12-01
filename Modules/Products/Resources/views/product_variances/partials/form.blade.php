@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

{!! Form::hidden('product_id', request()?->product?->id) !!}

@isset($productVariance)
    {!! Form::hidden('size_id', $productVariance?->size_id) !!}
@endisset

<div class="col col-4">
    <select2 name="size_id" disable="{{ isset($productVariance) }}" label="@lang('sizes::sizes.singular')"
        placeholder="{{ __('Select one') }}"
        remote-url="{{ route('sizes.select.by-product', isset($productVariance) ? 'haha' : $product->id) }}"
        @isset($productVariance)
             :value="{{ $productVariance->size_id }}"
        @endisset
        :required="true"></select2>
</div>

@php
    use Modules\Colors\Entities\Color;
    $selectedColorsArray = isset($productVariance)
        ? $productVariance->product->productVariances()->whereSizeId($productVariance->size_id)->distinct('color_id')->pluck('color_id')->toArray()
        : [];

    $selectedColors = Color::whereIn('colors.id', $selectedColorsArray)
        ->listsTranslations('name')
        ->pluck('name', 'id')
        ->toArray();
@endphp


<div class="col-12">
    <label>{{ __('colors::colors.plural') }}</label>
    <div class="row">

        <select name="colors[]" class="form-control selectpicker" data-live-search="true" multiple id="colors"
            required>
            @foreach ($colors as $id => $color)
                <option @if (in_array($id, $selectedColorsArray ?? [])) selected @endif value="{{ $id }}">
                    {{ $color }} </option>
            @endforeach
        </select>

        <div class="row mt-2" id="vir-colors">
            @isset($selectedColors)
                @foreach ($selectedColors as $id => $color)
                    <div class="col-6 select-{{ $id }}">
                        {{ BsForm::number("quantity[$id]")->value(isset($productVariance) ? $productVariance->getQuantity($id) : old("quantity[$id]"))->min(1)->step(1)->label($color . ' ' . trans('products::products.attributes.quantity'))->attribute(['data-parsley-type' => 'number']) }}
                    </div>
                @endforeach
            @endisset
        </div>
    </div>
</div>



@push('js')
    <script>
        var url = window.location.origin;

        $('#colors').on('changed.bs.select', function(e, clickedIndex, isSelected, previousValue) {

            selected = $(e.target).children()[clickedIndex];
            name = $(selected).html();
            id = $(selected).val();

            if (isSelected) {

                $('#vir-colors').append(`

                <div class='col-6 select-${id}'>
                    <div class="form-group">
                        <label for="quantity[${id}]">{{ trans('products::products.attributes.quantity') }} ${name} </label>
                        <input data-parsley-type="number" name="quantity[${id}]" min="1" step="1" required type="number" value=""
                            id="quantity[${id}]" class="form-control" >
                        <small class="form-text text-muted"></small>
                    </div>
                </div>`)

            } else {
                $(`#vir-colors  .select-${id}`).remove()
            }

        });
    </script>
@endpush
