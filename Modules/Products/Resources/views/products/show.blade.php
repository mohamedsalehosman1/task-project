@extends('dashboard::layouts.default')

@section('title')
    {{ $product->name }}
@endsection
@section('content')
    @component('dashboard::layouts.components.page')
        @slot('title', $product->name)
        @slot('breadcrumbs', ['dashboard.products.show', $product])

        <div class="row">
            <div class="col-md-6">
                @component('dashboard::layouts.components.box')
                    @slot('bodyClass', 'p-0')

                    <table class="table table-middle">
                        <tbody>
                            <tr>
                                <th width="200">@lang('products::products.attributes.name')</th>
                                <td>{{ $product->name }}</td>
                            </tr>
                            <tr>
                                <th width="200">@lang('products::products.attributes.image')</th>
                                <td>
                                    <img src="{{ $product->image }}" width="150" class="rounded" alt="{{ $product->name }}">
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




        <div class="col-md-6">
            @if (count($variances = $product->productVariances()->with('size', 'color')->get()->groupBy('size_id')) > 0)
                @component('dashboard::layouts.components.accordion-table')
                    @slot('bodyClass', 'p-0')
                    @slot('title', trans('products::product_variances.plural'))

                    <tr>
                        <th width="200">#</th>
                        <th width="200">@lang('sizes::sizes.singular')</th>
                        <th width="200">@lang('colors::colors.singular')</th>
                        <th width="200">@lang('products::products.attributes.quantity')</th>

                    </tr>

                    @forelse ($variances as $variance)
                        <tr rowspan='100'>
                            <td width="200">
                                {{ $loop->iteration }}
                            </td>

                            <td width="200">
                                {{ $variance->first()->size->name }}
                            </td>

                            <td>
                                <table>
                                    @foreach ($variance as $color)
                                        <tr style="background: none">
                                            <td>
                                                {{ $color->color->name }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </td>

                            <td>
                                <table>
                                    @foreach ($variance as $color)
                                        <tr style="background: none">
                                            <td>
                                                {{ $color->quantity }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
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
