<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Product;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

class ProductsApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_products()
    {
    Sanctum::actingAs(User::factory()->create(), ['*']);
    Product::factory()->count(4)->create();
    $resp = $this->getJson('/api/products');
        $resp->assertStatus(200)->assertJsonCount(4);
    }

    public function test_show_product()
    {
    Sanctum::actingAs(User::factory()->create(), ['*']);
    $p = Product::factory()->create();
    $resp = $this->getJson('/api/products/' . $p->id);
        $resp->assertStatus(200)->assertJson(['id' => $p->id]);
    }

    public function test_store_product()
    {
    Sanctum::actingAs(User::factory()->create(), ['*']);
    $payload = Product::factory()->make()->toArray();
    $resp = $this->postJson('/api/products', $payload);
        $resp->assertStatus(201)->assertJsonFragment(['sku' => $payload['sku']]);
    }

    public function test_update_product()
    {
    Sanctum::actingAs(User::factory()->create(), ['*']);
    $p = Product::factory()->create(['nombre' => 'Old']);
    $resp = $this->putJson('/api/products/' . $p->id, ['nombre' => 'New']);
        $resp->assertStatus(200)->assertJsonFragment(['nombre' => 'New']);
    }

    public function test_delete_product()
    {
    Sanctum::actingAs(User::factory()->create(), ['*']);
    $p = Product::factory()->create();
    $resp = $this->deleteJson('/api/products/' . $p->id);
        $resp->assertStatus(200)->assertJson(['message' => 'Producto eliminado correctamente']);
    }
}
