<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;

class ResetClientPasswordNotification extends ResetPassword
{
    use Queueable;

    public function toMail($notifiable): MailMessage
    {
        $resetUrl = url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));

        $minutes = (int) config('auth.passwords.'.config('auth.defaults.passwords').'.expire', 60);

        return (new MailMessage)
            ->subject('Recuperación de contraseña | Novitec')
            ->greeting('Hola '.$notifiable->full_name.',')
            ->line('Recibimos una solicitud para restablecer la contraseña de tu cuenta web de Novitec.')
            ->action('Restablecer contraseña', $resetUrl)
            ->line('Este enlace expirará en '.$minutes.' minutos.')
            ->line('Si no solicitaste este cambio, puedes ignorar este correo.');
    }
}
