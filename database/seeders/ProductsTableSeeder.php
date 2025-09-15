<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductsTableSeeder extends Seeder
{
    public function run()
    {
        $now = now();
        $items = [];
        for ($i = 1; $i <= 15; $i++) {
            $precio_neto = rand(1000, 50000);
            $items[] = [
                'sku' => 'SKU'.str_pad($i, 4, '0', STR_PAD_LEFT),
                'nombre' => 'Producto de prueba '.$i,
                'descripcion_corta' => 'Descripción corta del producto '.$i,
                'descripcion_larga' => 'Descripción larga y detallada del producto de prueba '.$i,
                'imagen_url' => 'template/assets/img/product-placeholder.png',
                'precio_neto' => $precio_neto,
                'precio_venta' => intval($precio_neto * 1.3),
                'stock_actual' => rand(0, 200),
                'stock_minimo' => 5,
                'stock_bajo' => 10,
                'stock_alto' => 100,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        DB::table('products')->insert($items);
    }
}
