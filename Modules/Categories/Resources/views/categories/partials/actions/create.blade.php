@if(auth()->user()->hasPermission('create_categories'))
    <a href="{{ route('dashboard.categories.create') }}"
       class="btn btn-primary font-weight-bolder">
        <i class="fas fa fa-fw fa-plus"></i>
        @lang('categories::categories.actions.create')
    </a>
@else
    <button
        type="button"
        disabled
        class="btn btn-primary font-weight-bolder">
        <i class="fas fa fa-fw fa-plus"></i>
        @lang('categories::categories.actions.create')
    </button>
@endif
