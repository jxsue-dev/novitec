<?php

namespace App\Http\Controllers;

use App\Support\IdentityDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class WarrantyController extends Controller
{
    public function index()
    {
        return view('pages.warranties');
    }

    public function validarFactura(Request $request)
    {
        $nro = trim($request->get('nro', ''));
        if (!preg_match('/^(\d{3})-\d{3}-\d{9,15}$/', $nro, $m)) {
            return response()->json(['ok' => false, 'error' => 'Formato de factura inválido.']);
        }
        $num_suc = (int)$m[1];
        if ($num_suc < 1 || $num_suc > 177) {
            return response()->json(['ok' => false, 'error' => 'El primer bloque debe ser del 001 al 177.']);
        }

        $sc = DB::connection('novitecdb')
            ->table('sucursalescliente')
            ->where('numero', $num_suc)
            ->where('activa', 1)
            ->select('id', 'codigo', 'nombre', 'novitec_sucursal')
            ->first();

        if (!$sc) {
            return response()->json(['ok' => false, 'error' => "La sucursal $num_suc no está registrada."]);
        }
        if (empty($sc->novitec_sucursal)) {
            return response()->json(['ok' => false, 'error' => "La sucursal $num_suc no tiene sucursal Novitec asignada."]);
        }

        $sn = DB::connection('novitecdb')
            ->table('sucursales')
            ->where('secuencial', $sc->novitec_sucursal)
            ->select('id', 'secuencial', 'ciudad')
            ->first();

        if (!$sn) {
            return response()->json(['ok' => false, 'error' => "No se encontró la sucursal Novitec."]);
        }

        return response()->json([
            'ok'              => true,
            'suc_cliente_id'  => $sc->id,
            'suc_cliente_cod' => $sc->codigo,
            'suc_cliente_nom' => $sc->nombre,
            'novitec_suc'     => $sc->novitec_sucursal,
            'novitec_suc_id'  => $sn->id,
            'novitec_ciudad'  => $sn->ciudad,
            'secuencial'      => $sn->secuencial,
        ]);
    }

    public function buscarProducto(Request $request)
    {
        $codigo = strtoupper(trim($request->get('codigo', '')));
        if (!$codigo) return response()->json(['ok' => false]);

        $producto = DB::connection('novitecdb')
            ->table('productosinventario as pi')
            ->join('marcas as m', 'pi.marca_id', '=', 'm.id')
            ->leftJoin('tiposdispositivo as td', 'pi.tipo_dispositivo_id', '=', 'td.id')
            ->where('pi.codigo', $codigo)
            ->select('pi.codigo', 'pi.descripcion', 'm.nombre as marca', 'td.nombre as tipo_nombre')
            ->first();

        if (!$producto) return response()->json(['ok' => false]);

        return response()->json(['ok' => true, 'producto' => $producto]);
    }

    public function guardar(Request $request)
    {
        if (! $request->user()) {
            return response()->json(['ok' => false, 'error' => 'Debes iniciar sesion para registrar tu preorden.'], 401);
        }

        $request->validate([
            'nro_factura'       => 'required|string',
            'suc_cliente_id'    => 'required|integer',
            'novitec_suc_id'    => 'required|integer',
            'secuencial'        => 'required|string',
            'nombres'           => 'required|string',
            'apellidos'         => 'required|string',
            'identificacion'    => 'required|string|min:10|max:13',
            'telefono'          => ['required', 'regex:/^09\d{8}$/'],
            'correo'            => 'required|email',
            'ciudad_procedencia' => 'required|string|max:100',
            'codigo_producto'   => 'required|string',
            'fecha_facturacion' => 'required|date',
            'detalle_equipo'    => 'required|string',
            'foto_1'            => 'required|image|max:5120',
            'foto_2'            => 'required|image|max:5120',
            'foto_3'            => 'required|image|max:5120',
            'foto_4'            => 'required|image|max:5120',
        ]);

        $userIdentity = IdentityDocument::canonicalize($request->user()->identificacion ?: $request->user()->cedula);
        $requestIdentity = IdentityDocument::canonicalize($request->identificacion);

        if ($userIdentity === '' || $requestIdentity !== $userIdentity) {
            return response()->json([
                'ok' => false,
                'error' => 'La identificacion de la preorden debe coincidir con la de tu cuenta.',
            ], 422);
        }

        $codigo_prod = strtoupper(trim($request->codigo_producto));
        $producto = DB::connection('novitecdb')
            ->table('productosinventario as pi')
            ->join('marcas as m', 'pi.marca_id', '=', 'm.id')
            ->leftJoin('tiposdispositivo as td', 'pi.tipo_dispositivo_id', '=', 'td.id')
            ->where('pi.codigo', $codigo_prod)
            ->select('pi.codigo', 'pi.descripcion', 'm.nombre as marca', 'td.nombre as tipo_nombre')
            ->first();

        if (!$producto) {
            return response()->json(['ok' => false, 'error' => 'Código de producto no encontrado.']);
        }

        $nro_preorden = $this->generarNroPreorden($request->secuencial);

        // Subir fotos
        $fotos = [];
        $uploadDir = base_path('../public_html/images/warranties');
        if (!file_exists($uploadDir)) mkdir($uploadDir, 0755, true);

        for ($i = 1; $i <= 4; $i++) {
            $file = $request->file("foto_$i");
            $filename = $nro_preorden . '_f' . $i . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move($uploadDir, $filename);
            $fotos[$i] = 'images/warranties/' . $filename;
        }

        // Insertar en PreOrdenes
        DB::connection('novitecdb')->table('preordenes')->insert([
            'nro_preorden'       => $nro_preorden,
            'sucursal_id'        => $request->novitec_suc_id,
            'nro_sucursal_cliente' => $request->suc_cliente_id,
            'nombres'            => strtoupper($request->nombres),
            'apellidos'          => strtoupper($request->apellidos),
            'identificacion'     => preg_replace('/\D/', '', $request->identificacion),
            'telefono'           => $request->telefono,
            'correo'             => $request->correo,
            'ciudad_procedencia' => strtoupper(trim($request->ciudad_procedencia)),
            'nro_factura'        => $request->nro_factura,
            'fecha_facturacion'  => $request->fecha_facturacion,
            'codigo_producto'    => $producto->codigo,
            'desc_producto'      => $producto->descripcion,
            'marca_producto'     => $producto->marca,
            'tipo_producto'      => $producto->tipo_nombre,
            'detalle_equipo'     => $request->detalle_equipo,
            'foto_1'             => $fotos[1],
            'foto_2'             => $fotos[2],
            'foto_3'             => $fotos[3],
            'foto_4'             => $fotos[4],
        ]);

        // Enviar correo
        $equipo_txt = $producto->tipo_nombre . ' — ' . $producto->marca . ' — ' . $producto->descripcion;
        $nombres = strtoupper($request->nombres);
        $apellidos = strtoupper($request->apellidos);

        try {
            Mail::html($this->emailHtml($nro_preorden, $nombres, $apellidos, $equipo_txt, $producto->codigo, $request->nro_factura), function ($m) use ($request, $nro_preorden) {
                $m->to($request->correo)
                  ->subject("Pre-Orden $nro_preorden — Novitecnología");
            });
        } catch (\Exception $e) {}

        return response()->json([
            'ok'          => true,
            'nro_preorden' => $nro_preorden,
            'equipo'      => $equipo_txt,
        ]);
    }

    public function guardarSugerencia(Request $request)
    {
        $request->validate([
            'sg_nombres'   => 'required|string',
            'sg_apellidos' => 'required|string',
            'sg_texto'     => 'required|string|min:10',
        ]);

        $nombres   = strtoupper(trim($request->sg_nombres));
        $apellidos = strtoupper(trim($request->sg_apellidos));
        $texto     = trim($request->sg_texto);
        $categoria = $request->sg_categoria ?? 'General';
        $fecha     = now()->format('d/m/Y H:i');

        try {
            Mail::html($this->sugerenciaHtml($nombres, $apellidos, $request->sg_identificacion, $request->sg_telefono, $request->sg_correo, $categoria, $texto, $fecha), function ($m) use ($nombres, $apellidos) {
                $m->to('sistemas@novicompu.com')
                  ->cc('josuer@novitec.com.ec')
                  ->subject("💡 Nueva Sugerencia — $nombres $apellidos");
            });
        } catch (\Exception $e) {
            return response()->json(['ok' => false, 'error' => 'No se pudo enviar la sugerencia.']);
        }

        return response()->json(['ok' => true]);
    }

    private function generarNroPreorden($secuencial)
    {
        for ($intentos = 0; $intentos < 20; $intentos++) {
            $n1 = DB::connection('novitecdb')->table('ordenes')
                ->where('nro_orden', 'like', "$secuencial-%")
                ->max(DB::raw('CAST(SUBSTRING_INDEX(nro_orden,\'-\',-1) AS UNSIGNED)'));
            $n2 = DB::connection('novitecdb')->table('preordenes')
                ->where('nro_preorden', 'like', "PRE-$secuencial-%")
                ->max(DB::raw('CAST(SUBSTRING_INDEX(nro_preorden,\'-\',-1) AS UNSIGNED)'));
            $num = max((int)$n1, (int)$n2) + 1 + $intentos;
            $candidate = 'PRE-' . $secuencial . '-' . str_pad($num, 6, '0', STR_PAD_LEFT);
            $exists = DB::connection('novitecdb')->table('preordenes')
                ->where('nro_preorden', $candidate)->exists();
            if (!$exists) return $candidate;
        }
        return 'PRE-' . $secuencial . '-' . time();
    }

    private function emailHtml($nro, $nombres, $apellidos, $equipo, $codigo, $factura)
    {
        return "
        <div style='font-family:Arial,sans-serif;max-width:560px;margin:auto;'>
          <div style='background:#1a3d7c;padding:20px 28px;border-radius:8px 8px 0 0;'>
            <h2 style='color:#fff;margin:0;'>Pre-Orden Registrada</h2>
            <p style='color:rgba(255,255,255,.7);margin:4px 0 0;font-size:13px;'>Novitecnología Cía. Ltda.</p>
          </div>
          <div style='background:#f9fafb;padding:24px 28px;border:1px solid #e5e7eb;border-top:none;border-radius:0 0 8px 8px;'>
            <p style='font-size:15px;'>Hola <strong>$nombres $apellidos</strong>,</p>
            <p style='font-size:14px;color:#374151;'>Tu pre-orden ha sido registrada exitosamente.</p>
            <div style='background:#fff;border:1px solid #e5e7eb;border-radius:8px;padding:16px 20px;margin:16px 0;'>
              <table style='width:100%;font-size:13px;border-collapse:collapse;'>
                <tr><td style='padding:5px 0;color:#6b7280;'>Número de Pre-Orden</td>
                    <td style='padding:5px 0;font-weight:700;font-size:15px;color:#1a3d7c;'>$nro</td></tr>
                <tr><td style='padding:5px 0;color:#6b7280;'>Equipo</td><td style='padding:5px 0;'>$equipo</td></tr>
                <tr><td style='padding:5px 0;color:#6b7280;'>Código</td><td style='padding:5px 0;'>$codigo</td></tr>
                <tr><td style='padding:5px 0;color:#6b7280;'>Nro. Factura</td><td style='padding:5px 0;'>$factura</td></tr>
              </table>
            </div>
            <p style='font-size:13px;color:#6b7280;'>Un técnico de Novitecnología Cia. Ltda. se pondrá en contacto contigo.<br>Dudas: <strong>+593 960 500 156</strong></p>
            <hr style='border:none;border-top:1px solid #e5e7eb;margin:20px 0;'>
            <p style='font-size:11px;color:#9ca3af;text-align:center;'>Novitecnología Cía. Ltda. · novitec.com.ec</p>
          </div>
        </div>";
    }

    private function sugerenciaHtml($nombres, $apellidos, $ci, $tel, $correo, $categoria, $texto, $fecha)
    {
        return "
        <div style='font-family:Arial,sans-serif;max-width:520px;margin:auto;'>
          <div style='background:#059669;padding:20px 28px;border-radius:8px 8px 0 0;'>
            <h2 style='color:#fff;margin:0;'>💡 Nueva Sugerencia Recibida</h2>
            <p style='color:rgba(255,255,255,.75);margin:4px 0 0;font-size:13px;'>Novitecnología Cía. Ltda. — $fecha</p>
          </div>
          <div style='background:#f9fafb;padding:24px 28px;border:1px solid #e5e7eb;border-top:none;border-radius:0 0 8px 8px;'>
            <table style='width:100%;font-size:13px;border-collapse:collapse;margin-bottom:16px;'>
              <tr><td style='padding:6px 0;color:#6b7280;width:38%;'>Cliente</td><td style='padding:6px 0;font-weight:600;color:#111;'>$nombres $apellidos</td></tr>
              <tr><td style='padding:6px 0;color:#6b7280;border-top:1px solid #f1f5f9;'>C.I. / RUC</td><td style='padding:6px 0;border-top:1px solid #f1f5f9;'>" . ($ci ?: '—') . "</td></tr>
              <tr><td style='padding:6px 0;color:#6b7280;border-top:1px solid #f1f5f9;'>Teléfono</td><td style='padding:6px 0;border-top:1px solid #f1f5f9;'>" . ($tel ?: '—') . "</td></tr>
              <tr><td style='padding:6px 0;color:#6b7280;border-top:1px solid #f1f5f9;'>Correo</td><td style='padding:6px 0;border-top:1px solid #f1f5f9;'>" . ($correo ?: '—') . "</td></tr>
              <tr><td style='padding:6px 0;color:#6b7280;border-top:1px solid #f1f5f9;'>Categoría</td><td style='padding:6px 0;border-top:1px solid #f1f5f9;'><span style='background:#d1fae5;color:#065f46;font-size:12px;font-weight:700;padding:2px 10px;border-radius:20px;'>$categoria</span></td></tr>
            </table>
            <div style='background:#fff;border-left:4px solid #059669;padding:14px 18px;border-radius:0 8px 8px 0;font-size:14px;color:#374151;line-height:1.7;'>
              " . nl2br(htmlspecialchars($texto)) . "
            </div>
          </div>
        </div>";
    }
}
