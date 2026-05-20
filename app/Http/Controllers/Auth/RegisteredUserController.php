<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'cedula'   => ['required', 'string', 'unique:users', function ($attribute, $value, $fail) {
                $len = strlen($value);
                if ($len !== 10 && $len !== 13) {
                    $fail('La cédula debe tener 10 o 13 dígitos.');
                    return;
                }
                $provincia = intval(substr($value, 0, 2));
                if ($provincia < 1 || $provincia > 24) {
                    $fail('Los dos primeros dígitos deben estar entre 01 y 24.');
                    return;
                }
                if ($len === 13 && substr($value, -3) !== '001') {
                    $fail('El RUC debe terminar en 001.');
                    return;
                }
            }],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name'     => $request->name,
            'cedula'   => $request->cedula,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'is_admin' => false,
        ]);

        event(new Registered($user));
        Auth::login($user);

        return redirect()->route('client.orders');
    }
}
