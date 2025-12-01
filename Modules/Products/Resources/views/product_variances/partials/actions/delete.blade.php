@if (auth()->user()->hasPermission('delete_products'))
    <a href="#country-{{ $product_variance->id }}-delete-model"
        class="btn btn-outline-danger waves-effect waves-light btn-sm" data-toggle="modal">
        <i class="fas fa-trash-alt fa fa-fw"></i>
    </a>

    <!-- Modal -->
    <div class="modal fade" id="country-{{ $product_variance->id }}-delete-model" tabindex="-1" role="dialog"
        aria-labelledby="modal-title-{{ $product_variance->id }}" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-title-{{ $product_variance->id }}">@lang('products::product_variances.dialogs.delete.title')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @lang('products::product_variances.dialogs.delete.info')
                </div>
                <div class="modal-footer">
                    {{ BsForm::delete(route('dashboard.product_variances.destroy', [$product, $product_variance])) }}
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        @lang('products::product_variances.dialogs.delete.cancel')
                    </button>
                    <button type="submit" class="btn btn-danger">
                        @lang('products::product_variances.dialogs.delete.confirm')
                    </button>
                    {{ BsForm::close() }}
                </div>
            </div>
        </div>
    </div>
@else
    <button type="button" disabled class="btn btn-outline-danger waves-effect waves-light btn-sm">
        <i class="fas fa-trash-alt fa fa-fw"></i>
    </button>
@endcan
