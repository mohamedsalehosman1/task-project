@php
    use App\Enums\OrderStatusEnum;

    $status = OrderStatusEnum::cases();

    $statusOptions = collect($status)->mapWithKeys(function ($status) {
        return [$status->value => __($status->value)];
    })->toArray();
@endphp

<div class="form-group">
    <label for="status">@lang('orders::orders.attributes.statuses.status')</label>

    {{ BsForm::select('status')
        ->options($statusOptions)
        ->value($order->status)
        ->attribute('id', 'status') }}
</div>

@slot('footer')
    {{ BsForm::submit(trans('orders::orders.actions.save'))->attribute('id', 'disable-click') }}
@endslot

@push('js')
    <script>
        $(document).ready(function () {
            $("#status").on('change', function () {
                let selectedStatus = $(this).val();

                if (selectedStatus === 'accepted') {
                    $('#div').show();
                    $('#cancel').hide();
                    $("#delivery").attr('required', 'required');
                }
                else if (selectedStatus === 'cancelled') {
                    $('#div').hide();
                    $('.radius').hide();
                    $('#cancel').show();
                    $("#delivery").removeAttr("required");
                }
                else {
                    $('#div').hide();
                    $('#cancel').hide();
                    $('.radius').hide();
                    $("#delivery").removeAttr("required");
                }

                $("#status").prop('disabled', false);
            });

            $("form").on('submit', function (event) {
                $("#disable-click").attr("disabled", "disabled");
            });

            $('#delivery').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
                let isAllSelected = clickedIndex == 1;

                if (isAllSelected) {
                    $('.radius').show();
                    $("#radius").attr('required', 'required');
                } else {
                    $('.radius').hide();
                    $("#radius").removeAttr("required");
                }
            });
        });
    </script>
@endpush

@push('css')
    <style>
        .accordion>.card {
            overflow: unset;
        }
    </style>
@endpush
