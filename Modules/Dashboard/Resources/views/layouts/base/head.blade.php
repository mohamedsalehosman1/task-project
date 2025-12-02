<!-- App css -->
@if(Locales::getDir() === 'rtl')
    <link href="{{ asset(mix('css/backend.css')) }}" rel="stylesheet">
    <link href="{{ asset(mix('css/backend.rtl.css')) }}" rel="stylesheet">
@else
    <link href="{{ asset(mix('css/backend.css')) }}" rel="stylesheet">
@endif


<style>
    td {
        vertical-align: middle !important;
    }
</style>

@stack('css')
