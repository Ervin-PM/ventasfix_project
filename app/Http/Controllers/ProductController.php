<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

/**
 * Controlador para gestionar productos a través de la interfaz web.
 */
class ProductController extends Controller
{
    /**
     * Muestra la lista de productos.
     */
    public function index()
    {
        $query = Product::query();
        if ($id = request('id')) {
            $query->where('id', $id);
        }
        $products = $query->paginate(10)->appends(request()->only('id'));
        return view('products.index', compact('products'));
    }

    /**
     * Muestra el formulario para crear un nuevo producto.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Almacena un nuevo producto en la base de datos.
     */
    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'sku' => 'required|string|unique:products,sku',
            'nombre' => 'required|string',
            'descripcion_corta' => 'required|string',
            'descripcion_larga' => 'required|string',
            'imagen_url' => 'required|url',
            'precio_neto' => 'required|numeric',
            'stock_actual' => 'required|integer',
            'stock_minimo' => 'required|integer',
            'stock_bajo' => 'required|integer',
            'stock_alto' => 'required|integer',
        ]);
        // Calcular precio de venta aplicando IVA del 19%
        $data['precio_venta'] = $data['precio_neto'] * 1.19;
        Product::create($data);
        return redirect()->route('products.index')->with('success', 'Producto creado correctamente.');
    }

    /**
     * Muestra el formulario para editar un producto existente.
     */
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    /**
     * Actualiza un producto existente en la base de datos.
     */
    public function update(Request $request, Product $product)
    {
        $data = $this->validate($request, [
            'sku' => 'required|string|unique:products,sku,' . $product->id,
            'nombre' => 'required|string',
            'descripcion_corta' => 'required|string',
            'descripcion_larga' => 'required|string',
            'imagen_url' => 'required|url',
            'precio_neto' => 'required|numeric',
            'stock_actual' => 'required|integer',
            'stock_minimo' => 'required|integer',
            'stock_bajo' => 'required|integer',
            'stock_alto' => 'required|integer',
        ]);
        $data['precio_venta'] = $data['precio_neto'] * 1.19;
        $product->update($data);
        return redirect()->route('products.index')->with('success', 'Producto actualizado correctamente.');
    }

    /**
     * Elimina un producto de la base de datos.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Producto eliminado correctamente.');
    }
}