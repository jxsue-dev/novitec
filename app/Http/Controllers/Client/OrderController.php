<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        $cedula = auth()->user()->cedula;

        $orders = Order::where('identificacion', $cedula)
                       ->orderByDesc('fecha_de_ingreso')
                       ->get();

        return view('client.orders', compact('orders'));
    }

    public function show($nro_orden)
    {
        $cedula = auth()->user()->cedula;

        $order = Order::where('identificacion', $cedula)
                      ->where('nro_orden', $nro_orden)
                      ->firstOrFail();

        return view('client.order-detail', compact('order'));
    }
}
