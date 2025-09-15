<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        $uid = substr(Str::uuid()->toString(), 0, 8);
        $precio = $this->faker->randomFloat(2, 1000, 100000);
        return [
            'sku' => 'SKU-' . $uid,
            // faker productName provider isn't available here; use words fallback
            'nombre' => $this->faker->words(3, true) ?: 'Producto ' . $uid,
            'descripcion_corta' => $this->faker->sentence(),
            'descripcion_larga' => $this->faker->paragraph(),
            'imagen_url' => 'https://via.placeholder.com/150',
            'precio_neto' => $precio,
            'precio_venta' => round($precio * 1.19, 2),
            'stock_actual' => $this->faker->numberBetween(0, 200),
            'stock_minimo' => $this->faker->numberBetween(1, 10),
            'stock_bajo' => $this->faker->numberBetween(0, 5),
            'stock_alto' => $this->faker->numberBetween(50, 200),
        ];
    }
}
