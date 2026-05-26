<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::orderBy('order')->get();
        return view('admin.services', compact('services'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'      => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image'     => ['nullable', 'image', 'max:4096'],
            'image_url' => ['nullable', 'url'],
            'category'  => ['required', 'string'],
            'price'     => ['nullable', 'string', 'max:100'],
            'order'     => ['nullable', 'integer'],
        ]);

        $data = $request->only(['name', 'description', 'image_url', 'category', 'price', 'order']);
        $data['active'] = $request->boolean('active');
        $data['slug'] = Str::slug($request->name);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('services', 'public');
        }

        Service::create($data);
        return back()->with('success', 'Servicio creado correctamente.');
    }

    public function update(Request $request, Service $service)
    {
        $request->validate([
            'name'      => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image'     => ['nullable', 'image', 'max:4096'],
            'image_url' => ['nullable', 'url'],
            'category'  => ['required', 'string'],
            'price'     => ['nullable', 'string', 'max:100'],
            'order'     => ['nullable', 'integer'],
        ]);

        $data = $request->only(['name', 'description', 'image_url', 'category', 'price', 'order']);
        $data['active'] = $request->boolean('active');
        $data['slug'] = Str::slug($request->name);

        if ($request->hasFile('image')) {
            if ($service->image) Storage::disk('public')->delete($service->image);
            $data['image'] = $request->file('image')->store('services', 'public');
        }

        $service->update($data);
        return back()->with('success', 'Servicio actualizado correctamente.');
    }

    public function destroy(Service $service)
    {
        if ($service->image) Storage::disk('public')->delete($service->image);
        $service->delete();
        return back()->with('success', 'Servicio eliminado correctamente.');
    }

    public function show(Service $service)
    {
        return view('pages.servicio', compact('service'));
    }
}
