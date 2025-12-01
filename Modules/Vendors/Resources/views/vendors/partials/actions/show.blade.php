@if(auth()->user()->hasPermission('show_vendors'))
    <a href="{{ route('dashboard.vendors.show', $vendor) }}"
       class="btn btn-outline-success waves-effect waves-light btn-sm">
        <i class="fas fa fa-fw fa-home"></i>
    </a>
@else
    <button
        type="button"
        disabled
        class="btn btn-outline-success waves-effect waves-light btn-sm">
        <i class="fas fa fa-fw fa-home"></i>
    </button>
@endcan
