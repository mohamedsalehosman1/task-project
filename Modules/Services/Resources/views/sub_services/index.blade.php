@include('services::sub_services.partials.filter')

@component('dashboard::layouts.components.table-box')
    @slot('title', trans('services::services.actions.sub'))
    <thead>
        <tr>
            <th>@lang('services::sub_services.attributes.image')</th>
            <th>@lang('services::sub_services.attributes.name')</th>
            <th>...</th>
        </tr>
    </thead>

    <tbody>
        @forelse($sub_services as $sub_service)
            <tr>
                <td class="d-none d-md-table-cell">
                    <img src="{{ $sub_service->getImage() }}" class="img-circle img-size-32 mr-2" style="height: 32px;">
                </td>
                <td>
                    {{ $sub_service->name }}
                </td>
                <td>
                    @include('services::sub_services.partials.actions.show')
                    @include('services::sub_services.partials.actions.edit')
                    @include('services::sub_services.partials.actions.delete')
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="100" class="text-center">@lang('services::sub_services.empty')</td>
            </tr>
        @endforelse

        @if ($sub_services->hasPages())
            @slot('footer')
                {{ $sub_services->links() }}
            @endslot
        @endif
    </tbody>
@endcomponent
