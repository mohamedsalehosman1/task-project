@foreach ($days as $day)
    <div class="row py-2">
        <div class="col-2 mt-3">
            <div class="custom-control custom-switch mt-4" dir="{{ Locales::getDir() }}">
                <input type="hidden" name="{{ $day }}" value="0">
                <input type="checkbox" name="{{ $day }}"
                    @isset($service)
                        {{ in_array($day, $service_days) ? 'checked' : '' }}
                    @else
                        {{ old($day) == 1 ? 'checked' : '' }}
                    @endisset
                    value="1" class="custom-control-input" id="{{ $day }}">
                <label class="custom-control-label" for="{{ $day }}">@lang('services::services.days.' . $day)</label>
            </div>
        </div>

        <div id="{{ $day }}-time" class="col-10"
        @if (!in_array($day, $service_days))
        style="display: none"
        @endif>
            <div class="row">
                <div class="form-group col-6">
                    <label for="{{ $day }}_opening_time">{{ __('services::services.attributes.opening_time') }}</label>
                    <input
                        type="time"
                        name="{{ $day }}_opening_time"
                        id="{{ $day }}_opening_time"
                        @if (in_array($day, $service_days))
                            value="{{ $service->getDaytime($day)['from'] }}"
                        @else
                            value="{{ old($day .'_opening_time') }}"
                        @endif
                        class="form-control">
                </div>

                <div class="form-group col-6">
                    <label for="{{ $day }}_close_time">{{ __('services::services.attributes.close_time') }}</label>
                    <input
                        type="time"
                        name="{{ $day }}_close_time"
                        id="{{ $day }}_close_time"
                        @if (in_array($day, $service_days))
                            value="{{ $service->getDaytime($day)['to'] }}"
                        @else
                            value="{{ old($day .'_close_time') }}"
                        @endif
                        class="form-control">
                </div>
            </div>
        </div>
    </div>

    @push('js')
        <script>
            $("#{{ $day }}").on('change', function() {
                if ($(this).is(":checked")) {
                    $("#{{ $day }}-time").show();
                    $("#{{ $day }}_opening_time, #{{ $day }}_close_time").attr('required', 'required');
                } else {
                    $("#{{ $day }}-time").hide();
                    $("#{{ $day }}_opening_time, #{{ $day }}_close_time").val('').removeAttr('required');
                }
            });
        </script>
    @endpush
@endforeach
