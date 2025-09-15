<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo que representa a un cliente empresa de VentasFix.
 */
class Client extends Model
{
    use HasFactory;

    /**
     * Campos que se permiten asignar masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'rut_empresa',
        'rubro',
        'razon_social',
        'telefono',
        'direccion',
        'contacto_nombre',
        'contacto_email',
    ];
}