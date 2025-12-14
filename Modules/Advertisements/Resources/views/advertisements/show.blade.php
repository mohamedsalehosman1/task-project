@extends('dashboard::layouts.default')

@section('title')
    {{ $advertisement->title }}
@endsection
@section('content')
    @component('dashboard::layouts.components.page')
        @slot('title', $advertisement->title)
        @slot('breadcrumbs', ['dashboard.advertisements.show', $advertisement])

        <div class="row">
            <div class="col-md-12">
                @component('dashboard::layouts.components.box')
                    @slot('bodyClass', 'p-0')

                    <table class="table table-middle">
                        <tbody>
                            <tr>
                                <th width="200">@lang('advertisements::advertisements.attributes.title')</th>
                                <td>{{ $advertisement->title }}</td>
                            </tr>
                            <tr>
                                <th>@lang('advertisements::advertisements.attributes.description')</th>
                                <td>{{ $advertisement->description }}</td>
                            </tr>
                            <tr>
                                <th width="200">@lang('advertisements::advertisements.attributes.image')</th>
                                <td>
                                    <img src="{{ $advertisement->getFirstMediaUrl('images') }}" class="mr-2 img-thumbnail"
                                        style="width: 140px; height: 110px;">
                                </td>
                            </tr>
                            @if ($advertisement->vendor)
                                <tr>
                                    <th width="200">@lang('advertisements::advertisements.attributes.vendor')</th>
                                    <td><a href="{{ route('dashboard.vendors.show', $advertisement->vendor) }}">
                                            {{ $advertisement->vendor->name }}</a></td>
                                </tr>
                            @endif
                            <tr>
                                <th width="200">@lang('advertisements::advertisements.attributes.active')</th>
                                <td>
                                    @include('dashboard::layouts.apps.flag', [
                                        'bool' => $advertisement->active,
                                    ])
                                </td>
                            </tr>
                            <tr>
                                <th width="200">@lang('advertisements::advertisements.attributes.auto_popup')</th>
                                <td>
                                    @include('dashboard::layouts.apps.flag', [
                                        'bool' => $advertisement->auto_popup,
                                    ])
                                </td>
                            </tr>
                            <tr>
                                <th width="200">@lang('advertisements::advertisements.attributes.defined')</th>
                                <td>
                                    @include('dashboard::layouts.apps.flag', [
                                        'bool' => $advertisement->defined,
                                    ])
                                </td>
                            </tr>
                            @if ($advertisement->defined)
                                <tr>
                                    <th width="200">@lang('advertisements::advertisements.attributes.expire')</th>
                                    <td>
                                        @include('dashboard::layouts.apps.flag', [
                                            'bool' => $advertisement->isExpired(),
                                        ])
                                    </td>
                                </tr>
                                <tr>
                                    <th>@lang('advertisements::advertisements.attributes.start_at')</th>
                                    <td>{{ Carbon\Carbon::parse($advertisement->start_at)->format('d/m/Y') }}</td>
                                </tr>
                                <tr>
                                    <th>@lang('advertisements::advertisements.attributes.end_at')</th>
                                    <td>{{ Carbon\Carbon::parse($advertisement->end_at)->format('d/m/Y') }}</td>
                                </tr>
                                <tr>
                                    <th width="200">@lang('advertisements::advertisements.attributes.duration')</th>
                                    <td>{{ $advertisement->duration }}</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>

                    @slot('footer')
                        @include('advertisements::advertisements.partials.actions.edit')
                        @include('advertisements::advertisements.partials.actions.delete')
                    @endslot
                @endcomponent
            </div>
        </div>
    @endcomponent

    {{-- @include('advertisements::subadvertisements.index') --}}
@endsection
