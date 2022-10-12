@component('mail::message')
# Challenge Syncing Errors...
<br><br>

Errors: <br>

@foreach($errors as $code => $error)
{{$code}}: {{$error}}
@endforeach

Thanks,<br>
Challenge
@endcomponent
