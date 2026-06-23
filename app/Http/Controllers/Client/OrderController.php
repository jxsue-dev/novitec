<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    public function index()
    {
        $identificaciones = auth()->user()->orderLookupIdentifications();

        $orders = empty($identificaciones)
            ? new Collection()
            : Order::whereIn('identificacion', $identificaciones)
                ->orderByDesc('fecha_de_ingreso')
                ->get();

        return view('client.orders', compact('orders'));
    }

    public function show($nro_orden)
    {
        $identificaciones = auth()->user()->orderLookupIdentifications();

        $order = Order::whereIn('identificacion', $identificaciones)
            ->where('nro_orden', $nro_orden)
            ->firstOrFail();

        return view('client.order-detail', compact('order'));
    }

    public function sendSugerencia(Request $request)
    {
        $request->validate([
            'texto' => ['required', 'string', 'min:10'],
        ]);

        $user = auth()->user();
        $nombres = strtoupper(trim($user->nombres ?? $user->name));
        $apellidos = strtoupper(trim($user->apellidos ?? ''));
        $texto = trim($request->texto);
        $fecha = now()->format('d/m/Y H:i');
        $identificacion = $user->identificacion ?? $user->cedula ?? '';
        $telefono = $user->phone ?? '';
        $correo = $user->email;

        try {
            Mail::html($this->sugerenciaHtml($nombres, $apellidos, $identificacion, $telefono, $correo, $texto, $fecha), function ($m) use ($nombres, $apellidos) {
                $m->to('administracion@novitec.com.ec')
                  ->subject("Sugerencia de Cliente — $nombres $apellidos");
            });
        } catch (\Exception $e) {
            return response()->json(['ok' => false, 'error' => 'No se pudo enviar la sugerencia. Por favor, intenta de nuevo.']);
        }

        return response()->json(['ok' => true]);
    }

    private function sugerenciaHtml($nombres, $apellidos, $ci, $tel, $correo, $texto, $fecha)
    {
        $nombres = htmlspecialchars($nombres);
        $apellidos = htmlspecialchars($apellidos);
        $ci = htmlspecialchars($ci);
        $tel = htmlspecialchars($tel);
        $correo = htmlspecialchars($correo);
        $fecha = htmlspecialchars($fecha);

        return "
        <div style='font-family:Arial,sans-serif;max-width:520px;margin:auto;'>
          <div style='background:#059669;padding:20px 28px;border-radius:8px 8px 0 0;'>
            <h2 style='color:#fff;margin:0;'>Nueva Sugerencia Recibida</h2>
            <p style='color:rgba(255,255,255,.75);margin:4px 0 0;font-size:13px;'>Club Novitec Web — $fecha</p>
          </div>
          <div style='background:#f9fafb;padding:24px 28px;border:1px solid #e5e7eb;border-top:none;border-radius:0 0 8px 8px;'>
            <table style='width:100%;font-size:13px;border-collapse:collapse;margin-bottom:16px;'>
              <tr><td style='padding:6px 0;color:#6b7280;width:38%;'>Cliente</td><td style='padding:6px 0;font-weight:600;color:#111;'>$nombres $apellidos</td></tr>
              <tr><td style='padding:6px 0;color:#6b7280;border-top:1px solid #f1f5f9;'>C.I. / RUC</td><td style='padding:6px 0;border-top:1px solid #f1f5f9;'>" . ($ci ?: '—') . "</td></tr>
              <tr><td style='padding:6px 0;color:#6b7280;border-top:1px solid #f1f5f9;'>Teléfono</td><td style='padding:6px 0;border-top:1px solid #f1f5f9;'>" . ($tel ?: '—') . "</td></tr>
              <tr><td style='padding:6px 0;color:#6b7280;border-top:1px solid #f1f5f9;'>Correo</td><td style='padding:6px 0;border-top:1px solid #f1f5f9;'>" . ($correo ?: '—') . "</td></tr>
            </table>
            <div style='background:#fff;border-left:4px solid #059669;padding:14px 18px;border-radius:0 8px 8px 0;font-size:14px;color:#374151;line-height:1.7;'>
              " . nl2br(htmlspecialchars($texto)) . "
            </div>
          </div>
        </div>";
    }
}
