@component('mail::message')
# Password reset code

Your password reset code is:

## {{ $code }}

This code will expire in 60 minutes.

Thanks,
{{ config('app.name') }}
@endcomponent
