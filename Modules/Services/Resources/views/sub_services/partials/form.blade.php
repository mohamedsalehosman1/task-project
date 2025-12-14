{{-- @include('dashboard::errors')
@bsMultilangualFormTabs
    {{ BsForm::text('name')->required()->attribute(['data-parsley-maxlength' => '191', 'data-parsley-minlength' => '3'])->label(__('services::sub_services.attributes.name')) }}
@endBsMultilangualFormTabs

<input type="hidden" name="parent_id" value="{{ $service->id }}">

<div class="row">
    <div class="col-12">
        <label>{{ __('services::sub_services.attributes.image') }}</label>
        @if (!request()->routeIs('dashboard.sub_services.show'))
            @if (isset($service) && request()->routeIs('*sub_services.create'))
                @include('dashboard::layouts.apps.file', [
                    'file' => $service->getImage(),
                    'name' => 'image',
                ])
            @else
                @include('dashboard::layouts.apps.file', ['name' => 'image'])
            @endif
        @else
            @include('dashboard::layouts.apps.file', ['name' => 'image'])
        @endif
    </div>

</div> --}}
@include('dashboard::errors')

@bsMultilangualFormTabs
    {{ BsForm::text('name')->required()->attribute(['data-parsley-maxlength' => '191', 'data-parsley-minlength' => '3']) }}
    {{-- {{ BsForm::textarea('description')->rows('3') }} --}}
@endBsMultilangualFormTabs



<div class="row">
    <div class="col-12">
        <label>{{ __('services::services.attributes.image') }}</label>
        @isset($service)
            @include('dashboard::layouts.apps.file', [
                'file' => $service->getImage(),
                'name' => 'image',
            ])
        @else
            @include('dashboard::layouts.apps.file', ['name' => 'image'])
        @endisset
    </div>
</div>
