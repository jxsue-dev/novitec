<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReceptionistController extends Controller
{
    public function index(Request $request)
    {
        $user    = Auth::user();
        $results = null;
        $error   = null;

        // Admin puede elegir sucursal; recepcionista solo la suya
        if ($user->is_admin) {
            $branchCode  = $request->input('branch', 'UIO');
        } else {
            $branchCode  = $user->branch_code;
        }

        $branchName  = User::BRANCHES[$branchCode]  ?? 'NOVITEC';
        $orderPrefix = User::BRANCH_ORDER_PREFIX[$branchCode] ?? '';

        $q    = trim($request->input('q', ''));
        $tipo = $request->input('tipo', 'nro_orden');

        if ($q !== '') {
            try {
                $query = DB::connection('novitecdb')->table('vista_ordenes');

                // Filtro de sucursal SIEMPRE aplicado
                if ($orderPrefix) {
                    $query->where('nro_orden', 'like', $orderPrefix . '%');
                }

                // Filtro de búsqueda adicional
                if ($tipo === 'nro_orden') {
                    $query->where('nro_orden', 'like', '%' . $q . '%');
                } elseif ($tipo === 'serie') {
                    $query->where('serie', 'like', '%' . $q . '%');
                } elseif ($tipo === 'identificacion') {
                    $query->where('identificacion', 'like', '%' . $q . '%');
                }

                $results = $query->orderByDesc('fecha_de_ingreso')->limit(30)->get();

                if ($results->isEmpty()) {
                    $error = 'No se encontraron órdenes en ' . $branchName . ' con ese criterio.';
                }
            } catch (\Throwable) {
                $error = 'Error al consultar las órdenes. Intenta de nuevo.';
            }
        }

        return view('recepcion.ordenes', [
            'results'      => $results,
            'error'        => $error,
            'q'            => $q,
            'tipo'         => $tipo,
            'branchCode'   => $branchCode,
            'branchName'   => $branchName,
            'orderPrefix'  => $orderPrefix,
            'branches'     => User::BRANCHES,
            'user'         => $user,
        ]);
    }
}
