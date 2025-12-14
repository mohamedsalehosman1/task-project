{{ BsForm::resource('services::sub_services')->get(url()->current()) }}
@component('dashboard::layouts.components.accordion')
    @slot('title', trans('services::sub_services.actions.filter'))

    <div class="row">
        <div class="col-md-6">
            {{ BsForm::text('name')->value(request('name'))->label(trans('services::sub_services.attributes.name')) }}
        </div>
    
        <div class="col-md-6">
            {{ BsForm::number('perPage')
                ->value(request('perPage', 15))
                ->min(1)
                 ->label(trans('services::sub_services.perPage')) }}
        </div>
    </div>

    @slot('footer')
        <button type="submit" class="btn btn-primary btn-sm">
            <i class="fas fa fa-fw fa-filter"></i>
            @lang('services::sub_services.actions.filter')
        </button>
    @endslot
@endcomponent
{{ BsForm::close() }}
