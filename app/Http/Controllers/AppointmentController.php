<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Branch;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function create()
    {
        $branches = Branch::where('active', true)->orderBy('order')->get();
        return view('pages.cita', compact('branches'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'           => 'required|string|max:100',
            'email'          => 'required|email|max:150',
            'phone'          => 'required|string|max:20',
            'service'        => 'required|string|max:100',
            'device'         => 'nullable|string|max:100',
            'description'    => 'nullable|string|max:1000',
            'preferred_date' => 'required|date|after:today',
            'preferred_time' => 'required|in:09:00-11:00,11:00-13:00,14:00-16:00,16:00-17:00',
            'branch'         => 'required|string|max:50',
        ]);

        Appointment::create($data);

        return back()->with('success', '¡Cita agendada! Te contactaremos para confirmarla.');
    }
}
