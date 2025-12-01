@if(auth()->user()->hasPermission('create_products'))
    <a href="{{ route('dashboard.product_variances.create', $product) }}"
       class="btn btn-primary font-weight-bolder">
        <i class="fas fa fa-fw fa-plus"></i>
        @lang('products::product_variances.actions.create')
    </a>
@else
    <button
        type="button"
        disabled
        class="btn btn-primary font-weight-bolder">
        <i class="fas fa fa-fw fa-plus"></i>
        @lang('products::product_variances.actions.create')
    </button>
@endif
