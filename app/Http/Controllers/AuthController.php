<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/**
 * Controlador responsable de la autenticación de los usuarios.
 *
 * Gestiona la visualización del formulario de inicio de sesión, el proceso
 * de autenticación para la aplicación web y la API, así como el cierre
 * de sesión.
 */
class AuthController extends Controller
{
    /**
     * Muestra el formulario de inicio de sesión para el backoffice.
     */
    public function showLoginForm()
    {
        // Diagnostic: log route names from router and UrlGenerator to help debug
        // why route(...) inside Blade sometimes throws RouteNotFoundException.
        try {
            $routerNames = collect(\Illuminate\Support\Facades\Route::getRoutes())->map(function ($r) { return $r->getName(); })->filter()->values()->all();
            \Log::debug('[diagnostic] router route names', ['count' => count($routerNames), 'names' => $routerNames]);

            $urlRoutes = [];
            if (app()->bound('url')) {
                try {
                    $urlRoutes = collect(app('url')->getRoutes())->map(function ($r) { return $r->getName(); })->filter()->values()->all();
                } catch (\Throwable $e) {
                    \Log::debug('[diagnostic] url->getRoutes threw', ['error' => (string) $e]);
                }
            }
            \Log::debug('[diagnostic] url generator route names', ['count' => count($urlRoutes), 'names' => $urlRoutes]);
        } catch (\Throwable $e) {
            \Log::debug('[diagnostic] failed to collect routes', ['error' => (string) $e]);
        }

        // Diagnostic: attempt to resolve route('dashboard') here to reproduce the issue
        try {
            $resolved = null;
            try {
                $resolved = route('dashboard');
                \Log::debug('[diagnostic] route("dashboard") resolved', ['value' => $resolved]);
            } catch (\Throwable $e) {
                \Log::debug('[diagnostic] route("dashboard") threw', ['error' => (string) $e]);
            }

            try {
                // app('url')->route attempts to use UrlGenerator's route resolution
                $urlResolved = app('url')->route('dashboard');
                \Log::debug('[diagnostic] app("url")->route("dashboard") resolved', ['value' => $urlResolved]);
            } catch (\Throwable $e) {
                \Log::debug('[diagnostic] app("url")->route("dashboard") threw', ['error' => (string) $e]);
            }
            // Further diagnostics: inspect router instance and lookup by name directly
            try {
                $router = app('router');
                \Log::debug('[diagnostic] router class', ['class' => is_object($router) ? get_class($router) : gettype($router)]);
                $routesCollection = $router->getRoutes();
                $byName = null;
                try {
                    $byName = $routesCollection->getByName('dashboard');
                    \Log::debug('[diagnostic] router->getRoutes()->getByName', ['found' => (bool)$byName, 'route' => $byName ? $byName->uri() : null]);
                } catch (\Throwable $e) {
                    \Log::debug('[diagnostic] router->getRoutes()->getByName threw', ['error' => (string) $e]);
                }
            } catch (\Throwable $e) {
                \Log::debug('[diagnostic] inspecting router failed', ['error' => (string) $e]);
            }
        } catch (\Throwable $e) {
            \Log::debug('[diagnostic] unexpected during route resolution', ['error' => (string) $e]);
        }

        return view('auth.login');
    }

    /**
     * Maneja la autenticación de usuarios para la interfaz web.
     */
    public function login(Request $request)
    {
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Datos inválidos', 'errors' => $validator->errors()], 422);
        }

        $credentials = $validator->validated();

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        // Para peticiones web, devolvemos un mensaje claro; también añadimos withErrors
        // para mantener el comportamiento de validación anterior.
        if ($request->wantsJson()) {
            return response()->json(['message' => 'Credenciales inválidas'], 401);
        }

        // Use redirect()->back() to avoid relying on a named 'login' route that may
        // not be defined in this project. Keep old input and flash an error.
        return redirect()->back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => 'Las credenciales proporcionadas no coinciden con nuestros registros.'])
            ->with('error', 'Usuario o contraseña incorrectos.');
    }

    /**
     * Cierra la sesión del usuario en la aplicación web.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    /**
     * Autentica a un usuario desde la API y retorna un token de acceso.
     */
    public function apiLogin(Request $request)
    {
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Datos inválidos', 'errors' => $validator->errors()], 422);
        }

        $credentials = $validator->validated();

        $user = User::where('email', $credentials['email'])->first();
        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return response()->json([
                'message' => 'Credenciales inválidas',
            ], 401);
        }

        // Eliminar tokens anteriores y crear uno nuevo
        $user->tokens()->delete();
        $token = $user->createToken('api_token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => $user,
        ], 200);
    }
}