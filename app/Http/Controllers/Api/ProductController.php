<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

/**
 * API Controller para gestionar productos.
 */
class ProductController extends Controller
{
    public function index()
    {
        return response()->json(Product::all(), 200);
    }

    public function show($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['message' => 'Producto no encontrado'], 404);
        }
        return response()->json($product, 200);
    }

    public function store(Request $request)
    {
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
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
        if ($validator->fails()) {
            return response()->json(['message' => 'Datos inválidos', 'errors' => $validator->errors()], 422);
        }
        $data = $validator->validated();
        $data['precio_venta'] = $data['precio_neto'] * 1.19;
        $product = Product::create($data);
        return response()->json($product, 201);
    }

    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['message' => 'Producto no encontrado'], 404);
        }
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'sku' => 'sometimes|string|unique:products,sku,' . $product->id,
            'nombre' => 'sometimes|string',
            'descripcion_corta' => 'sometimes|string',
            'descripcion_larga' => 'sometimes|string',
            'imagen_url' => 'sometimes|url',
            'precio_neto' => 'sometimes|numeric',
            'stock_actual' => 'sometimes|integer',
            'stock_minimo' => 'sometimes|integer',
            'stock_bajo' => 'sometimes|integer',
            'stock_alto' => 'sometimes|integer',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => 'Datos inválidos', 'errors' => $validator->errors()], 422);
        }
        $data = $validator->validated();
        if (isset($data['precio_neto'])) {
            $data['precio_venta'] = $data['precio_neto'] * 1.19;
        }
        $product->update($data);
        return response()->json($product, 200);
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['message' => 'Producto no encontrado'], 404);
        }
        $product->delete();
        return response()->json(['message' => 'Producto eliminado correctamente'], 200);
    }
}