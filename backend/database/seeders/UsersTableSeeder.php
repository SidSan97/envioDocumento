<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Diretoria',
            'email' => 'diretoria@email.com',
            'password' => Hash::make('password'),
            'id_cargo' => 1
        ]);

        User::create([
            'name' => 'Administrador',
            'email' => 'administrador@email.com',
            'password' => Hash::make('password'),
            'id_cargo' => 2
        ]);

        User::create([
            'name' => 'Contador',
            'email' => 'contador@email.com',
            'password' => Hash::make('password'),
            'id_cargo' => 3
        ]);

        User::create([
            'name' => 'Cliente',
            'email' => 'cliente@email.com',
            'password' => Hash::make('password'),
            'id_cargo' => 4
        ]);
    }
}
