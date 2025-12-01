@extends('dashboard::layouts.default')

@section('title')
    {{ $category->name }}
@endsection
@section('content')
    @component('dashboard::layouts.components.page')
        @slot('title', $category->name)
        @slot('breadcrumbs', ['dashboard.categories.show', $category])

        <div class="row">
            <div class="col-md-6">
                @component('dashboard::layouts.components.box')
                    @slot('bodyClass', 'p-0')

                    <table class="table table-middle">
                        <tbody>
                        <tr>
                            <th width="200">@lang('categories::categories.attributes.name')</th>
                            <td>{{ $category->name }}</td>
                        </tr>
                        <!-- <tr>
                            <th width="200">@lang('categories::categories.attributes.image')</th>
                            <td>
                                <img src="{{ $category->getImage() }}"
                                     class="img img-size-"
                                     width="200"
                                     alt="{{ $category->name }}">
                            </td>
                        </tr> -->
                        </tbody>
                    </table>

                    @slot('footer')
                        @include('categories::categories.partials.actions.edit')
                        @include('categories::categories.partials.actions.delete')
                    @endslot
                @endcomponent
            </div>
        </div>

    @endcomponent
@endsection
