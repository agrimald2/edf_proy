<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class GerentesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $gerentes = [
            ['name' => 'Limo Salinas', 'email' => 'LSalinas@ecobesa.pe'],
            ['name' => 'Anibal Rojas', 'email' => 'ARojasL@ecobesa.pe'],
            ['name' => 'Edwing Pumasupa', 'email' => 'EPumasupa@accorporativo.pe'],
            ['name' => 'Karla Garcia', 'email' => 'kgarcia@ecobesa.pe'],
            ['name' => 'Orlando Valenzuela', 'email' => 'OValenzuela@ecobesa.pe'],
            ['name' => 'Beto Poma', 'email' => 'bpoma@ecobesa.pe'],
            ['name' => 'Vacante', 'email' => 'jaime.vega@ecobesa.pe'],
            ['name' => 'Fredy Grimaldo', 'email' => 'FGRIMALDO@ecobesa.pe'],
            ['name' => 'Jose Justiniano', 'email' => 'JJustiniano@ecobesa.pe'],
            ['name' => 'Miguel Vargas', 'email' => 'MVargasF@ecobesa.pe'],
            ['name' => 'Deyvis Bocanegra', 'email' => 'dbocanegral@accorporativo.pe'],
            ['name' => 'Oscar Bustamante', 'email' => 'obustamante@accorporativo.pe'],
            ['name' => 'Marco Paz', 'email' => 'MPaz@accorporativo.pe'],
            ['name' => 'Andrés Mau', 'email' => 'amau@accorporativo.pe'],
            ['name' => 'EDMUNDO GONZALES', 'email' => 'edmundo.gonzales@accorporativo.pe'],
            ['name' => 'GUSTAVO CALDERON', 'email' => 'gustavo.calderon@accorporativo.pe'],
            ['name' => 'HUMBERTO QUEIROLO', 'email' => 'HQueirolo@accorporativo.pe'],
            ['name' => 'DANIEL ROCA VARGAS', 'email' => 'droca@accorporativo.pe'],
            ['name' => 'Rodrigo Hidalgo', 'email' => 'Rhidalgo@accorporativo.pe'],
            ['name' => 'Juan Herrera', 'email' => 'jherrerac@accorporativo.pe'],
            ['name' => 'Joe Vega', 'email' => 'JoeVegaArenas@accorporativo.pe'],
            ['name' => 'Kevin Lara', 'email' => 'kevin.lara@accorporativo.pe'],
        ];

        foreach ($gerentes as $gerente) {
            DB::table('users')->insert([
                'name' => $gerente['name'],
                'email' => $gerente['email'],
                'password' => Hash::make('12345678'),
                'role' => 'Gerente',
            ]);
        }
    }
}
