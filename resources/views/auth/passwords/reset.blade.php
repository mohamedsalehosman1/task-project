@extends('dashboard::layouts.default-without-nav')

@section('title') @lang('إعادة تعيين كلمة المرور') @endsection

@section('content')
<div class="home-btn d-none d-sm-block">
    <a href="{{ route('home') }}" class="text-dark"><i class="fas fa-home h2"></i></a>
</div>

<div class="account-pages my-5 pt-sm-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">
                <div class="card overflow-hidden">

                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="bg-login text-center" style="background-color: {{ env('DASHBOARD_CHOSEN_COLOR') }};">
                        <div class="bg-login-overlay"></div>
                        <div class="position-relative">
                            <h5 class="text-white font-size-20">@lang('Reset Password')</h5>
                            <a href="{{ route('home') }}" class="logo logo-dark mt-4">
                                <img src="{{ app_login_logo() }}" alt="" height="100">
                            </a>
                        </div>
                    </div>

                    <div class="card-body pt-5">
                        <div class="p-2">
                            <form method="POST" action="{{ route('password.update.code') }}">
                                @csrf

                                {{-- email --}}
                                <div class="form-group">
                                    <label for="email" style="float: right">{{ __('البريد الإلكتروني') }}</label>
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        name="email" value="{{ old('email', request('email')) }}" required autofocus>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                {{-- code --}}
                                <div class="form-group">
                                    <label for="code" style="float: right">{{ __('كود التحقق') }}</label>
                                    <input id="code" type="text"
                                        class="form-control @error('code') is-invalid @enderror"
                                        name="code" value="{{ old('code') }}" required>
                                    @error('code')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                {{-- password --}}
                                <div class="form-group">
                                    <label for="password" style="float: right">{{ __('كلمة المرور الجديدة') }}</label>
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror"
                                        name="password" required>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                {{-- password confirmation --}}
                                <div class="form-group">
                                    <label for="password-confirm" style="float: right">{{ __('تأكيد كلمة المرور') }}</label>
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                                </div>

                                <div class="mt-3">
                                    <button class="btn btn-primary btn-block" type="submit">
                                        {{ __('حفظ') }}
                                    </button>
                                </div>
                            </form>
                        </div>

                        <div class="mt-3 text-center">
                            <a href="{{ route('password.request') }}">@lang('طلب كود جديد')</a> |
                            <a href="{{ route('login') }}">@lang('العودة لتسجيل الدخول')</a>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
