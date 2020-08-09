@component('mail::message')
# Hello {{ $data['name'] }}

We tried saving into your “{{ $data['planName']}}” plan, and it failed. Please sign in to your account, to add a different card or retry.

@component('mail::button', ['url'=> url('/login')])
Login
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
