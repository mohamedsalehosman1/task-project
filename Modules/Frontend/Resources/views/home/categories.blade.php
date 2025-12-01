<section id="logo_slider_first" class="logo_slider">
    <div class="container">
        <div class="row justify-content-center ">
            <div class="col-12 mb-5">
                <div class="title-left title-white">
                    <h3 class="title_section fontBold fst-italic text-uppercase" data-aos="fade">@lang('Our categories')</h3>
                    <p class="title_desc mb-5 text-start content content-one">
                        {!! Settings::locale(Locales::getCode())->get('categories_desc') !!}
                    </p>
                </div>
            </div>
        </div>
        <div class="row content content-two">
            <div class="col-12">
                <div class="parentSilder mt-3 position-relative">
                    <div class="swiper slider-logo first_slider_logo pb-5">
                        <div class="swiper-wrapper pb-5 mb-5">

                            @forelse ($categories as $category)
                                <!-- singl slider -->
                                <div class="swiper-slide">
                                    <img data-src="{{ $category->getImage() }}" alt="">
                                </div>
                            @empty
                            @endforelse

                        </div>
                        <!-- end swiper-wrapper -->
                        <div class="control-project">
                            <div class="arrow-project">
                                <div class="swiper-button-prev prev"></div>
                                <div class="swiper-button-next next"></div>
                            </div>
                            <div class="swiper-pagination"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
