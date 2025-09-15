<?php

namespace Database\Factories;

use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ClientFactory extends Factory
{
    protected $model = Client::class;

    public function definition()
    {
        $uid = substr(Str::uuid()->toString(), 0, 8);
        return [
            'rut_empresa' => '76.000.000-' . $uid,
            'rubro' => $this->faker->word(),
            'razon_social' => $this->faker->company(),
            'telefono' => '569' . $this->faker->numberBetween(1000000, 9999999),
            'direccion' => $this->faker->streetAddress(),
            'contacto_nombre' => $this->faker->name(),
            'contacto_email' => $this->faker->unique()->safeEmail(),
        ];
    }
}
