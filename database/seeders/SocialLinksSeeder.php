<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SocialLinksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    $links = [
        ['platform' => 'Facebook', 'url' => 'https://facebook.com/novitec', 'icon' => 'facebook', 'active' => true, 'order' => 1],
        ['platform' => 'Instagram', 'url' => 'https://instagram.com/novitec', 'icon' => 'instagram', 'active' => true, 'order' => 2],
        ['platform' => 'WhatsApp', 'url' => 'https://wa.me/593990000000', 'icon' => 'whatsapp', 'active' => true, 'order' => 3],
    ];

    foreach ($links as $link) {
        \App\Models\SocialLink::create($link);
    }
}
}
