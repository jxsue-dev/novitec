<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderStatusNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $nro_orden;
    public $estado;
    public $equipo;
    public $sucursal;
    public $cliente;

    public function __construct(string $nro_orden, string $estado, string $equipo, string $sucursal, string $cliente)
    {
        $this->nro_orden = $nro_orden;
        $this->estado = $estado;
        $this->equipo = $equipo;
        $this->sucursal = $sucursal;
        $this->cliente = $cliente;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Actualización de tu orden ' . $this->nro_orden . ' – Novitec',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.order-status',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
