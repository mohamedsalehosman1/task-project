@if(auth()->user()->hasPermission('show_orders'))
    <a href="{{ route('dashboard.orders.invoice', $order) }}"
       class="btn btn-icon btn-light-success btn-hover-success btn-sm">
        <i class="fas fa-file-invoice text-success"></i>
    </a>
@else
    <button
        type="button"
        disabled
        class="btn btn-icon btn-light-success btn-hover-success btn-sm">
        <i class="fas fa-file-invoice text-success"></i>
    </button>
@endcan
