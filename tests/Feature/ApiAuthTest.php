<?php
namespace Tests\Feature;

use Tests\TestCase;
// use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;

class ApiAuthTest extends TestCase
{
    // use RefreshDatabase;

    public function test_api_login_returns_token()
    {
    $this->withoutExceptionHandling();
        $uid = uniqid();
        $email = 'testuser+' . $uid . '@example.com';
        $user = User::create([
            'rut' => 'RUT-' . $uid,
            'nombre' => 'Test',
            'apellido' => 'User',
            'email' => $email,
            'password' => password_hash('secret', PASSWORD_BCRYPT),
        ]);

        // Resolve login URL: prefer named route 'login' if available, else fallback to '/api/login'
        $loginUrl = '/api/login';
        try {
            $routes = collect(app('router')->getRoutes())->map(function ($r) { return $r->getName(); })->filter();
            if (in_array('login', $routes->toArray())) {
                $loginUrl = route('login');
            }
        } catch (\Throwable $e) {
            // ignore and use fallback
        }

        $response = $this->postJson($loginUrl, [
            'email' => $email,
            'password' => 'secret',
        ]);

    $response->assertStatus(200);
    $response->assertJsonStructure(['token','user']);
    }
}
