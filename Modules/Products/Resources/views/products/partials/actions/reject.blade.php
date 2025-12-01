@if (auth()->user()->hasPermission('update_products'))
    <a href="#vend-{{ $product->id }}-reject-model" class="btn btn-outline-danger waves-effect waves-light btn-sm"
        data-toggle="modal">
        <i class="fas fa-times-circle fa fa-fw"></i>
    </a>

    <!-- Modal -->
    <div class="modal fade" id="vend-{{ $product->id }}-reject-model" tabindex="-1" role="dialog"
        aria-labelledby="modal-title-{{ $product->id }}" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-title-{{ $product->id }}">@lang('products::products.dialogs.reject.title')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                {{ BsForm::post(route('dashboard.products.changeStatus', $product)) }}
                <div class="modal-body">
                    @lang('products::products.dialogs.reject.info')
                        {{ BsForm::text('rejection_reason')->attribute(['data-parsley-maxlength' => '191', 'data-parsley-minlength' => '3'])->label(__('Reason')) }}
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="status" value="rejected">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        @lang('products::products.dialogs.reject.cancel')
                    </button>
                    <button type="submit" class="btn btn-danger">
                        @lang('products::products.dialogs.reject.confirm')
                    </button>
                </div>
                {{ BsForm::close() }}
            </div>
        </div>
    </div>
@else
    <button type="button" disabled class="btn btn-outline-danger waves-effect waves-light btn-sm">
        <i class="fas fa-trash-alt fa fa-fw"></i>
    </button>
@endcan
