<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        // Ensure admin user exists and set a known password so you can log in.
        // NOTE: this will update the password if the user already exists.
        $email = 'juan.perez@ventasfix.cl';
        User::updateOrCreate(
            ['email' => $email],
            [
                'rut' => '12.345.678-5',
                'nombre' => 'Juan',
                'apellido' => 'Perez',
                'password' => Hash::make('Admin2025!'),
            ]
        );
    }
}
