<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class WelcomeUserNotification extends Notification
{
    use Queueable;

    protected $user;
    protected $plainPassword;

    public function __construct($user, $plainPassword)
    {
        $this->user = $user;
        $this->plainPassword = $plainPassword;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Bienvenido a Colegio Vida')
                    ->greeting('¡Hola ' . $this->user->name . '!')
                    ->line('Bienvenido a Colegio Vida.')
                    ->line('Tu cuenta ha sido creada con éxito. A continuación, te dejamos los detalles de tu cuenta:')
                    ->line('Correo: ' . $this->user->email)
                    ->line('Contraseña: ' . $this->plainPassword) // Mostrar la contraseña en texto plano
                    ->line('Te sugerimos cambiar lo antes posible tu contraseña.')
                    ->line('Si deseas ayuda, contacta con un profesor o un administrador.')
                    ->line('¡Buen día :)');
    }
}
