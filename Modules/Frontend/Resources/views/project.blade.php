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
    @include('frontend::includes.styles', ['page' => 'project'])

    <style>
        header{
            border-bottom: 3px solid #290a44;
            max-height: 350px;
        }
        header,section{
            background-image: none !important;
            background-color: #170229 !important;
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
                <div class="col-lg-5">
                    <div class="h-100 w-100 d-flex align-items-center">
                        <div class="content_text">
                            <!-- title -->
                            <h2 class="title color_yellow w-100">
                                <div class="fontBold w-100">
                                    {{ $project->service->name }}
                                </div>
                            </h2>
                            <div aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                  <li class="breadcrumb-item"><a href="{{ route('home') }}">@lang('Home')</a></li>
                                  <li class="breadcrumb-item"><a href="{{ route('services') }}">@lang('Services')</a></li>
                                  <li class="breadcrumb-item active" aria-current="page">{{ $project->service->name }}</li>
                                </ol>
                            </div>
                            <div class="desc_header mt-3 mb-5">
                                <p>
                                    {{ $project->service->description }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!------------ services-page ------------>
    <div class="single-services-page">
        <section>
            <div class="container position-relative z-1">
                <div class="row justify-content-center ">
                    <div class="col-12 mt-4">
                        <div class="title-left color-white">
                            <h3 class="title_section fontBold fst-italic text-uppercase">{{ $project->name }}</h3>
                        </div>
                        <div class="desc">
                            <p class="my-5">
                                {{ $project->brief }}
                            </p>
                        </div>
                        <!-- slider -->
                        <div class="grid_container">
                            @forelse ($project->images as $image)
                                <div  class="popup-btn" typeOF='img' source='{{ $image['conversions']['medium'] ?? $image['url'] }}'>
                                    <img src="{{ $image['conversions']['medium'] ?? $image['url'] }}"alt="single services img">
                                </div>
                            @empty
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- video popup  -->
    <div class="popup_">
        <div class="video-popup">
            <div class="popup-bg"></div>
            <div class="popup-content">
                <iframe class="youtube-video" src="" width="100%" class="videoo" allowfullscreen
                    frameborder="0"></iframe>
                <img src="" id="myImgs" alt="">
            </div>
        </div>
    </div>

    <!------------ footer ------------>
    @include('frontend::includes.footer')
    <!----------- start script ------------->
    @include('frontend::includes.scripts', ['page' => 'services'])

    <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/js/video-popup.js') }}"></script>

</body>

</html>
