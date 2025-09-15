<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/**
 * API Controller para gestionar usuarios a través de endpoints JSON.
 */
class UserController extends Controller
{
    /**
     * Devuelve la lista de usuarios en formato JSON.
     */
    public function index()
    {
        return response()->json(User::all(), 200);
    }

    /**
     * Devuelve un usuario específico por su ID.
     */
    public function show($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }
        return response()->json($user, 200);
    }

    /**
     * Crea un nuevo usuario y devuelve la entidad creada.
     */
    public function store(Request $request)
    {
    // Use the FormRequest rules but validate via the controller helper to avoid
    // FormRequest lifecycle issues in the testing environment.
    $rules = (new UserStoreRequest())->rules();
    $data = $this->validate($request, $rules);
        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);
        return response()->json($user, 201);
    }

    /**
     * Actualiza un usuario existente.
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }
    $rules = (new UserUpdateRequest())->rules();
    $data = $this->validate($request, $rules);
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }
        $user->update($data);
        return response()->json($user, 200);
    }

    /**
     * Elimina un usuario.
     */
    public function destroy($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }
        $user->delete();
        return response()->json(['message' => 'Usuario eliminado correctamente'], 200);
    }
}