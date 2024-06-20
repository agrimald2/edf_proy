<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Administrador',
            'role' => 'Admin',
            'email' => 'admin@nedfac.com',
            'password' => Hash::make('123456789'),
        ]);
        User::create([
            'name' => 'Trade Profile',
            'role' => 'Trade',
            'email' => 'trade@nedfac.com',
            'password' => Hash::make('123456789'),
        ]);
        User::create([
            'name' => 'Gerente Profile',
            'role' => 'Gerente',
            'email' => 'gerente@nedfac.com',
            'password' => Hash::make('123456789'),
        ]);
        User::create([
            'name' => 'Supervisor Profile',
            'role' => 'Supervisor',
            'email' => 'supervisor@nedfac.com',
            'password' => Hash::make('123456789'),
        ]);
    }
}
