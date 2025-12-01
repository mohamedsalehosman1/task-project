@if ($page == 'home')
    @if (Locales::getCode() == 'ar')
        <!-- start css -->
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.rtl.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/swiper-slider.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/aos.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/flaticon.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/style-ar.css') }}">
    @else
        <!-- start css -->
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/swiper-slider.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/aos.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/flaticon.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    @endif
@elseif ($page == 'services')
    @if (Locales::getCode() == 'ar')
        <!-- start css -->
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.rtl.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/swiper-slider.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/aos.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/flaticon.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/style-ar.css') }}">
    @else
        <!-- start css -->
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/swiper-slider.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/aos.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/flaticon.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    @endif
@elseif ($page == 'project')
    @if (Locales::getCode() == 'ar')
        <!-- start css -->
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.rtl.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/swiper-slider.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/aos.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/flaticon.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/style-ar.css') }}">
    @else
        <!-- start css -->
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/swiper-slider.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/aos.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/flaticon.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    @endif


@endif
