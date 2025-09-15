<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        $uid = substr(Str::uuid()->toString(), 0, 8);
        return [
            'rut' => 'RUT-' . $uid,
            'nombre' => 'Test',
            'apellido' => 'User',
            'email' => 'user+' . $uid . '@example.com',
            'email_verified_at' => now(),
            'password' => password_hash('secret', PASSWORD_BCRYPT),
        ];
    }
}
