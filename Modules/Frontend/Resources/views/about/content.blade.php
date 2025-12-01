<section id="about_us">
        <div class="container">
            <!-- top section -->
            <div class="row">
                <!-- title section -->
                <div class="col-12">
                    <h3 class="title_section mb-5 text-light" data-aos="fade-left">About us</h3>
                </div>

                <!-- content -->
                <div class="col-md-7 order_0_md_2" data-aos="fade-up">
                    <p>
                        {!! Settings::locale(Locales::getCode())->get('about_us_desc') !!}
                    </p>
                </div>
                <!-- logo -->
                <div class="col-md-5" data-aos="fade-left">
                    <div class="logo mb-4 mb-md-0">
                        <img src="{{ asset('assets/img/logo-dark.svg') }}" alt="">
                    </div>
                </div>
            </div>

            <!-- all card -->
            <div class="row mt-5">
                <!-- singl card -->
                <div class="col-md-4">
                    <div class="card" data-aos="fade-up" data-aos-duration="500">
                        <img src="{{ asset('assets/img/svg/binoculars-svgrepo-com.svg') }}" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title text-center mb-4 mt-2">Vision</h5>
                            <p class="card-text text-center">
                                {!! Settings::locale(Locales::getCode())->get('our_vision') !!}
                            </p>
                        </div>
                    </div>
                </div>
                <!-- singl card -->
                <div class="col-md-4">
                    <div class="card" data-aos="fade-up" data-aos-duration="900">
                        <img src="{{ asset('assets/img/svg/Group 97.svg') }}" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title text-center mb-4 mt-2">Mission</h5>
                            <p class="card-text text-center">
                                {!! Settings::locale(Locales::getCode())->get('our_mission') !!}
                            </p>
                        </div>
                    </div>
                </div>
                <!-- singl card -->
                <div class="col-md-4">
                    <div class="card" data-aos="fade-up" data-aos-duration="1300">
                        <img src="{{ asset('assets/img/svg/Target.svg') }}" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title text-center mb-4 mt-2">Goals</h5>
                            <p class="card-text text-center">
                                {!! Settings::locale(Locales::getCode())->get('our_goals') !!}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            @dd(Settings::instance('vision_cover'))
            <!-- text -->
            {{-- <div class="row">
                <div class="col-12" data-aos="fade-up">
                    <h3 class="title_section mb-4 mt-5">Services</h3>
                    <p class="">We offer many services such as designing and programming websites, mobile
                        applications, domain reservation, and more...</p>
                    <p>You can see our services in detail here <a href="#"
                            class="text-decoration-underline">here</a></p>
                </div>
                <div class="col-12" data-aos="fade-up">
                    <h3 class="title_section mb-4 mt-4">connect</h3>
                    <p>To view available communication methods, please visit the <a href="#"
                            class="text-decoration-underline">connect us</a></p>
                </div>
            </div> --}}
        </div>
    </section>
