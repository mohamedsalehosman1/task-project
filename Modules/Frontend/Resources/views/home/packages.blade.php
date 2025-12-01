<section id="package">
    <div class="container pb-md-5">
        <div class="row justify-content-center ">
            <div class="col-12 mb-3">
                <div class="title-left title-white">
                    <h3 class="title_section fontBold fst-italic text-uppercase" data-aos="fade">@lang('Packages')</h3>
                    <p class="title_desc text-start content content-one">
                        {{ Settings::locale(Locales::getCode())->get('packages_desc') }}
                    </p>
                </div>
            </div>
        </div>
        <div class="row content content-two row-gap-5">
            <div class="col-12">
                <div class="swiper packages">
                    <div class="swiper-wrapper">
                        @forelse ($packages as $package)
                            <div style="padding-top: 100px;padding-bottom: 30px;" class="swiper-slide singl-card position-relative" data-aos="fade-left" data-aos-delay="1000" data-aos-duration="500">
                                <div class="content-card">
                                    @if ($package->recommended)
                                        <div class="ribbon red"><span>@lang('Popular')</span></div>
                                    @endif
                                    <h2>{{ $package->name }}</h2>
                                    <ul class="mb-0">
                                        @forelse ($package->features as $feature)
                                            <li>
                                                <img src="{{ asset('assets/img/check-mark.png') }}" alt="">
                                                {{ $feature->feature }}
                                            </li>
                                        @empty
                                        @endforelse
                                    </ul>
                                    <h4 dir="ltr" class="mt-0">
                                        <small style="font-size: .3em;">{{Locales::getCode() == 'ar' ? 'رس' : 'SAR'}}</small><span>{{ $package->price }}</span>
                                    </h2>
                                    <a href="https://api.whatsapp.com/send?phone={{ Settings::get('whats_app') }}" target="_blank">@lang('Contact Us')</a>
                                </div>
                            </div>
                            @empty
                        @endforelse
                    </div>
                    <!-- end swiper-wrapper -->
                </div>
            </div>
        </div>
    </div>
</section>
