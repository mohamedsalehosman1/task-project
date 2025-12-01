@if (auth()->user()->hasPermission('show_products'))
    <a href="{{ route('dashboard.product_variances.index', $product) }}"
        class="btn btn-outline-success waves-effect waves-light btn-sm">
        <i class="fas fa-code-branch"></i>
    </a>
@else
    <button type="button" disabled class="btn btn-outline-success waves-effect waves-light btn-sm">
        <i class="fas fa-code-branch"></i>
    </button>
@endcan
