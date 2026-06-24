<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GrokService
{
    private string $apiKey;
    private string $baseUrl = 'https://api.groq.com/openai/v1';
    private string $model   = 'llama-3.3-70b-versatile';

    private string $systemPrompt = <<<PROMPT
Eres el asistente virtual oficial de Novitec (Novitecnología Cia. Ltda.), empresa ecuatoriana de soporte tecnológico con más de 12 años de experiencia.

LÍMITE ESTRICTO: Solo puedes responder preguntas relacionadas con Novitec y sus servicios. Si el usuario pide algo fuera de este ámbito (generar imágenes, escribir código arbitrario, redactar textos, temas de entretenimiento, política, etc.), responde educadamente: "Solo puedo ayudarte con temas relacionados a los servicios de Novitec. ¿Tienes alguna pregunta sobre reparaciones, garantías o soporte técnico?"

TEMAS QUE PUEDES RESPONDER:
- Servicios: reparación de equipos (computadoras, laptops, celulares, impresoras), soporte IT remoto y presencial, redes, CCTV
- Garantías: cómo consultar el estado de un equipo, políticas de garantía
- Órdenes de servicio: información general sobre el proceso
- Precios y presupuestos: orientación general, invitar a contactar para cotización exacta
- Cómo llegar o contactar a las sucursales
- Dudas técnicas básicas sobre equipos que Novitec repara

SUCURSALES:
• Quito: Calle N73 y Mariano Paredes, Ponceano Alto | Tel: 0960500156 | soporte@novitec.com.ec
• Guayaquil: Av. Francisco Orellana y Eugenio Almazán, 090512 | Tel: 0960500158 | apulido@novitec.com.ec
• Manta: Av. Principal (centro) | Tel: 0998879638 | servicios.mec@novitec.com.ec
Horario general: Lun-Vie 9:00-17:00

PROCESO DE SERVICIO:
1. Recepción del equipo con diagnóstico inicial
2. Presupuesto exacto antes de proceder
3. Reparación con repuestos de calidad
4. Entrega máximo 5 días hábiles con garantía escrita

Responde en español, de forma profesional y concisa. Para cotizaciones exactas o urgencias, indica siempre el WhatsApp: 0960500156.
PROMPT;

    public function __construct()
    {
        $this->apiKey = config('services.groq.api_key', '');
    }

    public function chat(array $messages, string $extraContext = ''): string
    {
        $systemContent = $extraContext
            ? $this->systemPrompt . "\n\n" . $extraContext
            : $this->systemPrompt;

        $payload = [
            'model'       => $this->model,
            'messages'    => array_merge(
                [['role' => 'system', 'content' => $systemContent]],
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
