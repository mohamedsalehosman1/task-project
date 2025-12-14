{{ BsForm::resource('services::services')->get(url()->current()) }}
@component('dashboard::layouts.components.accordion')
    @slot('title', trans('services::services.actions.filter'))

    <div class="row">
        @if (!auth()->user()->isVendor())
            <div class="col-md-3">
                {{ BsForm::select('vendor_id')->options($vendors)->label(__('vendors::vendors.singular'))->attribute(['class' => 'form-control'])->value(request('vendor_id'))->placeholder(__('Select one')) }}
            </div>
        @endif
        <div class="col-md-3">
            {{ BsForm::select('service_id')->options($services)->label(__('services::services.singular'))->attribute(['class' => 'form-control'])->value(request('service_id'))->placeholder(__('Select one')) }}
        </div>
        <div class="col-md-3">
            {{ BsForm::number('perPage')->value(request('perPage', 15))->min(1)->label(trans('services::services.perPage')) }}
        </div>
    </div>

    @slot('footer')
        <button type="submit" class="btn btn-primary btn-sm">
            <i class="fas fa fa-fw fa-filter"></i>
            @lang('services::services.actions.filter')
        </button>
    @endslot
@endcomponent
{{ BsForm::close() }}
