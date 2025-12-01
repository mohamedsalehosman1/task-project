<section id="our_team">
    <div class="container position-relative z-1">
        <div class="row justify-content-center">
            <div class="col-12 title-white d-flex justify-content-center flex-column align-items-center mb-5 line-hide">
                <h3 class="title_section fontBold fst-italic text-uppercase m-auto" data-aos="fade">@lang('OUR AMAZING TEAM')</h3>
                <p class="title_desc mb-0 content content-one">
                    {!! Settings::locale(Locales::getCode())->get('team_desc') !!}
                </p>
            </div>
        </div>
        <div class="row justify-content-center  content  content-two">
            <!-- text -->
            <div class="col-12 text-center">
                <div class="swiper team-slider">
                    <div class="swiper-wrapper py-5">
                        @forelse ($team as $member)
                            <!-- single slide -->
                            <div class="swiper-slide">
                                <div class="project-card">
                                    <div class="card-team">
                                        <div class="w-100 images-card">
                                            <img class="frame-img" src="{{ asset('assets/img/frame-phone-bg.png') }}" alt="background">
                                            <img class="img-item" src="{{ $member->getImage() }}" alt="{{ $member->name }}">
                                        </div>
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
        </div>
    </div>
</section>
