<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Client;

/**
 * Controlador para la página principal del backoffice.
 *
 * Proporciona estadísticas básicas como el número de usuarios, productos y
 * clientes registrados en el sistema.
 */
class DashboardController extends Controller
{
    /**
     * Muestra el dashboard con las estadísticas.
     */
    public function index()
    {
        $totalUsers = User::count();
        $totalProducts = Product::count();
        $totalClients = Client::count();
        return view('dashboard.index', compact('totalUsers', 'totalProducts', 'totalClients'));
    }
}