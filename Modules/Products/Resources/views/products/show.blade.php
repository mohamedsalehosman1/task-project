@extends('dashboard::layouts.default')

@section('title')
    {{ $product->name }}
@endsection

@section('content')
        {{-- @component('dashboard::layouts.components.page') --}}

        @slot('title', $product->name)
        @slot('breadcrumbs', ['dashboard.products.show', $product])

        <div class="row">
            <div class="col-md-6">
                @component('dashboard::layouts.components.box')
                    @slot('bodyClass', 'p-0')

                    <table class="table table-middle mb-0">
                        <tbody>
                            <tr>
                                <th width="200">@lang('products::products.attributes.name')</th>
                                <td>{{ $product->name }}</td>
                            </tr>

                            <tr>
                                <th>@lang('products::products.attributes.vendor')</th>
                                <td>{{ $product->vendor->name ?? '-' }}</td>
                            </tr>

                            <tr>
                                <th>@lang('products::products.attributes.service')</th>
                                <td>{{ $product->service->name ?? '-' }}</td>
                            </tr>

                            <tr>
                                <th>@lang('products::products.attributes.region')</th>
                                <td>{{ $product->region->name ?? '-' }}</td>
                            </tr>

                            <tr>
                                <th>@lang('products::products.attributes.price')</th>
                                <td>{{ number_format($product->price, 2) }}</td>
                            </tr>

                            <tr>
                                <th>@lang('products::products.attributes.old_price')</th>
                                <td>{{ $product->old_price ? number_format($product->old_price, 2) : '-' }}</td>
                            </tr>

                            <tr>
                                <th>@lang('products::products.attributes.status')</th>
                                <td>
                                    <span class="badge bg-{{ $product->status == 'accepeted' ? 'success' : ($product->status == 'rejected' ? 'danger' : 'warning') }}">
                                        {{ ucfirst($product->status) }}
                                    </span>
                                </td>
                            </tr>

                            <tr>
                                <th>@lang('products::products.attributes.active')</th>
                                <td>
                                    <span class="badge bg-{{ $product->active ? 'success' : 'secondary' }}">
                                        {{ $product->active ? __('Active') : __('Inactive') }}
                                    </span>
                                </td>
                            </tr>

                            <tr>
                                <th>@lang('products::products.attributes.image')</th>
                                <td>
                                    <img src="{{ $product->image }}" width="150" class="rounded shadow" alt="{{ $product->name }}">
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    @slot('footer')
                        @include('products::products.partials.actions.edit')
                        @include('products::products.partials.actions.delete')
                    @endslot
                @endcomponent
            </div>
        </div>

        {{-- ✅ عناوين المنتج --}}
        <div class="row mt-4">
            <div class="col-md-12">
                @component('dashboard::layouts.components.box')
                    @slot('title', __('عناوين المنتج'))

                    @if($product->addresses && $product->addresses->count() > 0)
                        <table class="table table-bordered table-striped mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>@lang('العنوان')</th>
                                    <th>@lang('المدى (كم)')</th>
                                    <th>@lang('نوع التغطية')</th>
                                    <th>@lang('نشط؟')</th>

                                    <th>@lang('الإحداثيات')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($product->addresses as $index => $address)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $address->name ?? '-' }}</td>
                                        <td>{{ $address->pivot->range ?? '-' }}</td>
                                        <td>{{ $address->pivot->type == 'pickup' ? 'استلام ذاتي' : 'توصيل' }}</td>
                                        <td>
                                            <span class="badge bg-{{ $address->pivot->active ? 'success' : 'secondary' }}">
                                                {{ $address->pivot->active ? 'نعم' : 'لا' }}
                                            </span>
                                        </td>

                                        <td>
                                            @if($address->pivot->latitude && $address->pivot->longitude)
                                                {{ $address->pivot->latitude }}, {{ $address->pivot->longitude }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="text-center text-muted py-3">
                            لا توجد عناوين مرتبطة بهذا المنتج.
                        </div>
                    @endif
                @endcomponent
            </div>
        </div>

    @endcomponent
@endsection
