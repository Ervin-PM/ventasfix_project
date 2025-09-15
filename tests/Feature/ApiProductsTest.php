<?php
namespace Tests\Feature;

use Tests\TestCase;
// use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Product;

class ApiProductsTest extends TestCase
{
    // use RefreshDatabase;

    public function test_products_requires_auth()
    {
        $response = $this->getJson('/api/products');
        $response->assertStatus(401);
    }

    public function test_create_product()
    {
    $this->withoutExceptionHandling();
    $user = User::factory()->create();
        $token = $user->createToken('test')->plainTextToken;

        $uid = uniqid();
        $payload = [
            'sku' => 'SKU-' . $uid,
            'nombre' => 'Test Product',
            'descripcion_corta' => 'Short',
            'descripcion_larga' => 'Long',
            'imagen_url' => 'http://example.com/img.png',
            'precio_neto' => 1000,
            'stock_actual' => 10,
            'stock_minimo' => 1,
            'stock_bajo' => 2,
            'stock_alto' => 20,
        ];

        $response = $this->withHeader('Authorization', 'Bearer '.$token)
            ->postJson('/api/products', $payload);

        $response->assertStatus(201);
        $this->assertDatabaseHas('products', ['sku' => $payload['sku']]);
    }
}
