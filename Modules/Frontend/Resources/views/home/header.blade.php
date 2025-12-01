<header class="position-relative" id="home">
    <div id="particles-js-1" class="particles-js position-absolute inset-0"></div>
    <div class="container h-100 position-relative z-2">
        <div class="row h-100 align-items-center">
            <!-- slider text -->
            <div class="col-lg-5">
                <div class="h-100 w-100 d-flex align-items-center">
                    <div class="content_text" data-swiper-parallax-opacity="0">
                        <!-- title -->
                        <h2 class="title color_yellow w-100" data-aos="fade">
                            {{-- <div class="fontLight">digital</div> --}}
                            <div class="fontBold w-100">
                                {{ Settings::locale(Locales::getCode())->get('header_title') }}
                                <p class="fontLight">{{ Settings::locale(Locales::getCode())->get('header_sub_title') }}</p>
                            </div>
                        </h2>
                        <!-- desc -->

                        <div class="desc_header mt-3 mb-5">
                            <p
                                data-text="{{ Settings::locale(Locales::getCode())->get('header_desc') }}">
                            </p>
                        </div>
                        <!-- btn -->
                        <div class="d-flex gap-25" data-aos="fade-left">
                            <a href="https://api.whatsapp.com/send?phone={{ Settings::get('whats_app') }}" target="_blank" class="custom-btn btn-3">@lang('Contact Us')</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- slider all img -->
            <div class="col-lg-7 h-100 d-flex justify-content-center align-items-center">
                <div class="parent-icons">
                    <!-- big icon -->
                    <div class="center-icons">
                        <img src="{{ asset('assets/img/iocns-top/small-logo.svg') }}" alt="">
                    </div>
                    <!-- all small icons -->
                    <div class="circle-icons">
                        <!-- single icon -->
                        <div class="small-icon"><a href="#" class="icon">
                            <img  src="{{ asset('assets/img/iocns-top/laptop.svg') }}" alt=""></a></div>
                        <!-- single icon -->
                        <div class="small-icon"><a href="#" class="icon">
                            <img  src="{{ asset('assets/img/iocns-top/mobile.svg') }}" alt=""></a></div>
                        <!-- single icon -->
                        <div class="small-icon"><a href="#" class="icon">
                            <img  src="{{ asset('assets/img/iocns-top/design.svg') }}" alt=""></a></div>
                        <!-- single icon -->
                        <div class="small-icon"><a href="#" class="icon">
                            <img  src="{{ asset('assets/img/iocns-top/support.svg') }}" alt=""></a></div>
                        <!-- single icon -->
                        <div class="small-icon"><a href="#" class="icon">
                            <img  src="{{ asset('assets/img/iocns-top/seo.svg') }}" alt=""></a></div>
                        <!-- single icon -->
                        <div class="small-icon"><a href="#" class="icon">
                            <img  src="{{ asset('assets/img/iocns-top/marketing.svg') }}" alt=""></a></div>
                        <!-- single icon -->
                        <div class="small-icon"><a href="#" class="icon">
                            <img  src="{{ asset('assets/img/iocns-top/server.svg') }}" alt=""></a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
