@component('mail::message')
Hola {{ $user->name }},

<p> Entiendo lo que esta pasando </p>


@component('mail::button', ['url' => url('reset/' . $user->remember_token)])
Restaurar Contraseña
@endcomponent

<p>En caso de tener problemas con la cuenta contacta a tu profesor</p>

Gracias<br>
Colegio Vida
@endcomponent
