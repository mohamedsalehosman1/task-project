<!-- App css -->
@if(Locales::getDir() === 'rtl')
    <link href="{{ asset(mix('css/backend.rtl.css'))}}" id="app-light" rel="stylesheet" type="text/css" />
    {{-- <link href="https://unpkg.com/dropzone@6.0.0-beta.1/dist/dropzone.css" rel="stylesheet" type="text/css" /> --}}
@else
    <link href="{{ asset(mix('css/backend.css'))}}" id="app-light" rel="stylesheet" type="text/css" />
    {{-- <link href="https://unpkg.com/dropzone@6.0.0-beta.1/dist/dropzone.css" rel="stylesheet" type="text/css" /> --}}
@endif

@stack('css')
