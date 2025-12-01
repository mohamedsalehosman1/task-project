@if (Session::has('errors'))
    toastr.error("{{ Session::get('errors') }}");
@endif

@if (Session::has('success'))
    toastr.success("{{ Session::get('success') }}");
@endif

