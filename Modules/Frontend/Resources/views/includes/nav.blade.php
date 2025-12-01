<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container">
        <!-- start logo -->
        <a class="navbar-brand" href="#">
            <img src="{{ asset('assets/img/logo.png') }}" alt="logo">
        </a>

        <div class="nav-list position-relative">
            <!-- start menu -->
            <div class="nav_menu d-lg-none">
                <label for="check">
                    <span></span>
                    <span></span>
                    <span></span>
                </label>
            </div>

            <div class=lists>
                <ul class="navbar-nav me-auto my-2 my-lg-0 nav-links d-lg-flex mb-0" style="--bs-scroll-height: 100px;">
                    <li class="nav-item">
                        <a class="nav-link link_ {{ request()->routeIs('home') ? 'active' : '' }}" aria-current="page" href="{{ route('home') }}">@lang('Home')</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link link_" href="{{route('home').'#about'}}" onclick="goToScroll('#about')">@lang('About Us')</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link link_ {{ request()->routeIs('services') ? 'active' : '' }}" href="{{ route('services') }}">@lang('Services')</a>
                    </li>
                    <li class="nav-item">
                        <a @if (!request()->routeIs('home')) href="{{route('home').'#package'}}"@endif class="nav-link link_" onclick="goToScroll('#package')">@lang('Packages')</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link link_" href="{{route('home').'#projects'}}" onclick="goToScroll('#projects')">@lang('Latest Projects')</a>
                    </li>

                </ul>
            </div>
        </div>

        @php
            $lang = Locales::getCode() == 'ar' ? 'en' : 'ar';
        @endphp

        <!-- start lang btn -->
        <a href="{{ route('frontend.locale', $lang) }}" class="nav-link link_ active">{{ ucfirst($lang) }}</a>
    </div>
</nav>
