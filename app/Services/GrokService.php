<?php

namespace App\Services;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class GrokService
{
    private string $apiKey;
    private string $baseUrl = 'https://api.x.ai/v1';
    private string $model   = 'grok-3-mini';

    private string $systemPrompt = <<<PROMPT
Eres el asistente virtual inteligente de Novitec (Novitecnología Cia. Ltda.), empresa ecuatoriana especializada en soporte tecnológico con más de 12 años de experiencia.

Puedes ayudar con:
- Servicios de Novitec: reparación de equipos, soporte IT remoto y presencial, infraestructura de redes, CCTV
- Garantías y estado de órdenes de servicio
- Preguntas generales de tecnología y soporte técnico
- Recomendaciones sobre equipos, software y soluciones IT

Información de contacto:
- Quito: N73 & Mariano Paredes, Ponceano Alto | Tel: 0960500156
- WhatsApp: 0960500156
- Email: soporte@novitec.com.ec
- Horario: Lun-Vie 9:00-17:00

Responde siempre en español, de forma profesional pero amigable y concisa. Si el usuario tiene un problema técnico, guíalo paso a paso. Si necesita un servicio presencial, invítalo a contactar o visitar Novitec.
PROMPT;

    public function __construct()
    {
        $this->apiKey = config('services.grok.api_key', '');
    }

    public function chat(array $messages): string
    {
        $payload = [
            'model'       => $this->model,
            'messages'    => array_merge(
                [['role' => 'system', 'content' => $this->systemPrompt]],
                $messages
            ),
            'max_tokens'  => 1024,
            'temperature' => 0.7,
        ];

        $response = Http::withToken($this->apiKey)
            ->timeout(30)
            ->post("{$this->baseUrl}/chat/completions", $payload);

        if ($response->failed()) {
            throw new \RuntimeException('Error al conectar con Grok: ' . $response->body());
        }

        return $response->json('choices.0.message.content', 'Lo siento, no pude generar una respuesta.');
    }
}
