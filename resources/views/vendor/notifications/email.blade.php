@component('mail::message')
{{-- Greeting --}}
@if (! empty($greeting))
# {{ $greeting }}
@else
@if ($level == 'error')
# Whoops!
@else
# Hello!
@endif
@endif

{{-- Intro Lines --}}
@foreach ($introLines as $line)
{{ $line }}

@endforeach

{{-- Action Button --}}
@isset($actionText)
<?php
    switch ($level) {
        case 'success':
            $color = 'green';
            break;
        case 'error':
            $color = 'red';
            break;
        default:
            $color = 'blue';
    }
?>
@component('mail::button', ['url' => $actionUrl, 'color' => $color])
{{ $actionText }}
@endcomponent
@endisset

{{-- Outro Lines --}}
@foreach ($outroLines as $line)
{{ $line }}

@endforeach

@component('mail::subcopy')
    Please note that your registration will not be complete until you click the button above.<br/>
    <br/>
    And if you ever have any questions, feel free to contact us at :<br/>
    E-mail : info@artajasa.co.id<br/>
    Call : +6221 2970 6789<br/>
    Fax : +6221 2917 7001
@endcomponent

<!-- Salutation -->
@if (! empty($salutation))
{{ $salutation }}
@else
Thanks,<br>
MYNT Emoney
@endif

<!-- Subcopy -->
@isset($actionText)
@component('mail::subcopy')
If you’re having trouble clicking the "{{ $actionText }}" button, copy and paste the URL below
into your web browser: [{{ $actionUrl }}]({{ $actionUrl }})
@endcomponent
@endisset
@endcomponent
