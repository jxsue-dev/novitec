<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceOrder;
use App\Models\User;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = ServiceOrder::with('user')->latest()->paginate(15);
        return view('admin.orders', compact('orders'));
    }

    public function create()
    {
        $clients = User::where('is_admin', false)->orderBy('name')->get();
        return view('admin.orders-create', compact('clients'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'device'  => ['required', 'string'],
            'issue'   => ['required', 'string'],
        ]);

        ServiceOrder::create([
            'user_id'      => $request->user_id,
            'code'         => 'NV-' . strtoupper(uniqid()),
            'device'       => $request->device,
            'brand'        => $request->brand,
            'model'        => $request->model,
            'issue'        => $request->issue,
            'status'       => 'recibido',
            'notes'        => $request->notes,
            'price'        => $request->price,
            'estimated_at' => $request->estimated_at,
        ]);

        return redirect()->route('admin.orders')->with('success', 'Orden creada correctamente.');
    }

    public function update(Request $request, ServiceOrder $order)
    {
        $request->validate([
            'status' => ['required', 'in:recibido,diagnostico,reparacion,listo,entregado'],
        ]);

        $order->update([
            'status'       => $request->status,
            'notes'        => $request->notes,
            'price'        => $request->price,
            'estimated_at' => $request->estimated_at,
        ]);

        return back()->with('success', 'Orden actualizada correctamente.');
    }

    public function destroy(ServiceOrder $order)
    {
        $order->delete();
        return back()->with('success', 'Orden eliminada.');
    }
}
