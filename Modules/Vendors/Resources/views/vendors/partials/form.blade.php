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
