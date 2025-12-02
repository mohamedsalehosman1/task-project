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
                                    <img src="{{ $vendor->getImage() }}" alt="{{ $vendor->name }}" width="150"
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
                                        <img src="{{ $item }}" alt="{{ $vendor->name }}" width="150" height="150">
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
                                frameborder="0" style="border:0" allowfullscreen></iframe>
                        </td>
                    </tr>
                </tbody>
            </table>

            @slot('footer')
                @if (!$vendor->deleted_at)
                    @include('vendors::vendors.partials.actions.edit')
                    @include('vendors::vendors.partials.actions.delete')
                    @include('vendors::vendors.partials.actions.block')
                @endif
            @endslot
        @endcomponent


        {{-- ==================== قسم المنتجات ==================== --}}
        <hr>

        @component('dashboard::layouts.components.box')
            @slot('title', __('Products of :name', ['name' => $vendor->name]))

            @if ($vendor->products->count())
                <div class="table-responsive">
                    <table class="table table-bordered table-striped mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('products::products.attributes.name')</th>
                                <th>@lang('products::products.attributes.price')</th>
                                <th>@lang('products::products.attributes.status')</th>
                                <th>@lang('products::products.attributes.image')</th>
                                <th>@lang('products::products.actions.actions')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($vendor->products as $product)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->price }} {{ $product->currency ?? 'SAR' }}</td>
                                    <td>
                                        @if ($product->available = 1)
                                            <span class="badge badge-success">@lang('Active')</span>
                                        @else
                                            <span class="badge badge-danger">@lang('Inactive')</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($product->getFirstMediaUrl('images'))
                                            <img src="{{ $product->getFirstMediaUrl('images') }}" alt="{{ $product->name }}"
                                                width="70" height="70" class="rounded">
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('dashboard.products.show', $product) }}"
                                            class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i> @lang('View')
                                        </a>
                                        <a href="{{ route('dashboard.products.edit', $product) }}"
                                            class="btn btn-sm btn-outline-warning">
                                            <i class="fas fa-edit"></i> @lang('Edit')
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-muted text-center my-3">@lang('No products found for this vendor.')</p>
            @endif
        @endcomponent

    @endcomponent
@endsection
