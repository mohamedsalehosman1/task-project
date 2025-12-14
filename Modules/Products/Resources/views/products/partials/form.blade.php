@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


<div class="accordion" id="accordionExample">

    <div class="card">
        <div class="card-header" id="heading1">
            <h2 class="mb-0">
                <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse"
                    data-target="#collapse1" aria-expanded="true" aria-controls="collapse1">
                    # {{ __('Main Info') }}
                </button>
            </h2>
        </div>

        <div id="collapse1" class="collapse" aria-labelledby="heading1" data-parent="#accordionExample">

            <div class="card-body">


@multilingualFormTabs
                    {{ BsForm::text('name')->attribute(['data-parsley-maxlength' => '191', 'data-parsley-minlength' => '3']) }}
                    {{ BsForm::textarea('description')->attribute('class', 'form-control textarea') }}
@endMultilingualFormTabs

                <div class="row">

                    @if (auth()->user()->isVendor())
                        <input type="hidden" name="vendor_id" value="{{ auth()->user()->vendor_id }}">
                    @else
                        <div class="col">

                            {{ BsForm::select('vendor_id')->options($vendors)->label(__('vendors::vendors.singular'))->attribute(['class' => 'form-control selectpicker', 'data-live-search' => 'true'])->placeholder(__('Select one')) }}
                        </div>
                    @endif

                    <div class="col">

                        {{ BsForm::select('service_id')->options($services)->label(__('services::services.plural'))->attribute(['class' => 'form-control selectpicker', 'data-live-search' => 'true'])->placeholder(__('Select one')) }}
                    </div>

                </div>

                @php
                    $hasOfferPrice = '';
                    $price_min = 0.01;
                    if (isset($product)) {
                        $price_min = $product->offerPrice ?? 0.01;
                        $hasOfferPrice = $product->offerPrice ? '_with_offer' : '';
                        $old_price_min = $product->price;
                    }
                @endphp

                <div class="row">
                    <div class="col-6">
                        {{ BsForm::number('old_price')->step(0.01)->min(isset($old_price_min) ? $old_price_min : 0.01)->attribute(['data-parsley-type' => 'number']) }}
                    </div>

                    <div class="col-6">
                        {{ BsForm::number('price')->step(0.01)->min(isset($price_min) ? $price_min : 0.01)->label(__("products::products.attributes.price$hasOfferPrice", ['price' => $price_min]))->attribute(['data-parsley-type' => 'number']) }}
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        {{ BsForm::text('made_in')->attribute(['data-parsley-maxlength' => '191', 'data-parsley-minlength' => '3']) }}

                    </div>
                    <div class="col">

                        {{ BsForm::checkbox('is_recommended') }}
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>


<div class="accordion" id="accordionExample">

    <div class="card">
        <div class="card-header" id="heading3">
            <h2 class="mb-0">
                <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse"
                    data-target="#collapse3" aria-expanded="true" aria-controls="collapse3">
                    # {{ __('Cover and Images') }}
                </button>
            </h2>
        </div>

        <div id="collapse3" class="collapse" aria-labelledby="heading3" data-parent="#accordionExample">
            <div class="card-body">

                <div class="row">
                    <div class="col-12">
                        <label>{{ __('products::products.attributes.cover') }}</label>
                        @isset($product)
                            @include('dashboard::layouts.apps.file', [
                                'file' => $product->cover,
                                'name' => 'cover',
                                'mimes' => 'png jpg jpeg',
                            ])
                        @else
                            @include('dashboard::layouts.apps.file', ['name' => 'cover'])
                        @endisset
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <label>{{ __('products::products.attributes.images') }}</label>
                        @if (isset($product))
                            @include('dashboard::layouts.apps.multi', [
                                'name' => 'images[]',
                                'images' => $product->getImages(),
                            ])
                        @else
                            @include('dashboard::layouts.apps.multi', ['name' => 'images[]'])
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>



<div class="accordion" id="accordionExample">

    <div class="card">
        <div class="card-header" id="heading4">
            <h2 class="mb-0">
                <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse"
                    data-target="#collapse4" aria-expanded="true" aria-controls="collapse4">
                    # {{ __('Material Info') }}
                </button>
            </h2>
        </div>

        <div id="collapse4" class="collapse" aria-labelledby="heading4" data-parent="#accordionExample">

            <div class="card-body">



                <div data-repeater-list="material">
                    @if (isset($product) && $product->materials)
                        @foreach ($product->materials as $material)
                            <div data-repeater-item>
                                <div class="row my-2">
                                    <div class="col-11">
                                        {{ BsForm::text('material')->required()->value($material->material)->attribute(['data-parsley-maxlength' => '191', 'data-parsley-minlength' => '3']) }}
                                    </div>
                                    <div class="col-1">
                                        <button type="button" data-repeater-delete class="btn btn-danger">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div data-repeater-item>
                            {{ BsForm::text('material')->required()->attribute(['data-parsley-maxlength' => '191', 'data-parsley-minlength' => '3']) }}
                        </div>
                    @endif
                </div>
                <button type="button" data-repeater-create class="btn btn-primary my-2">
                    <i class="fa fa-plus"></i>
                </button>




            </div>
        </div>
    </div>
</div>
