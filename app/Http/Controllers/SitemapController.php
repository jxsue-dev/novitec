<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $pages = [
            ['url' => url('/'),                          'priority' => '1.0',  'changefreq' => 'weekly'],
            ['url' => url('/conocenos'),                 'priority' => '0.7',  'changefreq' => 'monthly'],
            ['url' => url('/servicios'),                 'priority' => '0.9',  'changefreq' => 'weekly'],
            ['url' => url('/contacto'),                  'priority' => '0.8',  'changefreq' => 'monthly'],
            ['url' => url('/garantias'),                 'priority' => '0.8',  'changefreq' => 'monthly'],
            ['url' => url('/soporte-autorizado'),        'priority' => '0.7',  'changefreq' => 'monthly'],
            ['url' => url('/resenas'),                   'priority' => '0.6',  'changefreq' => 'weekly'],
            ['url' => url('/warranties'),                'priority' => '0.7',  'changefreq' => 'monthly'],
            ['url' => url('/faq'),                       'priority' => '0.7',  'changefreq' => 'monthly'],
            ['url' => url('/portfolio'),                 'priority' => '0.7',  'changefreq' => 'weekly'],
            ['url' => url('/politica-de-privacidad'),    'priority' => '0.3',  'changefreq' => 'yearly'],
            ['url' => url('/terminos-y-condiciones'),    'priority' => '0.3',  'changefreq' => 'yearly'],
        ];

        // Servicios individuales
        $services = Service::where('active', true)->get(['slug']);
        foreach ($services as $service) {
            $pages[] = [
                'url'        => url("/servicios/{$service->slug}"),
                'priority'   => '0.8',
                'changefreq' => 'monthly',
            ];
        }

        $xml = view('sitemap', compact('pages'))->render();

        return response($xml, 200, [
            'Content-Type' => 'application/xml',
        ]);
    }
}
