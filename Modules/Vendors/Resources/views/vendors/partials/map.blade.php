@isset($vendor)
    @if (($vendor->lat != null) & ($vendor->long != null))
        <div class="form-group mt-3">
            <label for="address">
                {{ __('vendors::vendors.attributes.map') }}
            </label>
            <input type="text" id="address-input" name="address" class="form-control map-input"
                value="{{ $vendor->address }}">
            <input type="hidden" name="lat" id="address-latitude" value="{{ $vendor->lat }}" />
            <input type="hidden" name="long" id="address-longitude" value="{{ $vendor->long }}" />
        </div>
        <div id="address-map-container" style="width:100%;height:400px; ">
            <div style="width: 100%; height: 100%" id="address-map"></div>
        </div>
    @else
        <div class="form-group mt-3">
            <label for="address">
                {{ __('vendors::vendors.attributes.map') }}
            </label>
            <input type="text" id="address-input" name="address" class="form-control map-input">
            <input type="hidden" name="lat" id="address-latitude" value="0" />
            <input type="hidden" name="long" id="address-longitude" value="0" />
        </div>
        <div id="address-map-container" style="width:100%;height:400px; ">
            <div style="width: 100%; height: 100%" id="address-map"></div>
        </div>
    @endif
@else
    <div class="form-group mt-3">
        <label for="address">
            {{ __('vendors::vendors.attributes.map') }}
        </label>
        <input type="text" id="address-input" name="address" class="form-control map-input">
        <input type="hidden" name="lat" id="address-latitude" value="0" />
        <input type="hidden" name="long" id="address-longitude" value="0" />
    </div>
    <div id="address-map-container" style="width:100%;height:400px; ">
        <div style="width: 100%; height: 100%" id="address-map"></div>
    </div>
@endisset


@push('js')
    <script
        src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=places,marker&callback=initialize"
        async defer></script>

    <script src="{{ asset('js/map.js') }}"></script>
@endpush
