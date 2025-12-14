@extends('dashboard::layouts.default')

@section('title')
    {{ $vendorService->service->name }}
@endsection
@section('content')
    @component('dashboard::layouts.components.page')
        @slot('title', $vendorService->service->name)
        @slot('breadcrumbs', ['dashboard.services.show', $vendorService->service])

        <div class="row">
            <div class="col-md-12">
                @component('dashboard::layouts.components.box')
                    @slot('bodyClass', 'p-0')

                    <table class="table table-middle">
                        <tbody>
                            <tr>
                                <th width="200">@lang('services::services.attributes.name')</th>
                                <td>
                                    {{ $vendorService->service->name }}
                                </td>
                            </tr>

                            <tr>
                                <th width="200">@lang('vendors::vendors.singular')</th>
                                <td>
                                    {{ $vendorService->vendor->name }}
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    @slot('footer')
                        @include('services::vendor-services.partials.actions.edit')
                        @include('services::vendor-services.partials.actions.delete')
                    @endslot
                @endcomponent
            </div>
        </div>

        <div class="row">

            <div class="col-md-12">
                @if (count($vendorService->prices) > 0)
                    @component('dashboard::layouts.components.accordion-table')
                        @slot('bodyClass', 'p-0')
                        @slot('title', trans('services::services.attributes.prices'))

                        <tr>
                            <th width="200">#</th>
                            <th width="200">@lang('items::items.singular')</th>
                            <th width="200">@lang('services::services.attributes.price')</th>
                            <th width="200">@lang('services::services.attributes.express_price')</th>

                        </tr>

                        @forelse ($vendorService->prices as $price)
                            <tr>
                                <td width="200">
                                    {{ $loop->iteration }}
                                </td>
                                <td width="200">
                                    {{ $price->item->name }}
                                </td>
                                <td width="200">
                                    {{ $price->price }}
                                </td>
                                <td width="200">
                                    {{ $price->express_price ?? '---' }}
                                </td>
                            </tr>
                        @empty
                        @endforelse
                    @endcomponent
                @endif
            </div>
        </div>
    @endcomponent
@endsection
