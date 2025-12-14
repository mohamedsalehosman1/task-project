@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@multilingualFormTabs
    {{ BsForm::text('title')->required()->attribute(['data-parsley-maxlength' => '191', 'data-parsley-minlength' => '3']) }}
    {{ BsForm::textarea('description')->rows('3') }}
@endMultilingualFormTabs

<div class="col-12">
    {{ BsForm::select('vendor_id')->options($vendors)->label(__('vendors::vendors.singular'))->placeholder(__('Select one')) }}
</div>


<div class="row">
    <div class="col-12">
        <label>{{ __('advertisements::advertisements.attributes.image') }}</label>
        @isset($advertisement)
            @include('dashboard::layouts.apps.file', [
                'file' => $advertisement->getImage(),
                'name' => 'image',
                'mimes' => 'png jpg jpeg'
            ])
        @else
            @include('dashboard::layouts.apps.file', ['name' => 'image'])
        @endisset
    </div>
</div>


<div class="row">
    @include('dashboard::layouts.apps.switch', [
        'name' => 'defined',
        'label' => __('advertisements::advertisements.attributes.defined'),
        'item' => $advertisement ?? '',
        'checked' => old('defined', $advertisement->defined ?? 0),
    ])
</div>

<div class="row time"
    @isset($advertisement)
            style="display: {{ $advertisement->defined ? 'bolck' : 'none' }}"
        @else
            style="display: none"
        @endisset>

    <div class="col-6">
        <label>@lang('advertisements::advertisements.attributes.start_at')</label>
        @isset($advertisement)
            <input class="form-control" type="date" name="start_at"
                value="{{ old('start_at', Carbon\Carbon::parse($advertisement->start_at)->format('Y-m-d')) }}">
        @else
            <input class="form-control" type="date" name="start_at" value="{{ old('start_at') }}">
        @endisset
    </div>
    <div class="col-6">
        <label>@lang('advertisements::advertisements.attributes.end_at')</label>
        @isset($advertisement)
            <input class="form-control" type="date" name="end_at"
                value="{{ old('end_at', Carbon\Carbon::parse($advertisement->end_at)->format('Y-m-d')) }}">
        @else
            <input class="form-control" type="date" name="end_at" value="{{ old('end_at') }}">
        @endisset
    </div>
</div>

<div class="row">
    @include('dashboard::layouts.apps.switch', [
        'name' => 'active',
        'label' => __('advertisements::advertisements.attributes.active'),
        'item' => $advertisement ?? '',
        'checked' => old('active', $advertisement->active ?? 0),
    ])
</div>

<div class="row">
    @include('dashboard::layouts.apps.switch', [
        'name' => 'auto_popup',
        'label' => __('advertisements::advertisements.attributes.auto_popup'),
        'item' => $advertisement ?? '',
        'checked' => old('auto_popup', $advertisement->auto_popup ?? 0),
    ])
</div>

@push('js')
    <script>
        $(document).ready(function() {
            $("#defined").on("change", function() {
                if ($(this).is(":checked")) {
                    $(".time").show();
                    $("input[name=start_at], input[name=end_at]").attr('required', 'required');
                } else {
                    $(".time").hide();
                    $("input[name=start_at], input[name=end_at]").val('').removeAttr('required');
                }
            });
        });
    </script>
@endpush
