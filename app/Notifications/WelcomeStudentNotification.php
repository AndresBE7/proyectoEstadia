<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class WelcomeStudentNotification extends Notification
{
    use Queueable;

    protected $student;
    protected $plainPassword;

    public function __construct($student, $plainPassword)
    {
        $this->student = $student;
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
                    ->greeting('¡Hola ' . $this->student->name . '!')
                    ->line('Bienvenido a Colegio Vida.')
                    ->line('Tu cuenta ha sido creada con éxito. A continuación, te dejamos los detalles de tu cuenta:')
                    ->line('Correo: ' . $this->student->email)
                    ->line('Contraseña: ' . $this->plainPassword) // Mostrar la contraseña en texto plano
                    ->line('Te sugerimos cambiar lo antes posible tu contraseña.')
                    ->line('Si deseas ayuda, contacta con un profesor.')
                    ->line('¡Buen día :)');
    }
}
