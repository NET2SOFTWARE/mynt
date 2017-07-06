@component('mail::message')
# Upgrade Notification

<strong>Account number : {{ $user->members->first()['accounts'][0]['number'] }}</strong><br/>
Your request for an account upgrade process is pending confirmation from the administrator. Your account will be systematically upgraded if your documents and data comply with our terms. Thank you

@component('mail::subcopy')
    <br/>
    And if you ever have any questions, feel free to contact us at :<br/>
    E-mail : info@artajasa.co.id<br/>
    Call : +6221 2970 6789<br/>
    Fax : +6221 2917 7001
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
