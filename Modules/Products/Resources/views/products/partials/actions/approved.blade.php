@if (auth()->user()->hasPermission('update_products'))
    <a href="#product-{{ $product->id }}-delete-model" class="btn btn-outline-success waves-effect waves-light btn-sm"
        data-toggle="modal">
        <i class="fas fa-check-circle fa fa-fw"></i>
    </a>

    <!-- Modal -->
    <div class="modal fade" id="product-{{ $product->id }}-delete-model" tabindex="-1" role="dialog"
        aria-labelledby="modal-title-{{ $product->id }}" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-title-{{ $product->id }}">@lang('products::products.dialogs.approved.title')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @lang('products::products.dialogs.approved.info')
                </div>
                <div class="modal-footer">
                    {{ BsForm::post(route('dashboard.products.changeStatus', ['product' => $product])) }}
                    <input type="hidden" name="status" value="accepeted">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        @lang('products::products.dialogs.approved.cancel')
                    </button>
                    <button type="submit" class="btn btn-success">
                        @lang('products::products.dialogs.approved.confirm')
                    </button>
                    {{ BsForm::close() }}
                </div>
            </div>
        </div>
    </div>
@else
    <button type="button" disabled class="btn btn-outline-success waves-effect waves-light btn-sm">
        <i class="fas fa-trash-alt fa fa-fw"></i>
    </button>
@endcan
