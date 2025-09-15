<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

/**
 * Controlador para gestionar clientes empresa a través de la interfaz web.
 */
class ClientController extends Controller
{
    /**
     * Muestra la lista de clientes.
     */
    public function index()
    {
        $query = Client::query();
        if ($id = request('id')) {
            $query->where('id', $id);
        }
        $clients = $query->paginate(10)->appends(request()->only('id'));
        return view('clients.index', compact('clients'));
    }

    /**
     * Muestra el formulario para crear un nuevo cliente.
     */
    public function create()
    {
        return view('clients.create');
    }

    /**
     * Almacena un nuevo cliente en la base de datos.
     */
    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'rut_empresa' => 'required|string|unique:clients,rut_empresa',
            'rubro' => 'required|string',
            'razon_social' => 'required|string',
            'telefono' => 'required|string',
            'direccion' => 'required|string',
            'contacto_nombre' => 'required|string',
            'contacto_email' => 'required|email',
        ]);
        Client::create($data);
        return redirect()->route('clients.index')->with('success', 'Cliente creado correctamente.');
    }

    /**
     * Muestra el formulario para editar un cliente existente.
     */
    public function edit(Client $client)
    {
        return view('clients.edit', compact('client'));
    }

    /**
     * Actualiza un cliente existente en la base de datos.
     */
    public function update(Request $request, Client $client)
    {
        $data = $this->validate($request, [
            'rut_empresa' => 'required|string|unique:clients,rut_empresa,' . $client->id,
            'rubro' => 'required|string',
            'razon_social' => 'required|string',
            'telefono' => 'required|string',
            'direccion' => 'required|string',
            'contacto_nombre' => 'required|string',
            'contacto_email' => 'required|email',
        ]);
        $client->update($data);
        return redirect()->route('clients.index')->with('success', 'Cliente actualizado correctamente.');
    }

    /**
     * Elimina un cliente de la base de datos.
     */
    public function destroy(Client $client)
    {
        $client->delete();
        return redirect()->route('clients.index')->with('success', 'Cliente eliminado correctamente.');
    }
}