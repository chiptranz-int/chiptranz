@component('mail::message')
# Hello {{ $data['name'] }}

You successfully saved on ChipTranz. Please go to your ChipTranz savings dashboard to see more on your savings.

### Plan Name: {{$data['planName']}} 
### Amount Saved: NGN {{$data['amount']}} 
### Next Charge Date: {{$data['nextDate']}} 

@component('mail::button', ['url'=> url('/login')])
Login to Dashboard
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
