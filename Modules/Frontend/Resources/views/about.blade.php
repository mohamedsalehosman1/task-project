<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ app_favicon() }}">

    <!-- SEO -->
    @include('frontend::includes.seo', ['page' => 'about'])
    <!-- links all pages -->
    @include('frontend::includes.styles', ['page' => 'about'])

</head>

<body>

    <!------------ nav ------------>
    @include('frontend::includes.nav')

    <!-- no Header -->
    <div class="icon_section bg_dark h-auto noHeader" style="min-height:110px;"></div>

    <!---------- content ----------->
    @include('frontend::about.content')

    <!---------- footer ----------->
    @include('frontend::includes.footer')

    <!----------- start script ------------->
    @include('frontend::includes.scripts', ['page' => 'about'])

    <!-- End section contact  -->
    {!! Settings::get('google_id_footer') !!}

</body>

</html>
