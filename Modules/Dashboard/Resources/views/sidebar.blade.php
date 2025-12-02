@component('dashboard::layouts.components.sidebarItem')
    @slot('url', route('dashboard.home'))
    @slot('name', trans('dashboard::dashboard.home'))
    @slot('icon', 'fas fa-layer-group')
    @slot('routeActive', 'dashboard.home')
@endcomponent
@include('accounts::admins.sidebar')
@include('roles::_sidebar')
@include('accounts::users.sidebar')
{{-- @include('addresses::.sidebar') --}}
{{-- @include('vendors::vendors.sidebar') --}}
{{-- @include('services::services.sidebar') --}}
@include('products::products.sidebar')

{{-- @include('advertisements::advertisements.sidebar') --}}
@include('orders::orders.sidebar')
@include('notifications::notifications.sidebar')

@include('settings::contact-us.sidebar')
{{-- @include('f_a_qs::f_a_qs.sidebar') --}}

@include('dashboard::sidebar.settings')


