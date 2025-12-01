<section id="projects">
    <!-- <div class="bg-space"></div> -->
    <div class="container position-relative z-1">
        <div class="row justify-content-center ">
            <div class="col-12 mb-md-5 pt-4">
                <div class="title-left color-white">
                    <h3 class="title_section fontBold fst-italic text-uppercase" data-aos="fade">@lang('Latest Projects')</h3>
                    <p class="title_desc text-start content content-one">
                        {!! Settings::locale(Locales::getCode())->get('projects_desc') !!}
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid content content-one">
        <div class="swiper project-slider">
            <div class="swiper-wrapper py-5">

                @forelse ($projects as $project)
                    <div class="swiper-slide">
                        <div class="project-card">
                            <img class="w-100" src="{{ $project->getCover() }}" alt="">
                            <div class="project-download">
                                <a href="#"><img src="{{ asset('assets/img/app-store.png') }}" alt=""></a>
                                <a href="#"><img src="{{ asset('assets/img/google-play.png') }}" alt=""></a>
                            </div>
                        </div>
                    </div>
                @empty
                @endforelse

            </div>
            <div class="control-project">
                <div class="arrow-project">
                    <div class="swiper-button-prev prev"></div>
                    <div class="swiper-button-next next"></div>
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </div>
</section>
