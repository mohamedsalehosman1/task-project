@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="accordion" id="accordionProduct">

    {{-- القسم الأول: المعلومات الأساسية --}}
    <div class="card">
        <div class="card-header" id="heading1">
            <h2 class="mb-0">
                <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse"
                    data-target="#collapse1" aria-expanded="true" aria-controls="collapse1">
                    # {{ __('Main Info') }}
                </button>
            </h2>
        </div>

        <div id="collapse1" class="collapse show" aria-labelledby="heading1" data-parent="#accordionProduct">
            <div class="card-body">

                @bsMultilangualFormTabs
                    {{ BsForm::text('name')->label(__('products::products.attributes.name')) }}
                    {{ BsForm::text('company_name')->label(__('products::products.attributes.company_name')) }}
                    {{ BsForm::textarea('description')->label(__('products::products.attributes.description'))->attribute('class', 'form-control textarea') }}
                @endBsMultilangualFormTabs

                <div class="row">
                    @if (auth()->user()->isVendor())
                        <input type="hidden" name="vendor_id" value="{{ auth()->user()->vendor_id }}">
                    @else
                        <div class="col">
                            {{ BsForm::select('vendor_id')->options($vendors)->label(__('vendors::vendors.singular'))->attribute(['class' => 'form-control selectpicker', 'data-live-search' => 'true'])->placeholder(__('Select one')) }}
                        </div>
                    @endif

                    <div class="col">
                        {{ BsForm::select('service_id')->options($services)->label(__('services::services.singular'))->attribute(['class' => 'form-control selectpicker', 'data-live-search' => 'true'])->placeholder(__('Select one')) }}
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-6">
                        {{ BsForm::number('old_price')->step(0.01)->value(old('old_price', optional($product ?? null)->old_price))->label(__('products::products.attributes.old_price')) }}
                    </div>

                    <div class="col-6">
                        {{ BsForm::number('price')->step(0.01)->value(old('price', optional($product ?? null)->price))->label(__('products::products.attributes.price')) }}
                    </div>
                </div>

                <div class="row my-3">
                    <div class="col-12">
                        {{ BsForm::checkbox('has_quantity_limit', 0)
                            ->value(optional($product ?? null)->has_quantity_limit ?? 0)
                            ->label(__('products::products.attributes.has_quantity_limit_label')) }}
                    </div>
                </div>

                <div class="row {{ optional($product ?? null)->has_quantity_limit ? '' : 'd-none' }}" id="quantity_time_fields">
                    <div class="col-md-6">
                        {{ BsForm::number('max_amount')->value(old('max_amount', optional($product ?? null)->max_amount ?? 0))->min(0)->label(__('products::products.attributes.max_amount')) }}
                    </div>

                    <div class="col-md-6">
                        {{ BsForm::text('base_preparation_time')->value(old('base_preparation_time', optional($product ?? null)->base_preparation_time))->label(__('products::products.attributes.base_preparation_time'))->attribute(['placeholder' => 'HH:MM:SS']) }}
                    </div>
                </div>

            </div>
        </div>
    </div>

    ---

    {{-- القسم الثاني: العناوين والمواقع --}}
    <div class="card mt-3">
        <div class="card-header" id="heading2">
            <h2 class="mb-0">
                <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse"
                    data-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
                    # {{ __('products::products.location_info') }}
                </button>
            </h2>
        </div>

        <div id="collapse2" class="collapse" aria-labelledby="heading2" data-parent="#accordionProduct">
            <div class="card-body">

                <div class="row">
                    <div class="col-md-6">
                        {{ BsForm::select('region_id')->options($regions)->value(old('region_id', optional($product ?? null)->region_id))->label(__('addresses::regions.singular'))->attribute(['class' => 'form-control selectpicker', 'data-live-search' => 'true', 'id' => 'region_id'])->placeholder(__('Select region')) }}
                    </div>

                    <div class="col-md-6">
                        {{ BsForm::select('addresses_ids[]')->options($addresses)->value(old('addresses_ids', optional($product ?? null)->addresses->pluck('id')->toArray() ?? []))->label(__('addresses::addresses.plural'))->attribute([
                                'class' => 'form-control selectpicker',
                                'id' => 'addresses_ids',
                                'multiple' => true,
                                'data-live-search' => 'true',
                            ])->placeholder(__('Select addresses')) }}
                    </div>
                </div>

                <hr>

                {{-- الخرائط --}}
                <div id="maps-wrapper" class="mt-3"></div>

            </div>
        </div>
    </div>

    ---

    {{-- القسم الثالث: الصور --}}
    <div class="card mt-3">
        <div class="card-header" id="heading3">
            <h2 class="mb-0">
                <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse"
                    data-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
                    # {{ __('Cover and Images') }}
                </button>
            </h2>
        </div>

        <div id="collapse3" class="collapse" aria-labelledby="heading3" data-parent="#accordionProduct">
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

                <div class="row mt-3">
                    <div class="col-12">
                        <label>{{ __('products::products.attributes.images') }}</label>

                        <div id="multi-dropify-wrapper">
                            @isset($product)
                                @foreach($product->images as $image)
                                    <div class="dropify-wrapper mb-3">
                                        <input type="file" name="images[]" class="dropify" data-allowed-file-extensions="jpg jpeg png" />
                                        <button type="button" class="btn btn-danger btn-sm remove-dropify mt-2 d-none">{{ __('Remove') }}</button>
                                    </div>
                                @endforeach
                            @else
                                <div class="dropify-wrapper mb-3">
                                    <input type="file" name="images[]" class="dropify" data-allowed-file-extensions="jpg jpeg png" />
                                    <button type="button" class="btn btn-danger btn-sm remove-dropify mt-2 d-none">{{ __('Remove') }}</button>
                                </div>
                            @endisset
                        </div>

                        <button type="button" id="add-dropify" class="btn btn-primary btn-sm mt-3">
                            + {{ __('Add another image') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    ---

    {{-- القسم الرابع: مواعيد العمل --}}
    <div class="card mt-3">
        <div class="card-header" id="heading4">
            <h2 class="mb-0">
                <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse"
                    data-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
                    # {{ __('Working Hours') }}
                </button>
            </h2>
        </div>

        <div id="collapse4" class="collapse" aria-labelledby="heading4" data-parent="#accordionProduct">
            <div class="card-body">

                <div class="form-group">
                    <div class="form-check">
                        <input type="hidden" name="enable_working_hours" value="0">
                        <input type="checkbox" class="form-check-input" id="enable_working_hours"
                            name="enable_working_hours" value="1" {{ optional($product ?? null)->workingHours->count() ? 'checked' : '' }}>
                        <label class="form-check-label"
                            for="enable_working_hours">{{ __('تفعيل مواعيد العمل') }}</label>

                    </div>
                </div>

                <div id="working_hours_section" class="{{ optional($product ?? null)->workingHours->count() ? '' : 'd-none' }}">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>{{ __('اليوم') }}</th>
                                <th>{{ __('من الساعة') }}</th>
                                <th>{{ __('إلى الساعة') }}</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="working_hours_table">
                            @isset($product)
                                @foreach($product->workingHours as $wh)
                                    <tr>
                                        <td>
                                            <select name="working_hours[day][]" class="form-control">
                                                @foreach(['saturday'=>'السبت','sunday'=>'الأحد','monday'=>'الاثنين','tuesday'=>'الثلاثاء','wednesday'=>'الأربعاء','thursday'=>'الخميس','friday'=>'الجمعة'] as $val=>$text)
                                                    <option value="{{ $val }}" {{ $wh->day == $val ? 'selected' : '' }}>{{ $text }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td><input type="time" name="working_hours[from][]" class="form-control" value="{{ $wh->from }}" required></td>
                                        <td><input type="time" name="working_hours[to][]" class="form-control" value="{{ $wh->to }}" required></td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-danger btn-sm remove-working-hour"><i class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                            @endisset
                        </tbody>
                    </table>

                    <button type="button" id="add_working_hour" class="btn btn-primary btn-sm">
                        + {{ __('إضافة موعد آخر') }}
                    </button>
                </div>
            </div>
        </div>
    </div>

</div>

@push('js')
<script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=places"></script>
<script src="{{ asset('dashboard_assets/plugins/dropify/js/dropify.min.js') }}"></script>

<script>
// Keep simple jQuery/DOM ready outside @verbatim if it uses Blade variables.
$(document).ready(function() {
    // ... (rest of the document.ready function)
});

// ==================== خرائط Google ====================

// This line must remain outside @verbatim because it uses Blade's @json
var oldAddresses = @json(optional($product ?? null)->addresses->map(function($a){ return array('id' => $a->id, 'latitude' => $a->pivot->latitude ?? null, 'longitude' => $a->pivot->longitude ?? null, 'range' => $a->pivot->range ?? null); }));

let mapInstances = {};

$('#addresses_ids').on('changed.bs.select', function() {
    updateMaps();
});

// Start @verbatim here to protect the complex JavaScript functions
@verbatim
function updateMaps() {
    const wrapper = document.getElementById('maps-wrapper');
    const selectedIds = $('#addresses_ids').val() || [];

    const selectedIdsNum = selectedIds.map(Number);
    Object.keys(mapInstances).forEach(id => {
        if (!selectedIdsNum.includes(Number(id))) {
            document.getElementById(`card-${id}`)?.remove();
            delete mapInstances[id];
        }
    });

    selectedIds.forEach(addressId => {
        if (mapInstances[addressId]) return;

        const oldData = oldAddresses.find(a => a.id == addressId) || {};
        const latValue = oldData.latitude ?? 24.7136;
        const longValue = oldData.longitude ?? 46.6753;
        const rangeValue = oldData.range ?? 0;

        const addressName = $(`#addresses_ids option[value="${addressId}"]`).text();
        const mapContainerId = `map-${addressId}`;
        const latInputId = `lat-${addressId}`;
        const longInputId = `long-${addressId}`;
        const rangeInputId = `range-${addressId}`;

        const cardHtml = `
        <div class="card mb-4" id="card-${addressId}">
            <div class="card-header bg-light"><strong>${addressName}</strong></div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label>Latitude</label>
                        <input type="text" readonly class="form-control" id="${latInputId}_show" value="${latValue}">
                        <input type="hidden" name="latitudes[${addressId}]" id="${latInputId}" value="${latValue}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Longitude</label>
                        <input type="text" readonly class="form-control" id="${longInputId}_show" value="${longValue}">
                        <input type="hidden" name="longitudes[${addressId}]" id="${longInputId}" value="${longValue}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Range (km)</label>
                        <input type="number" name="ranges[${addressId}]" id="${rangeInputId}" value="${rangeValue}">
                    </div>
                </div>
                <div id="${mapContainerId}" style="width:100%;height:400px;"></div>
            </div>
        </div>`;

        wrapper.insertAdjacentHTML('beforeend', cardHtml);

        initSingleMap(addressId, mapContainerId, latInputId, longInputId, rangeInputId, latValue, longValue, rangeValue);
    });
}

function initSingleMap(addressId, mapId, latInputId, longInputId, rangeInputId, defaultLat, defaultLng, defaultRange) {
    const defaultLatLng = {lat: parseFloat(defaultLat), lng: parseFloat(defaultLng)};
    const map = new google.maps.Map(document.getElementById(mapId), { zoom: 8, center: defaultLatLng });
    const marker = new google.maps.Marker({ position: defaultLatLng, map: map, draggable: true });
    let circle = new google.maps.Circle({
        map: map,
        center: defaultLatLng,
        radius: parseFloat(defaultRange)*1000 || 0,
        fillColor: '#2196F3',
        fillOpacity: 0.2,
        strokeColor: '#1565C0',
        strokeOpacity: 0.5,
        strokeWeight: 2
    });

    marker.addListener('drag', function(e) {
        const pos = e.latLng;
        document.getElementById(latInputId).value = pos.lat();
        document.getElementById(latInputId+'_show').value = pos.lat();
        document.getElementById(longInputId).value = pos.lng();
        document.getElementById(longInputId+'_show').value = pos.lng();
        circle.setCenter(pos);
    });

    document.getElementById(rangeInputId).addEventListener('input', function() {
        const radius = parseFloat(this.value)*1000 || 0;
        circle.setRadius(radius);
    });

    mapInstances[addressId] = {map, marker, circle};
}
@endverbatim // End @verbatim here

updateMaps();
</script>
@endpush
