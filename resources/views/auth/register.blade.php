@extends('dashboard::layouts.default-without-nav')

@section('title')
    @lang('admin.auth.login.title')
@endsection

@section('content')

    {{-- سويتش تغيير اللغة --}}
    <div style="position: absolute; top: 20px; right: 20px; z-index:9999;">
        <a href="{{ route('locale.switch', 'ar') }}"
           class="btn btn-sm btn-outline-primary {{ app()->getLocale() == 'ar' ? 'active' : '' }}">
            العربية
        </a>

        <a href="{{ route('locale.switch', 'en') }}"
           class="btn btn-sm btn-outline-primary {{ app()->getLocale() == 'en' ? 'active' : '' }}">
            English
        </a>
    </div>

    <div class="home-btn d-none d-sm-block">
        <a href="{{ route('home') }}" class="text-dark"><i class="fas fa-home h2"></i></a>
    </div>

    <div class="account-pages my-5 pt-sm-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="">
                    <div class="card overflow-hidden">

                        <div class="bg-login text-center"
                             style="background-color: {{ env('DASHBOARD_CHOSEN_COLOR') }};">
                            <div class="bg-login-overlay"></div>

                            <div class="position-relative">
                                <a href="{{ route('home') }}" class="logo logo-dark mt-4">
                                    <img src="{{ app_login_logo() }}" alt="" height="100">
                                </a>
                            </div>
                        </div>

                        <div class="card-body pt-5">
                            <div class="p-2">

                                {{ BsForm::resource('vendors::vendors')->post(route('store.register'), ['files' => true, 'data-parsley-validate']) }}

                                @include('vendors::vendors.partials.registerForm')

                                <div class="mt-4">
                                    {{ BsForm::submit()->label(trans('vendors::vendors.actions.save')) }}
                                </div>

                                {{ BsForm::close() }}

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
