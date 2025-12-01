<div class="form-group mt-3">
    <label for="addresses_ids">{{ __('products::products.attributes.map') }}</label>
    <p class="text-muted">{{ __('اختر العناوين لعرض خريطة لكل عنوان') }}</p>
</div>

<div id="maps-wrapper" class="mt-3"></div>

@push('js')
<script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=places"></script>
<script>
    let mapInstances = {};

    // عند تغيير اختيار العناوين
    $('#addresses_ids').on('changed.bs.select', function () {
        updateMaps();
    });

    function updateMaps() {
        const wrapper = document.getElementById('maps-wrapper');
        const selectedIds = $('#addresses_ids').val() || [];

        // أولاً: احذف أي خريطة لم تعد مختارة
        Object.keys(mapInstances).forEach(id => {
            if (!selectedIds.includes(id)) {
                document.getElementById(`card-${id}`)?.remove();
                delete mapInstances[id];
            }
        });

        // ثانياً: أضف الخرائط الجديدة فقط
        selectedIds.forEach(addressId => {
            if (mapInstances[addressId]) return; // لو الخريطة دي موجودة بالفعل، سيبها

            const addressName = $(`#addresses_ids option[value="${addressId}"]`).text();
            const mapContainerId = `map-${addressId}`;
            const latInputId = `lat-${addressId}`;
            const longInputId = `long-${addressId}`;

            const cardHtml = `
                <div class="card mb-4" id="card-${addressId}">
                    <div class="card-header bg-light">
                        <strong>${addressName}</strong>
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label>{{ __('Latitude') }}</label>
                            <input type="text" readonly class="form-control" id="${latInputId}_show">
                            <input type="hidden" name="latitudes[${addressId}]" id="${latInputId}">
                        </div>
                        <div class="form-group mb-3">
                            <label>{{ __('Longitude') }}</label>
                            <input type="text" readonly class="form-control" id="${longInputId}_show">
                            <input type="hidden" name="longitudes[${addressId}]" id="${longInputId}">
                        </div>
                        <div id="${mapContainerId}" style="width:100%;height:400px;"></div>
                    </div>
                </div>
            `;
            wrapper.insertAdjacentHTML('beforeend', cardHtml);

            initSingleMap(mapContainerId, latInputId, longInputId);
        });
    }

    function initSingleMap(mapId, latInputId, longInputId) {
        const defaultLatLng = { lat: 24.7136, lng: 46.6753 }; // موقع افتراضي (الرياض)

        const map = new google.maps.Map(document.getElementById(mapId), {
            zoom: 8,
            center: defaultLatLng
        });

        const marker = new google.maps.Marker({
            position: defaultLatLng,
            map: map,
            draggable: true
        });

        // تحديث الإحداثيات عند سحب الماركر
        google.maps.event.addListener(marker, 'dragend', function(event) {
            const lat = event.latLng.lat();
            const lng = event.latLng.lng();

            document.getElementById(latInputId).value = lat;
            document.getElementById(longInputId).value = lng;

            document.getElementById(latInputId + '_show').value = lat;
            document.getElementById(longInputId + '_show').value = lng;
        });

        // حفظها داخل المصفوفة
        mapInstances[mapId.replace('map-', '')] = map;
    }

    $(document).ready(function() {
        updateMaps();
    });
</script>
@endpush
