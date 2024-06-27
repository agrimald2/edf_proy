<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermutaRejectedReasonsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $reasons = [
            ['name' => 'Exceso de permutas'],
            ['name' => 'No llega al Volumen'],
            ['name' => 'Otros'],
        ];

        DB::table('permuta_rejected_reasons')->insert($reasons);
    }
}
