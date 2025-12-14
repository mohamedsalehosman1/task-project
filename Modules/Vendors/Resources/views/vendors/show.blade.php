@extends('dashboard::layouts.default')

@section('title')
    {{ $vendor->name }}
@endsection

@section('content')
    @component('dashboard::layouts.components.page')
        @slot('title', $vendor->name)
        @slot('breadcrumbs', ['dashboard.vendors.show', $vendor])


        @component('dashboard::layouts.components.box')
            @slot('bodyClass', 'p-0')

            <table class="table table-middle">
                <tbody>
                    <tr>
                        <th>@lang('vendors::vendors.attributes.name')</th>
                        <td>{{ $vendor->name }}</td>
                    </tr>
                    <tr>
                        <th>@lang('vendors::vendors.attributes.email')</th>
                        <td>{{ $vendor->email }}</td>
                    </tr>
                    <tr>
                        <th>@lang('vendors::vendors.attributes.phone')</th>
                        <td>{{ $vendor->phone }}</td>
                    </tr>
                    <tr>
                        <th>@lang('vendors::vendors.attributes.verified')</th>
                        <td>@include('vendors::vendors.partials.flags.verified')</td>
                    </tr>
                    <tr>
                        <th>@lang('vendors::vendors.attributes.image')</th>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="symbol symbol-70 symbol-sm flex-shrink-0">
                                    <img class="" src="{{ $vendor->getImage() }}" alt="{{ $vendor->name }}" width="150"
                                        height="150">
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th>@lang('vendors::vendors.attributes.banners')</th>
                        <td>
                            <div class="d-flex align-items-center" style="gap:5px">
                                @foreach ($vendor->getBanners() as $item)
                                    <div class="symbol symbol-70 symbol-sm flex-shrink-0">
                                        <img class="" src="{{ $item }}" alt="{{ $vendor->name }}" width="150"
                                            height="150">
                                    </div>
                                @endforeach
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th>@lang('vendors::vendors.attributes.address')</th>
                        <td>{{ $vendor->address }}</td>
                    </tr>
                    <tr>
                        <th>@lang('vendors::vendors.attributes.map')</th>
                        <td>
                            <iframe style="height: 400px; width: 1000px;"
                                src="https://maps.google.com/maps?q={{ $vendor->lat ?? '' }},{{ $vendor->long ?? '' }}&hl=es;z=14&amp;output=embed"
                                frameborder="0" style="border:0 " allowfullscreen></iframe>
                        </td>
                    </tr>
                </tbody>
            </table>

            @slot('footer')
            @if(!$vendor->deleted_at)
                @include('vendors::vendors.partials.actions.edit')
                @include('vendors::vendors.partials.actions.delete')
                @include('vendors::vendors.partials.actions.block')

            @endif
            @endslot
        @endcomponent



    @endcomponent
@endsection
