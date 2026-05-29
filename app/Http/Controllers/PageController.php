<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\SocialLink;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PageController extends Controller
{
    public function conocenos()
    {
        $branches = Branch::where('active', true)->orderBy('order')->get();
        $socials = SocialLink::where('active', true)->orderBy('order')->get();
        $settings = Setting::pluck('value', 'key');
        return view('pages.conocenos', compact('branches', 'socials', 'settings'));
    }

    public function servicios(Request $request)
    {
        $branches = Branch::where('active', true)->orderBy('order')->get();
        $socials = SocialLink::where('active', true)->orderBy('order')->get();
        $settings = Setting::pluck('value', 'key');

        $query = \App\Models\Service::where('active', true);

        if ($request->filled('q')) {
            $query->where('name', 'like', '%' . $request->q . '%')
                  ->orWhere('description', 'like', '%' . $request->q . '%');
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $services = $query->orderBy('order')->get();

        return view('pages.servicios', compact('branches', 'socials', 'settings', 'services'));
    }

    public function contacto()
    {
        $branches = Branch::where('active', true)->orderBy('order')->get();
        $socials = SocialLink::where('active', true)->orderBy('order')->get();
        $settings = Setting::pluck('value', 'key');
        return view('pages.contacto', compact('branches', 'socials', 'settings'));
    }

    public function sendContacto(Request $request)
    {
        $request->validate([
            'name'    => ['required', 'string', 'max:255'],
            'email'   => ['required', 'email'],
            'subject' => ['required', 'string'],
            'message' => ['required', 'string'],
        ]);

        \Mail::to('soporte@novitec.com.ec')->send(new \App\Mail\ContactoMail(
            nombre:   $request->name,
            email:    $request->email,
            telefono: $request->phone ?? '',
            asunto:   $request->subject,
            mensaje:  $request->message,
        ));

        return back()->with('success', '¡Mensaje enviado! Nos pondremos en contacto contigo pronto.');
    }

    public function garantias()
    {
        $branches = Branch::where('active', true)->orderBy('order')->get();
        $socials = SocialLink::where('active', true)->orderBy('order')->get();
        $settings = Setting::pluck('value', 'key');
        return view('pages.garantias', compact('branches', 'socials', 'settings'));
    }

        public function consultaGarantia(Request $request)
    {
        $request->validate([
            'q'    => ['required', 'string'],
            'tipo' => ['required', 'in:nro_orden,identificacion'],
        ]);

        $q    = trim($request->q);
        $tipo = $request->tipo;

        try {
            $query = DB::connection('novitecdb')->table('vista_ordenes');

            if ($tipo === 'nro_orden') {
                $query->where('nro_orden', 'like', '%' . $q . '%');
            } else {
                $query->where('identificacion', $q);
            }

            $resultados = $query->orderByDesc('fecha_de_ingreso')
                ->limit(20)
                ->get()
                ->map(fn($r) => [
                    'nro_orden'     => $r->nro_orden,
                    'estado_orden'  => $r->estado_orden,
                    'motivo_ingreso'=> $r->motivo_ingreso,
                    'fecha_ingreso' => $r->fecha_de_ingreso_fmt,
                    'tecnico'       => $r->tecnico,
                    'sucursal'      => $r->sucursal,
                    'tipo_equipo'   => $r->tipo,
                    'marca_equipo'  => $r->marca,
                    'modelo_equipo' => $r->modelo,
                    'falla'         => $r->falla,
                    'observacion'   => $r->observacion,
                    'nombres'       => $r->nombres,
                    'apellidos'     => $r->apellidos,
                    'cliente'       => $r->cliente,
                ])->toArray();

            if (empty($resultados)) {
                return back()->with('consulta_error', 'No encontramos órdenes con ese criterio. Verifica el dato ingresado.');
            }

            return back()->with('consulta_resultados', $resultados);

        } catch (\Exception $e) {
            return back()->with('consulta_error', 'Error al procesar la consulta. Intenta nuevamente.');
        }
    }

    public function resenas()
    {
        $branches = Branch::where('active', true)->orderBy('order')->get();
        $socials = SocialLink::where('active', true)->orderBy('order')->get();
        $settings = Setting::pluck('value', 'key');
        $featured = \App\Models\Review::where('featured', true)->orderByDesc('created_at')->get();
        $all = \App\Models\Review::where('rating', '>=', 3)->orderByDesc('created_at')->get();
        return view('pages.resenas', compact('branches', 'socials', 'settings', 'featured', 'all'));
    }
}
