<section id="about">
    <div class="container position-relative z-2">
        <div class="row justify-content-between align-items-center">
            <!-- text -->
            <div class="col-lg-6 color-white">
                <div class="title-left color-white">
                    <h3 class="title_section fontBold text-uppercase fst-italic" data-aos="fade">@lang('About Us')</h3>
                </div>

                <div class="content content-one t-white pe-4">
                    {!! Settings::locale(Locales::getCode())->get('about_desc') !!}
                </div>
            </div>
            <!-- icons -->
            <div class="col-lg-5">
                <div class="content content-two">
                    <img src="{{ asset('assets/img/svg/about.svg') }}" alt="">
                    {{-- <img src="{{ Settings::instance('about_image')->getFirstMediaUrl('about_image') }}" alt=""> --}}
                </div>
            </div>
        </div>
    </div>
</section>
