@component('dashboard::layouts.components.sidebarItem')
    @slot('url', route('dashboard.home'))
    @slot('name', trans('dashboard::dashboard.home'))
    @slot('icon', 'fas fa-layer-group')
    @slot('routeActive', 'dashboard.home')
@endcomponent
<!-- Admins -->
@include('accounts::admins.sidebar')
<!-- Roles -->
@include('accounts::users.sidebar')

@include('roles::_sidebar')
<!-- categories -->
@include('categories::categories.sidebar')
<!-- services -->
@include('products::products.sidebar')
<!-- projects -->

<!-- employees -->
{{-- @include('employees::employees.sidebar') --}}
<!-- sliders -->
{{-- @include('sliders::sliders.sidebar') --}}
 <!-- news -->
{{-- @include('blogs::blogs.sidebar') --}}
<!-- testimonials -->
{{-- @include('testimonials::testimonials.sidebar') --}}
<!-- supports -->
{{-- @include('sliders::supports.sidebar') --}}

<!-- jobs -->
{{-- @include('jobs::jobs.sidebar') --}}
<!-- why us ? -->
{{-- @include('howknow::sidebar') --}}
<!-- branches ? -->
{{-- @include('sliders::branches.sidebar') --}}
<!-- pages -->
{{-- @include('settings::pages-sidebar') --}}
{{-- @include('sliders::certificates.sidebar') --}}
{{-- @include('sliders::galleries.sidebar') --}}
{{-- @include('settings::intro-sidebar') --}}
{{-- @include('projects::projects.sidebar') --}}

<!-- Subscriptions -->
{{-- @include('settings::subscription-sidebar') --}}
<!-- settings -->
{{-- @include('dashboard::sidebar.settings') --}}
