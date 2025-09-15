<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClientsTableSeeder extends Seeder
{
    public function run()
    {
        $now = now();
        $items = [];
        for ($i = 1; $i <= 15; $i++) {
            $items[] = [
                // ensure rut_empresa is unique for each seeded client
                'rut_empresa' => '76.000.000-'.str_pad($i, 2, '0', STR_PAD_LEFT),
                'rubro' => 'Servicios',
                'razon_social' => 'Cliente de prueba '.$i,
                'telefono' => '5691234'.str_pad($i, 3, '0', STR_PAD_LEFT),
                'direccion' => 'Calle Falsa '.($i),
                'contacto_nombre' => 'Contacto '.$i,
                'contacto_email' => 'cliente'.$i.'@example.test',
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        DB::table('clients')->insert($items);
    }
}
