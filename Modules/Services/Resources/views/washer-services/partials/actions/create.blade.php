@if(auth()->user()->hasPermission('create_services'))
    <a href="{{ route('dashboard.vendor-services.create') }}"
       class="btn btn-primary font-weight-bolder">
        <i class="fas fa fa-fw fa-plus"></i>
        @lang('services::services.actions.create')
    </a>
@else
    <button
        type="button"
        disabled
        class="btn btn-primary font-weight-bolder">
        <i class="fas fa fa-fw fa-plus"></i>
        @lang('services::services.actions.create')
    </button>
@endif
