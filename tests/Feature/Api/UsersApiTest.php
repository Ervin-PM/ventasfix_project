<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

class UsersApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_users()
    {
    Sanctum::actingAs(User::factory()->create(), ['*']);
    User::factory()->count(3)->create();
    $resp = $this->getJson('/api/users');
        // actingAs created 1 user, plus the 3 created above -> total 4
        $resp->assertStatus(200)->assertJsonCount(4);
    }

    public function test_show_user()
    {
    Sanctum::actingAs(User::factory()->create(), ['*']);
    $u = User::factory()->create();
    $resp = $this->getJson('/api/users/' . $u->id);
        $resp->assertStatus(200)->assertJson(['id' => $u->id]);
    }

    public function test_store_user()
    {
        Sanctum::actingAs(User::factory()->create(), ['*']);
        $payload = [
            'rut' => 'RUT-12345',
            'nombre' => 'Nuevo',
            'apellido' => 'Usuario',
            'email' => 'nuevo@example.test',
            'password' => 'secret123'
        ];
        $resp = $this->postJson('/api/users', $payload);
        $resp->assertStatus(201)->assertJsonFragment(['email' => 'nuevo@example.test']);
    }

    public function test_update_user()
    {
    Sanctum::actingAs(User::factory()->create(), ['*']);
    $u = User::factory()->create(['email' => 'old@example.test']);
    $resp = $this->putJson('/api/users/' . $u->id, ['email' => 'updated@example.test']);
        $resp->assertStatus(200)->assertJsonFragment(['email' => 'updated@example.test']);
    }

    public function test_delete_user()
    {
    Sanctum::actingAs(User::factory()->create(), ['*']);
    $u = User::factory()->create();
    $resp = $this->deleteJson('/api/users/' . $u->id);
        $resp->assertStatus(200)->assertJson(['message' => 'Usuario eliminado correctamente']);
    }
}
