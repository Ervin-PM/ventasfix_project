<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Http\Requests\ClientStoreRequest;
use App\Http\Requests\ClientUpdateRequest;
use Illuminate\Http\Request;

/**
 * API Controller para gestionar clientes.
 */
class ClientController extends Controller
{
    public function index()
    {
        return response()->json(Client::all(), 200);
    }

    public function show($id)
    {
        $client = Client::find($id);
        if (!$client) {
            return response()->json(['message' => 'Cliente no encontrado'], 404);
        }
        return response()->json($client, 200);
    }

    public function store(Request $request)
    {
    // Validate using the FormRequest rules but run validation here to avoid
    // lifecycle issues during testing.
    $rules = (new ClientStoreRequest())->rules();
    $data = $this->validate($request, $rules);
        $client = Client::create($data);
        return response()->json($client, 201);
    }

    public function update(Request $request, $id)
    {
        $client = Client::find($id);
        if (!$client) {
            return response()->json(['message' => 'Cliente no encontrado'], 404);
        }
    $rules = (new ClientUpdateRequest())->rules();
    $data = $this->validate($request, $rules);
        $client->update($data);
        return response()->json($client, 200);
    }

    public function destroy($id)
    {
        $client = Client::find($id);
        if (!$client) {
            return response()->json(['message' => 'Cliente no encontrado'], 404);
        }
        $client->delete();
        return response()->json(['message' => 'Cliente eliminado correctamente'], 200);
    }
}