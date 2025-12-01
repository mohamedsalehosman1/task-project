@if($vendor->blocked_at != null)
    <i class="fas fa-ban text-danger"></i>
@else
    <i class="fas fa-check fa-lg text-success"></i>
@endif
