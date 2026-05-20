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
        $user->update(['is_admin' => !$user->is_admin]);
        return back()->with('success', 'Rol actualizado correctamente.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return back()->with('success', 'Usuario eliminado correctamente.');
    }
}
