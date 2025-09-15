<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Client;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

class ClientsApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_clients()
    {
    Sanctum::actingAs(User::factory()->create(), ['*']);
    Client::factory()->count(5)->create();
        $resp = $this->getJson('/api/clients');
        $resp->assertStatus(200)->assertJsonCount(5);
    }

    public function test_show_client()
    {
    Sanctum::actingAs(User::factory()->create(), ['*']);
    $c = Client::factory()->create();
        $resp = $this->getJson('/api/clients/' . $c->id);
        $resp->assertStatus(200)->assertJson(['id' => $c->id]);
    }

    public function test_store_client()
    {
    Sanctum::actingAs(User::factory()->create(), ['*']);
    $payload = Client::factory()->make()->toArray();
    $resp = $this->postJson('/api/clients', $payload);
        $resp->assertStatus(201)->assertJsonFragment(['rut_empresa' => $payload['rut_empresa']]);
    }

    public function test_update_client()
    {
    Sanctum::actingAs(User::factory()->create(), ['*']);
    $c = Client::factory()->create(['razon_social' => 'Old Name']);
    $resp = $this->putJson('/api/clients/' . $c->id, ['razon_social' => 'New Name']);
        $resp->assertStatus(200)->assertJsonFragment(['razon_social' => 'New Name']);
    }

    public function test_delete_client()
    {
    Sanctum::actingAs(User::factory()->create(), ['*']);
    $c = Client::factory()->create();
    $resp = $this->deleteJson('/api/clients/' . $c->id);
        $resp->assertStatus(200)->assertJson(['message' => 'Cliente eliminado correctamente']);
    }
}
