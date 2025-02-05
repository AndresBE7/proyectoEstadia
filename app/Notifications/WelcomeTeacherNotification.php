<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class WelcomeTeacherNotification extends Notification
{
    use Queueable;

    protected $teacher;
    protected $plainPassword;

    public function __construct($teacher, $plainPassword)
    {
        $this->teacher = $teacher;
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
                    ->greeting('¡Hola ' . $this->teacher->name . '!')
                    ->line('Bienvenido a Colegio Vida.')
                    ->line('Tu cuenta ha sido creada con éxito. A continuación, te dejamos los detalles de tu cuenta:')
                    ->line('Correo: ' . $this->teacher->email)
                    ->line('Contraseña: ' . $this->plainPassword) // Mostrar la contraseña en texto plano
                    ->line('Te sugerimos cambiar lo antes posible tu contraseña.')
                    ->line('Si deseas ayuda, contacta con un administrador.')
                    ->line('¡Buen día :)');
    }
}
