<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WorkshopsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $workshops = [
            ['name' => 'RIMAC'],
            ['name' => 'CALLAO'],
            ['name' => 'TRUJILLO'],
            ['name' => 'PIURA'],
            ['name' => 'AREQUIPA'],
            ['name' => 'ICA'],
            ['name' => 'CUSCO'],
            ['name' => 'IQUITOS'],
            ['name' => 'TARAPOTO'],
            ['name' => 'HUANUCO'],
        ];

        DB::table('workshops')->insert($workshops);
    }
}
