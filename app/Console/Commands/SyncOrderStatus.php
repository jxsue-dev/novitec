<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\OrderStatusNotification;

class SyncOrderStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:sync-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sincroniza el estado de las órdenes desde la base de datos de SGN y envía correos cuando hay cambios';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Iniciando sincronización de estados de órdenes desde SGN...');

        try {
            // Obtenemos las últimas 150 órdenes para revisar las que están activas o recientes
            $orders = DB::connection('novitecdb')
                ->table('vista_ordenes')
                ->orderByDesc('fecha_de_ingreso')
                ->limit(150)
                ->get();

            $this->info('Órdenes obtenidas: ' . $orders->count());

            foreach ($orders as $o) {
                // Si no hay correo del cliente, no podemos enviarle notificaciones, omitimos
                if (empty($o->correo) || !filter_var($o->correo, FILTER_VALIDATE_EMAIL)) {
                    continue;
                }

                // Buscar si ya tenemos un registro local de esta orden
                $tracker = DB::table('order_status_trackers')
                    ->where('nro_orden', $o->nro_orden)
                    ->first();

                $equipo = trim(implode(' ', array_filter([$o->tipo ?? '', $o->marca ?? '', $o->modelo ?? '']))) ?: 'Dispositivo tecnológico';
                $cliente = trim(($o->nombres ?? '') . ' ' . ($o->apellidos ?? '')) ?: ($o->cliente ?? 'Cliente');
                $sucursal = $o->sucursal ?? 'Novitec';

                if (!$tracker) {
                    // Si no existe, registramos el estado inicial y enviamos el primer correo de recepción
                    DB::table('order_status_trackers')->insert([
                        'nro_orden'   => $o->nro_orden,
                        'last_status' => $o->estado_orden,
                        'created_at'  => now(),
                        'updated_at'  => now(),
                    ]);

                    $this->info("Nueva orden registrada: {$o->nro_orden} con estado {$o->estado_orden}");

                    // Solo enviar correo si la orden fue ingresada recientemente (ej: en las últimas 48 horas)
                    // Esto evita enviar correos masivos a clientes por órdenes antiguas en la primera ejecución.
                    $fechaIngreso = !empty($o->fecha_de_ingreso) ? strtotime($o->fecha_de_ingreso) : 0;
                    $hace48Horas = time() - (48 * 3600);

                    if ($fechaIngreso > $hace48Horas) {
                        try {
                            Mail::to($o->correo)->send(new OrderStatusNotification(
                                $o->nro_orden,
                                $o->estado_orden,
                                $equipo,
                                $sucursal,
                                $cliente
                            ));
                        } catch (\Exception $mailEx) {
                            Log::error("Error al enviar correo de orden nueva {$o->nro_orden}: " . $mailEx->getMessage());
                        }
                    }

                } else {
                    // Si existe, verificamos si el estado cambió
                    if ($tracker->last_status !== $o->estado_orden) {
                        $estadoAnterior = $tracker->last_status;

                        // Actualizamos el estado en nuestra base de datos local
                        DB::table('order_status_trackers')
                            ->where('nro_orden', $o->nro_orden)
                            ->update([
                                'last_status' => $o->estado_orden,
                                'updated_at'  => now(),
                            ]);

                        $this->info("Cambio de estado en orden {$o->nro_orden}: {$estadoAnterior} -> {$o->estado_orden}");

                        try {
                            Mail::to($o->correo)->send(new OrderStatusNotification(
                                $o->nro_orden,
                                $o->estado_orden,
                                $equipo,
                                $sucursal,
                                $cliente
                            ));
                        } catch (\Exception $mailEx) {
                            Log::error("Error al enviar correo de actualización de orden {$o->nro_orden}: " . $mailEx->getMessage());
                        }
                    }
                }
            }

            $this->info('Sincronización finalizada correctamente.');
            return Command::SUCCESS;

        } catch (\Exception $e) {
            Log::error('Error general en comando SyncOrderStatus: ' . $e->getMessage());
            $this->error('Ocurrió un error en la sincronización: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
