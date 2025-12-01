@extends('dashboard::layouts.default')

@section('title')
    @lang('products::products.actions.pending_requests')
@endsection

@section('content')
        {{-- @component('dashboard::layouts.components.page') --}}

        @slot('title', trans('products::products.actions.pending_requests'))
        @slot('breadcrumbs', ['requests'])

        @component('dashboard::layouts.components.table-box')
            @slot('title', trans('products::products.actions.pending_list'))

            <thead>
                <tr>
                    <th>@lang('products::products.attributes.image')</th>
                    <th>@lang('products::products.attributes.name')</th>
                    <th>@lang('products::products.attributes.service')</th>
                    <th>@lang('products::products.attributes.vendor')</th>
                    <th>@lang('products::products.attributes.price')</th>
                    <th style="width: 200px">@lang('products::products.actions.actions')</th>
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
                            {{ $product->service->name ?? '_' }}
                        </td>
                        <td class="d-none d-md-table-cell">
                            {{ $product->vendor->name ?? $product->user_service_name }}
                        </td>
                        <td class="d-none d-md-table-cell">
                            {{ $product->price ?? 'يحدد وقت القابله ' }}
                        </td>
                        <td>
                              @if (auth()->user()->isVendor())
                            @include('products::products.partials.actions.show')
                            @include('products::products.partials.actions.delete')

                            @else
                            @include('products::products.partials.actions.show')
                            @include('products::products.partials.actions.edit')
                            @include('products::products.partials.actions.delete')
                            @if ($product instanceof \Modules\Products\Entities\UserProduct)
                                <form action="{{ route('acceptuserproduct', $product->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-sm btn-success" title="@lang('products::products.actions.accept')">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('acceptproduct', $product->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-sm btn-success" title="@lang('products::products.actions.accept')">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </form>
                            @endif
                            @if ($product instanceof \Modules\Products\Entities\UserProduct)
                                <form action="{{ route('rejectuserproduct', $product->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-sm btn-danger" title="@lang('products::products.actions.reject')">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('rejectproduct', $product->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-sm btn-danger" title="@lang('products::products.actions.reject')">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </form>
                            @endif
                            @endif

                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="100" class="text-center text-muted">
                            @lang('products::products.empty_pending')
                        </td>
                    </tr>
                @endforelse
            </tbody>

            {{-- @if ($product->hasPages())
                @slot('footer')
                    {{ $product->links() }}
                @endslot
            @endif --}}
        @endcomponent
    @endcomponent
@endsection
