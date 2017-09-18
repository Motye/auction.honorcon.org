@component('mail::message')

Thank you for registering for the {{ config('app.name', 'Laravel') }}.  In order to place a bid, you must confirm your
email address by clicking the button below.  If you are unable to click on the button, copy and paste this link into
your web browser:

{{ route('confirm', $user->_id) }}

@component('mail::button', ['url' => route('confirm', $user->_id), 'color' => 'green'])
Confirm Email Address
@endcomponent


Thank You,<br>
The {{ config('app.name', 'Laravel') }} Team
@endcomponent
