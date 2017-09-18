@component('mail::message')

Dear {{ $user->name }},

Your bid for seat {{$seat}} in the Larry Correia charity RPG game has been beaten!

@component('mail::button', ['url' => route('home'), 'color' => 'green'])
Bid Again!
@endcomponent


Thank You,<br>
The {{ config('app.name', 'Laravel') }} Team
@endcomponent