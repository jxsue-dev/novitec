<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\SgnClienteRepository;
use App\Rules\EcuadorIdentificacion;
use App\Support\IdentityDocument;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function lookupIdentificacion(Request $request, SgnClienteRepository $clientes): JsonResponse
    {
        $data = $request->validate([
            'identificacion' => ['required', 'string', new EcuadorIdentificacion()],
        ]);

        $identificacion = IdentityDocument::normalize($data['identificacion']);
        $identificacionCanonica = IdentityDocument::canonicalize($identificacion);

        if (User::where('identificacion_canonica', $identificacionCanonica)->exists()) {
            return response()->json([
                'found' => false,
                'already_registered' => true,
                'message' => 'Ya existe una cuenta para esta identificacion. Inicia sesion con tu clave.',
                'login_url' => route('login'),
                'cliente' => null,
                'source' => 'web_users',
            ]);
        }

        $cliente = $clientes->findByIdentificacion($identificacion);

        return response()->json([
            'found' => $cliente !== null,
            'already_registered' => false,
            'cliente' => $cliente,
            'source' => $cliente ? 'sgn_clientes' : null,
        ]);
    }

    public function store(Request $request, SgnClienteRepository $clientes): RedirectResponse
    {
        $redirectTo = $this->resolveRedirectTo($request->input('redirect_to'));

        $data = $request->validate([
            'identificacion' => ['required', 'string', new EcuadorIdentificacion()],
            'nombres' => ['required', 'string', 'max:255'],
            'apellidos' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'regex:/^[0-9]{10}$/'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'direccion' => ['nullable', 'string', 'max:1000'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            'email.unique' => 'Ese correo ya esta registrado en el portal web. Usa otro correo o inicia sesion.',
            'phone.regex' => 'El telefono debe tener exactamente 10 digitos numericos.',
        ]);

        $data['identificacion'] = IdentityDocument::normalize($data['identificacion']);
        $data['identificacion_canonica'] = IdentityDocument::canonicalize($data['identificacion']);

        if (User::where('identificacion_canonica', $data['identificacion_canonica'])->exists()) {
            $loginRoute = $redirectTo !== null
                ? route('login', ['redirect_to' => $redirectTo], false)
                : route('login');

            return redirect()->to($loginRoute)
                ->with('status', 'Ya existe una cuenta para esta identificacion. Inicia sesion con tu clave.')
                ->withInput(['identificacion' => $data['identificacion']]);
        }

        $clienteSgn = $clientes->findByIdentificacion($data['identificacion']);
        $fullName = IdentityDocument::fullName($data['nombres'], $data['apellidos']);

        $user = User::create([
            'name' => $fullName,
            'cedula' => $data['identificacion'],
            'identificacion' => $data['identificacion'],
            'identificacion_canonica' => $data['identificacion_canonica'],
            'nombres' => trim($data['nombres']),
            'apellidos' => trim($data['apellidos']),
            'phone' => $data['phone'],
            'direccion' => trim((string) ($data['direccion'] ?? '')) ?: null,
            'sgn_cliente_id' => $clienteSgn['sgn_cliente_id'] ?? null,
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'is_admin' => false,
        ]);

        event(new Registered($user));
        Auth::login($user);

        if ($redirectTo !== null) {
            return redirect()->to($redirectTo);
        }

        return redirect()->route('client.orders');
    }

    private function resolveRedirectTo(?string $redirectTo): ?string
    {
        if (! is_string($redirectTo) || $redirectTo === '') {
            return null;
        }

        if (! str_starts_with($redirectTo, '/') || str_starts_with($redirectTo, '//')) {
            return null;
        }

        return $redirectTo;
    }
}
