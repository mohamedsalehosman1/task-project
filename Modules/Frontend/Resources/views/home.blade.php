<!DOCTYPE html>
<html lang="{{ Locales::getCode() }}">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ app_favicon() }}">
    <!-- SEO -->
    @include('frontend::includes.seo')
    <!-- links all pages -->
    @include('frontend::includes.styles', ['page' => 'home'])
</head>

<body dir="{{ Locales::getDir() }}">
    <!------------ preloder ------------>
    @include('frontend::includes.preloader')

    <!------------ navbar ------------>
    @include('frontend::includes.nav')

    <div class="section-top">
        <!------------ start header ------------>
        @include('frontend::home.header')

        <!------------ start about ------------>
        @include('frontend::home.about')

    </div>

    <!------------ projects ------------>
    @include('frontend::home.projects')

    <!------------ package ------------>
    @include('frontend::home.packages')

    <!------------ start service ------------>
    @include('frontend::home.services')

    <!--------- logo clients --------->
    @include('frontend::home.clients')

    {{-- <div class="section-group-2">
    </div> --}}

    <!------------ start our team ------------>
    {{-- @include('frontend::home.team') --}}

    <!------------ contact us ------------>
    @include('frontend::home.contactus')

    <!------------ footer ------------>
    @include('frontend::includes.footer')

    <!----------- start script ------------->
    @include('frontend::includes.scripts', ['page' => 'home'])

    <script>
        const goToScroll = (package) => {
            document.querySelector('#package').scrollIntoView({ behavior: "smooth", block: "end", inline: "nearest" });
        }
    </script>
</body>

</html>
