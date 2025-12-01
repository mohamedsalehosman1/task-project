<!-- App js -->
<script src="{{ asset(mix('js/backend.js')) }}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.map.map_key') }}&libraries=places"
async defer></script>

<!-- JAVASCRIPT -->
@stack('js')
