<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BranchesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $branches = [
            [
                'name' => 'Sucursal Principal',
                'address' => 'Av. Principal 123, Quito',
                'phone' => '+593 99 000 0000',
                'whatsapp' => '593990000000',
                'email' => 'info@novitec.com',
                'schedule' => 'Lun–Vie 8:00–18:00, Sáb 9:00–14:00',
                'active' => true,
                'order' => 1,
            ],
        ];

        foreach ($branches as $branch) {
            \App\Models\Branch::create($branch);
        }
    }
}
