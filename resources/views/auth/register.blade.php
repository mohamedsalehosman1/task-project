@extends('dashboard::layouts.default-without-nav')

@section('title')
    @lang('admin.auth.login.title')
@endsection

@section('content')
    <div class="home-btn d-none d-sm-block">
        <a href="{{ route('home') }}" class="text-dark"><i class="fas fa-home h2"></i></a>
    </div>
    <div class="account-pages my-5 pt-sm-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="">
                    <div class="card overflow-hidden">
                        <div class="bg-login text-center" style="background-color: {{ env('DASHBOARD_CHOSEN_COLOR') }};">
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
@include('dashboard::errors')

@bsMultilangualFormTabs
    {{ BsForm::text('name')->required()->attribute(['data-parsley-maxlength' => '191', 'data-parsley-minlength' => '3']) }}
    {{ BsForm::text('nationality')->required()->attribute(['data-parsley-maxlength' => '191', 'data-parsley-minlength' => '3']) }}

    {{ BsForm::textarea('description')->attribute(['class' => 'textarea']) }}
@endBsMultilangualFormTabs

<div class="row">
    <div class="col-6">
        {{ BsForm::text('email')->required()->attribute(['data-parsley-type' => 'email']) }}
    </div>
    <div class="col-6">
        {{ BsForm::text('phone')->required()->attribute(['data-parsley-minlength' => '3']) }}
    </div>
</div>

<div class="row">
    <div class="col-6">
        {{ BsForm::password('password') }}
    </div>
    <div class="col-6">
        {{ BsForm::password('password_confirmation') }}
    </div>
</div>
<div class="row">
    <div class="col-6">
        {{ BsForm::text('commercial_registration_number')->required()->attribute(['data-parsley-minlength' => '3']) }}
    </div>
   <div class="col-6">
        {{ BsForm::text('identity_number')->required()->attribute(['data-parsley-minlength' => '3']) }}
    </div>
</div>
<div class="row">
    <div class="col-12">
        <label>{{ __('vendors::vendors.attributes.banners') }}</label>
        @isset($vendor)
            @include('dashboard::layouts.apps.multi', [
                'name' => 'banners[]',
                'images' => $vendor->banners,
            ])
        @else
            @include('dashboard::layouts.apps.multi', ['name' => 'banners[]'])
        @endisset
    </div>
</div>


<div class="row">
    <div class="col-12">
        <label>{{ __('vendors::vendors.attributes.image') }}</label>
        @isset($vendor)
            @include('dashboard::layouts.apps.file', [
                'file' => $vendor->getImage(),
                'name' => 'image',
                'mimes' => 'png jpg jpeg',
            ])
        @else
            @include('dashboard::layouts.apps.file', ['name' => 'image'])
        @endisset
    </div>
</div>


@include('vendors::vendors.partials.map')

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
