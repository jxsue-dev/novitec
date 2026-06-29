<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(15);
        return view('admin.users', compact('users'));
    }

    public function toggleAdmin(User $user)
    {
        if ($user->is(auth()->user())) {
            return back()->with('error', 'No puedes cambiar tu propio rol de administrador.');
        }

        if ($user->is_admin && User::where('is_admin', true)->count() <= 1) {
            return back()->with('error', 'Debe quedar al menos un administrador.');
        }

        $user->update(['is_admin' => !$user->is_admin]);
        return back()->with('success', 'Rol actualizado correctamente.');
    }

    public function assignBranch(User $user, \Illuminate\Http\Request $request)
    {
        if ($user->is(auth()->user())) {
            return back()->with('error', 'No puedes modificar tu propio rol.');
        }

        $branchCode = $request->input('branch_code') ?: null;

        $allowedCodes = array_keys(User::BRANCHES);
        if ($branchCode !== null && !in_array($branchCode, $allowedCodes)) {
            return back()->with('error', 'Sucursal inválida.');
        }

        // Si se asigna sucursal, quitar admin (no puede ser ambos)
        $user->update([
            'branch_code' => $branchCode,
            'is_admin'    => false,
        ]);

        $message = $branchCode
            ? 'Usuario asignado como recepcionista de ' . User::BRANCHES[$branchCode] . '.'
            : 'Rol de recepcionista removido.';

        return back()->with('success', $message);
    }

    public function destroy(User $user)
    {
        if ($user->is(auth()->user())) {
            return back()->with('error', 'No puedes eliminar tu propia cuenta.');
        }

        if ($user->is_admin && User::where('is_admin', true)->count() <= 1) {
            return back()->with('error', 'Debe quedar al menos un administrador.');
        }

        $user->delete();
        return back()->with('success', 'Usuario eliminado correctamente.');
    }
}
