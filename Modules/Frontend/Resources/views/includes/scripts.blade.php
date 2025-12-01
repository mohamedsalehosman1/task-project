@if ($page == 'home')
    <script src="{{ asset('assets/js/swiper.js') }}"></script>
    <script src="{{ asset('assets/js/aos.js') }}"></script>
    <script src="{{ asset('assets/js/particles.min.js') }}"></script>
    <script src="{{ asset('assets/js/particles.setting.js') }}"></script>
    <script src="{{ asset('assets/js/home.js') }}"></script>

    <script>
        // services card responsive
        let serviceCard = document.querySelectorAll('#our_team .card_team')
        const serviceCardResponsive = () => {
            serviceCard.forEach(item => {
                item.style.height = item.getBoundingClientRect().width + 50 + 'px'
            })
        }
        serviceCardResponsive()
        addEventListener('resize', serviceCardResponsive)
        // slider header
        let optionSlider = {
            slidesPerView: 1,
            parallax: true,
            pagination: {
                el: ".swiper-pagination",
                clickable: true
            },
            loop: true,
            autoplay: {
                delay: 10000,
            },
            speed: 1000
        }
        let sliderimages = new Swiper(".sliderimages", optionSlider),
            slidertexts = new Swiper(".slidertext", optionSlider);
        if (document.querySelector(".sliderimages")) {
            sliderimages.controller.control = slidertexts;
            slidertexts.controller.control = sliderimages;
        }

        var swiper = new Swiper('.project-slider', {
            slidesPerView: 1,
            loop: true,
            effect: 'coverflow',
            grabCursor: true,
            centeredSlides: true,
            coverflowEffect: {
                rotate: 15,
                stretch: 0,
                depth: -70,
                modifier: 1.5,
            },
            navigation: {
                nextEl: '.project-slider .next',
                prevEl: '.project-slider .prev',
            },
            pagination: {
                el: ".project-slider .swiper-pagination",
                dynamicBullets: true,
                clickable: true
            },
            autoplay: {
                speeds: 2000,
                delay: 2000,
            },
            breakpoints: {
                574: {
                    slidesPerView: 2,
                },
                768: {
                    slidesPerView: 3
                },
                1200: {
                    slidesPerView: 5
                },
            },
        });

        var swiper = new Swiper('.team-slider', {
            effect: 'coverflow',
            grabCursor: true,
            centeredSlides: true,
            slidesPerView: 4,
            loop: true,
            navigation: {
                nextEl: '.team-slider .next',
                prevEl: '.team-slider .prev',
            },
            autoplay: {
                speeds: 2000,
                delay: 4000,
            },
            coverflowEffect: {
                rotate: 2,
                stretch: 0,
                depth: 78,
                modifier: 2,
                slideShadows: false,
            },
            breakpoints: {
                0: {
                    slidesPerView: 2,
                },
                574: {
                    slidesPerView: 3,
                },
                768: {
                    slidesPerView: 4
                },
            },
            pagination: {
                el: ".team-slider .swiper-pagination",
                dynamicBullets: true,
                clickable: true
            },
        });

        new Swiper(".first_slider_logo", {
            slidesPerView: 2,
            spaceBetween: 10,
            loop: true,
            autoplay: {
                delay: 2000,
                disableOnInteraction: false,
            },
            breakpoints: {
                575: {
                    slidesPerView: 3,
                    spaceBetween: 10,
                },
                767: {
                    slidesPerView: 4,
                    spaceBetween: 10,
                },
                991: {
                    slidesPerView: 5,
                    spaceBetween: 10,
                },
            },
            navigation: {
                nextEl: '.first_slider_logo .next',
                prevEl: '.first_slider_logo .prev',
            },
            pagination: {
                el: ".first_slider_logo .swiper-pagination",
                dynamicBullets: true,
                clickable: true
            },
        });

        new Swiper(".packages", {
            slidesPerView: 1,
            spaceBetween: 10,
            rewind: true,
            autoplay: {
                delay: 2000,
                disableOnInteraction: false,
            },
            breakpoints: {
                575: {
                    slidesPerView: 1,
                    spaceBetween: 10,
                },
                767: {
                    slidesPerView: 2,
                    spaceBetween: 10,
                },
                991: {
                    slidesPerView: 3,
                    spaceBetween: 10,
                },
            },
        });

        (() => {
            document.querySelectorAll('[data-src]')?.forEach(function(e) {
                e.src = e.getAttribute('data-src')
            });
        })()
    </script>
@elseif ($page == 'services')
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script src="{{ asset('assets/js/swiper.js') }}"></script>
    <script src="{{ asset('assets/js/aos.js') }}"></script>
    <script src="{{ asset('assets/js/particles.min.js') }}"></script>
    <script src="{{ asset('assets/js/particles.setting.js') }}"></script>

    <script>
        new Swiper(".services-slider", {
            slidesPerView: 2,
            spaceBetween: 10,
            loop: true,
            autoplay: {
                delay: 2500,
                disableOnInteraction: false,
            },
            breakpoints: {
                575: {
                    slidesPerView: 3,
                    spaceBetween: 10,
                },
                767: {
                    slidesPerView: 4,
                    spaceBetween: 10,
                },
                991: {
                    slidesPerView: 5,
                    spaceBetween: 10,
                },
            },
            navigation: {
                nextEl: '.services-slider .next',
                prevEl: '.services-slider .prev',
            },
            autoplay: {
                speeds: 2000,
                delay: 4000,
            },
            pagination: {
                el: ".services-slider .swiper-pagination",
                dynamicBullets: true,
                clickable: true
            },
        });

        (() => {
            document.querySelectorAll('[data-src]')?.forEach(function(e) {
                e.src = e.getAttribute('data-src')
            });
        })()
    </script>
@elseif ($page == 'page')
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script src="{{ asset('assets/js/swiper.js') }}"></script>
    <script src="{{ asset('assets/js/aos.js') }}"></script>
    <script src="{{ asset('assets/js/particles.min.js') }}"></script>
    <script src="{{ asset('assets/js/particles.setting.js') }}"></script>

    <script>
        new Swiper(".services-slider", {
            slidesPerView: 2,
            spaceBetween: 10,
            loop: true,
            autoplay: {
                delay: 2500,
                disableOnInteraction: false,
            },
            breakpoints: {
                575: {
                    slidesPerView: 3,
                    spaceBetween: 10,
                },
                767: {
                    slidesPerView: 4,
                    spaceBetween: 10,
                },
                991: {
                    slidesPerView: 5,
                    spaceBetween: 10,
                },
            },
            navigation: {
                nextEl: '.services-slider .next',
                prevEl: '.services-slider .prev',
            },
            autoplay: {
                speeds: 2000,
                delay: 4000,
            },
            pagination: {
                el: ".services-slider .swiper-pagination",
                dynamicBullets: true,
                clickable: true
            },
        });

        (() => {
            document.querySelectorAll('[data-src]')?.forEach(function(e) {
                e.src = e.getAttribute('data-src')
            });
        })()
    </script>
@endif

{!! Settings::get('google_id_footer') !!}
