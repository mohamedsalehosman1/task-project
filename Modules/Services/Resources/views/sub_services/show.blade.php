@extends('dashboard::layouts.default')

@section('title')
    {{ $sub_service->name }}
@endsection

@section('content')
    @component('dashboard::layouts.components.page')
        @slot('title', $sub_service->name)
        @slot('breadcrumbs', ['dashboard.services.show', $sub_service])

        <div class="row">
            <div class="col-md-6">
                @component('dashboard::layouts.components.box')
                    @slot('bodyClass', 'p-0')

                    <table class="table table-middle">
                        <tbody>
                            <tr>
                                <th width="200">@lang('services::services.attributes.name')</th>
                                <td>{{ $sub_service->name }}</td>
                            </tr>
                            <tr>
                                <th width="200">@lang('services::services.attributes.image')</th>
                                <td>
                                    <img src="{{ $sub_service->getImage() }}" class="mr-2 img-thumbnail" width="150px">
                                </td>
                            </tr>

                        </tbody>
                    </table>

                    @slot('footer')
                        @include('services::sub_services.partials.actions.edit', ['service' => $sub_service->parent , 'sub_service' => $sub_service])
                        @include('services::sub_services.partials.actions.delete', ['service' => $sub_service->parent , 'sub_service' => $sub_service])
                    @endslot
                @endcomponent

                {{-- @include('services::sub_services.create', ['service' => $sub_service]) --}}
            </div>
            {{-- <div class="col-md-6">
                @if (count($sub_services) > 0)
                    @include('services::sub_services.index', ['service' => $sub_service])
                @endif
            </div> --}}
        </div>
    @endcomponent
@endsection
