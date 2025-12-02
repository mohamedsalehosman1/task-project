@extends('dashboard::layouts.default')

@section('title')
    @lang('products::products.plural')
@endsection

@section('content')
         @component('dashboard::layouts.components.page')

        @slot('title', trans('products::products.plural'))
        @slot('breadcrumbs', ['dashboard.products.index'])

        @include('products::products.partials.filter')

        @component('dashboard::layouts.components.table-box')
            @slot('title', trans('products::products.actions.list'))
            @slot('tools')
                @include('products::products.partials.actions.create')
            @endslot

            <thead>
                <tr>
                    <th>@lang('products::products.attributes.image')</th>
                    <th>@lang('products::products.attributes.name')</th>
                    <th>@lang('products::products.attributes.service')</th>
                    <th>@lang('products::products.attributes.vendor')</th>
                    <th>@lang('products::products.attributes.price')</th>
                    <th>@lang('products::products.attributes.available')</th>
                    <th style="width: 200px">...</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                    <tr>
                        <td class="d-none d-md-table-cell">
                            <img src="{{ $product->image }}" class="mr-2 rounded" width="64" height="64">
                        </td>
                        <td class="d-none d-md-table-cell">
                            {{ $product->name }}
                        </td>
                        <td class="d-none d-md-table-cell">
                            {{ $product->service->name ?? '_'}}
                        </td>
                        <td class="d-none d-md-table-cell">
                            {{ $product->vendor->name ?? $product->user_service_name }}
                        </td>
                        <td class="d-none d-md-table-cell">
                            {{ $product->price ?? "يحدد وقت القابله " }}
                        </td>
                      <td>
                            @include('dashboard::layouts.apps.activate', [
                                'item' => $product,
                                'url' => 'product/active/',
                            ])
                        </td>

                        <td style="width: 200px">
                            @include('products::products.partials.actions.show')
                            @include('products::products.partials.actions.edit')
                            @include('products::products.partials.actions.delete')
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="100" class="text-center">@lang('products::products.empty')</td>
                    </tr>
                @endforelse

                {{-- @if ($products->hasPages())
                    @slot('footer')
                        {{ $products->links() }}
                    @endslot
                @endif --}}
            @endcomponent
        @endcomponent

    @endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggles = document.querySelectorAll('.toggle-available');
        toggles.forEach(toggle => {
            toggle.addEventListener('change', function () {
                const productId = this.dataset.id;
                const available = this.checked ? 1 : 0;

                fetch(`/dashboard/products/${productId}/toggle-available`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ available: available })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        console.log('تم التحديث');
                    } else {
                        alert('حدث خطأ حاول مرة أخرى');
                    }
                });
            });
        });
    });
</script>
@endpush
