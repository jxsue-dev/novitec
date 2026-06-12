<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Database\Eloquent\Collection;

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
}
