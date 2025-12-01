<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>vision-co</title>
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ app_favicon() }}">
    <!-- SEO -->
    @include('frontend::includes.seo')
    <!-- links all pages -->
    @include('frontend::includes.styles', ['page' => 'services'])

    <style>
        header{
            max-height: 500px;
        }
        header,section{
            background-image: none !important;
            background-color: #170229 !important;
        }
        .services-section .swiper-slide .card img{
            height: 200px;
            object-fit: cover;
        }
    </style>
    <style>
        header{
            border-bottom: 3px solid #290a44;
            max-height: 350px;
        }
        .swiper-slide{
            height: auto;
        }
    </style>

</head>
<body>

    <!------------ preloder ------------>
    {{-- @include('frontend::includes.preloader') --}}

    <!------------ navbar ------------>
    @include('frontend::includes.nav')

    <!------------ start header ------------>
    <header class="position-relative small-header" id="home">
        <div id="particles-js-1" class="particles-js position-absolute inset-0"></div>
        <div class="container h-100 position-relative z-2">
            <div class="row h-100 align-items-center">
                <!-- slider text -->
                <div class="col-12">
                    <div class="h-100 w-100">
                        <div class="content_text d-flex align-items-center justify-content-center flex-column">
                            <!-- title -->
                            <h2 class="title color_yellow">
                                <div class="fontBold">
                                    @lang('Services')
                                </div>
                            </h2>
                            <div aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                  <li class="breadcrumb-item"><a href="{{ route('home') }}">@lang('Home')</a></li>
                                  <li class="breadcrumb-item active" aria-current="page">@lang('Services')</li>
                                </ol>
                            </div>
                            <div class="desc_header mt-3 mb-5">
                                <p>
                                    {!! Settings::locale(Locales::getCode())->get('services_page_desc') !!}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!------------ services-page ------------>
    <div class="services-page">
        @forelse ($services as $service)
            <section>
                <div class="container position-relative z-1">
                    <div class="row justify-content-center ">
                        <div class="col-12 mt-4">
                            <div class="title-left color-white">
                                <h3 class="title_section fontBold fst-italic text-uppercase m-0 d-flex justify-content-start">{{ $service->name }}</h3>
                            </div>
                            <!-- slider -->
                            <div class="swiper services-slider pb-5">
                                <div class="swiper-wrapper py-5 mb-4">
                                    @forelse ($service->projects as $project)
                                        <div class="swiper-slide h-auto">
                                            <div class="card h-100 project-card">
                                                <img class="w-100" style="height: 220px;object-fit: cover;" src="{{ $project->getImage() }}" alt="">
                                                <div class="card-body d-flex flex-column">
                                                    <h5 class="card-title">{{ $project->name }}</h5>
                                                    <p class="card-text flex-fill">
                                                        {{ $project->short_brief }}
                                                    </p>
                                                    <a href="{{ route('projects.details', $project->slug) }}"
                                                        class="btn btn-sm btn-outline-info project-btn">
                                                        @lang('Learn more')
                                                    </a>
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
        @empty
        @endforelse
    </div>

    <!------------ footer ------------>
    @include('frontend::includes.footer')
    <!----------- start script ------------->
    @include('frontend::includes.scripts', ['page' => 'services'])
</body>
</html>
