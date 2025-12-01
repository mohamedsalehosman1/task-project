@php($u = $user ?? $account ?? $admin ?? $model ?? $row ?? null)

@if(optional($u)->blocked_at)
    <i class="fas fa-ban text-danger" title="Blocked"></i>
@else
    <i class="fas fa-check fa-lg text-success" title="Active"></i>
@endif
