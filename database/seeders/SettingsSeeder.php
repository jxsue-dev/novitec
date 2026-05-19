<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            ['key' => 'site_name', 'value' => 'Novitec'],
            ['key' => 'site_email', 'value' => 'info@novitec.com'],
            ['key' => 'discount_badge', 'value' => '50% OFF si eres cliente registrado'],
            ['key' => 'discount_active', 'value' => '1'],
        ];

        foreach ($settings as $setting) {
            \App\Models\Setting::updateOrCreate(['key' => $setting['key']], ['value' => $setting['value']]);
        }
    }
}
