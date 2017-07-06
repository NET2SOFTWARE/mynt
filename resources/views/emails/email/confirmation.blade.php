@component('mail::message')
# Email confirmation

<strong>Please confirm your e-mail address</strong>, to confirm your account. If you received this by mistake or were not expecting it, please disregard this e-mail.

@component('mail::button', ['url' => route('account.confirmed', [$token])])
    Confirm email
@endcomponent

@component('mail::subcopy')
    Please note that your registration will not be complete until you click the button above.<br/>
    <br/>
    And if you ever have any questions, feel free to contact us at :<br/>
    E-mail : info@artajasa.co.id<br/>
    Call : +6221 2970 6789<br/>
    Fax : +6221 2917 7001
@endcomponent

Thanks,<br>
MYNT Emoney

@component('mail::subcopy')
If you are having trouble clicking the account confirmation button, copy and paste the URL below
into your web browser : {{ route('account.confirmed', [$token]) }}
@endcomponent
@endcomponent