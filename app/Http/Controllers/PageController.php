<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\SocialLink;
use App\Models\Setting;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function conocenos()
    {
        $branches = Branch::where('active', true)->orderBy('order')->get();
        $socials = SocialLink::where('active', true)->orderBy('order')->get();
        $settings = Setting::pluck('value', 'key');
        return view('pages.conocenos', compact('branches', 'socials', 'settings'));
    }

    public function servicios()
    {
        $branches = Branch::where('active', true)->orderBy('order')->get();
        $socials = SocialLink::where('active', true)->orderBy('order')->get();
        $settings = Setting::pluck('value', 'key');
        return view('pages.servicios', compact('branches', 'socials', 'settings'));
    }

    public function contacto()
    {
        $branches = Branch::where('active', true)->orderBy('order')->get();
        $socials = SocialLink::where('active', true)->orderBy('order')->get();
        $settings = Setting::pluck('value', 'key');
        return view('pages.contacto', compact('branches', 'socials', 'settings'));
    }

    public function sendContacto(Request $request)
    {
        $request->validate([
            'name'    => ['required', 'string', 'max:255'],
            'email'   => ['required', 'email'],
            'subject' => ['required', 'string'],
            'message' => ['required', 'string'],
        ]);

        \Mail::to('soporte@novitec.com.ec')->send(new \App\Mail\ContactoMail(
            nombre:   $request->name,
            email:    $request->email,
            telefono: $request->phone ?? '',
            asunto:   $request->subject,
            mensaje:  $request->message,
        ));

        return back()->with('success', '¡Mensaje enviado! Nos pondremos en contacto contigo pronto.');
    }
}
