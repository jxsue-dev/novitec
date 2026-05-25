<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    public function index()
    {
        $branches = Branch::orderBy('order')->get();
        return view('admin.branches', compact('branches'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'    => ['required', 'string', 'max:255'],
            'address' => ['required', 'string'],
            'phone'   => ['required', 'string'],
        ]);
        Branch::create($request->only([
            'name','address','phone','whatsapp',
            'email','schedule','maps_url','active','order'
        ]));
        return back()->with('success', 'Sucursal creada correctamente.');
    }

    public function update(Request $request, Branch $branch)
    {
        $request->validate([
            'name'    => ['required', 'string', 'max:255'],
            'address' => ['required', 'string'],
            'phone'   => ['required', 'string'],
        ]);
        $branch->update($request->only([
            'name','address','phone','whatsapp',
            'email','schedule','maps_url','active','order'
        ]));
        return back()->with('success', 'Sucursal actualizada correctamente.');
    }

    public function destroy(Branch $branch)
    {
        $branch->delete();
        return back()->with('success', 'Sucursal eliminada correctamente.');
    }
}
