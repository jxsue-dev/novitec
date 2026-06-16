<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ], [
            'email.required' => 'Ingresa el correo de tu cuenta.',
            'email.email' => 'Ingresa un correo válido.',
        ]);

        Password::sendResetLink($request->only('email'));

        return back()->with('status', 'Si el correo pertenece a una cuenta registrada, te enviaremos un enlace para restablecer tu contraseña.');
    }
}
