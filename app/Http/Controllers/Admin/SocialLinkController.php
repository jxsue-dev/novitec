<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SocialLink;
use Illuminate\Http\Request;

class SocialLinkController extends Controller
{
    public function index()
    {
        $socials = SocialLink::orderBy('order')->get();
        return view('admin.socials', compact('socials'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'platform' => 'required|string',
            'url'      => 'required|url',
        ]);
        SocialLink::create($request->all());
        return back()->with('success', 'Red social agregada.');
    }

    public function update(Request $request, SocialLink $social)
    {
        $social->update($request->all());
        return back()->with('success', 'Red social actualizada.');
    }

    public function destroy(SocialLink $social)
    {
        $social->delete();
        return back()->with('success', 'Red social eliminada.');
    }
}
