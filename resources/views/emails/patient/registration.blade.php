@component('mail::message')
# Welcome {{$patient->fullname}}!

<p>You have successfully registered in {{config('app.name')}}!</p>

@component('mail::panel')

<p>
These are your credentials: <br>
<strong>email:</strong> {{$patient->email}} <br>
<strong>password:</strong> {{$password}}</samp>
</p>

@endcomponent

@component('mail::button', ['url' => $url])
Click here to Login
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
