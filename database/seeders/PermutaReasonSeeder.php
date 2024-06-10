<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PermutaReason;

class PermutaReasonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $reasons = [
            'Cliente Nuevo',
            'Cliente con Potencial',
            'Cliente fuera del listado',
            'Otro subcanal',
            'Cliente no llega al volumen mínimo'
        ];

        foreach ($reasons as $reason) {
            PermutaReason::create(['name' => $reason]);
        }
    }
}
