@component('mail::message')
# Hi {{$userFirstName}},

Your plan has matured. You can now withdraw or rollover to enjoy the benefits of compound interest. Rolling over your balance gives you the opportunity of earning interest on your already earned interests.

## Plan Name:           {{$planName}} 
## Amount at Maturity: NGN {{$amount}} 

@component('mail::button', ['url'=> url('/login')])
Login
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
