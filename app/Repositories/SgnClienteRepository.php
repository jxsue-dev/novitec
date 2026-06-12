<?php

namespace App\Repositories;

use App\Support\IdentityDocument;
use Illuminate\Support\Facades\DB;

class SgnClienteRepository
{
    public function findByIdentificacion(string $identificacion): ?array
    {
        foreach (IdentityDocument::equivalentIdentifiers($identificacion) as $candidate) {
            $cliente = DB::connection('novitecdb')
                ->table('clientes')
                ->select([
                    'id',
                    'identificacion',
                    'nombres',
                    'apellidos',
                    'numero_contacto',
                    'correo',
                    'direccion_clientes',
                ])
                ->whereRaw('UPPER(TRIM(identificacion)) = ?', [strtoupper($candidate)])
                ->first();

            if ($cliente) {
                return [
                    'sgn_cliente_id' => (int) $cliente->id,
                    'identificacion' => IdentityDocument::normalize($cliente->identificacion),
                    'identificacion_canonica' => IdentityDocument::canonicalize($cliente->identificacion),
                    'nombres' => trim((string) ($cliente->nombres ?? '')),
                    'apellidos' => trim((string) ($cliente->apellidos ?? '')),
                    'telefono' => trim((string) ($cliente->numero_contacto ?? '')),
                    'correo' => trim((string) ($cliente->correo ?? '')),
                    'direccion' => trim((string) ($cliente->direccion_clientes ?? '')),
                ];
            }
        }

        return null;
    }
}
