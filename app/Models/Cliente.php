<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Modelo Cliente - Gestiona la información de clientes del sistema
 * 
 * Representa a un cliente en el sistema con todos sus datos de contacto
 * y características. Cada cliente puede realizar múltiples
 * pedidos, estableciendo una relación uno-a-muchos con la tabla de pedidos.
 * 
 * @package App\Models
 * @version 1.0.0
 * 
 * @property int $id_cliente Identificador único del cliente
 * @property string $nombre Nombre del cliente
 * @property string $apellido Apellido del cliente
 * @property string $correo Correo electrónico de contacto
 * @property string $telefono Número de teléfono
 * @property string $direccion Dirección física principal
 * @property string $ciudad Ciudad de residencia
 * @property string $pais País de residencia
 * @property string $fecha_registro Fecha de registro en el sistema
 * @property string $estado_cuenta Estado actual (activo/inactivo)
 * @property string $tipo_cliente Categorización 
 * 
 * @author Desarrollo Ribert <ribertxdxd@gmail.com>
 * @copyright 2025 Ribert
 */
class Cliente extends Model
{
    /**
     * Nombre de la tabla asociada al modelo
     * 
     * Definimos explícitamente 'clientes' aunque Laravel lo inferiría
     * por convención. Esto hace el código más claro y explícito.
     */
    protected $table = 'clientes';

    /**
     * Clave primaria personalizada de la tabla
     * 
     * Usamos 'id_cliente' como identificador principal en lugar
     * del 'id' por defecto de Laravel para mantener consistencia
     * con el diseño existente de la base de datos.
     */
    protected $primaryKey = 'id_cliente';

    /**
     * Indica si el modelo debe gestionar timestamps
     * 
     * Nuestra tabla de clientes no incluye los campos created_at
     * y updated_at automáticos de Laravel, por lo que desactivamos
     * esta funcionalidad para evitar errores.
     */
    public $timestamps = false;

    /**
     * Atributos que pueden ser asignados masivamente
     * 
     * Define qué campos pueden llenarse usando create() o fill().
     * Esto es importante para seguridad contra asignación masiva
     * y permite controlar qué datos pueden modificarse desde formularios.
     * 
     * @var array<string>
     */
    protected $fillable = [
        'nombre',
        'apellido',
        'correo',
        'telefono',
        'direccion',
        'ciudad',
        'pais',
        'fecha_registro',
        'estado_cuenta',
        'tipo_cliente',
    ];

    /**
     * Relación uno-a-muchos con el modelo Pedido
     * 
     * Un cliente puede tener muchos pedidos asociados.
     * Esta relación permite acceder fácilmente a todos los pedidos
     * que un cliente ha realizado a lo largo del tiempo.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     * 
     * @example
     * $cliente = Cliente::find(1);
     * $pedidos = $cliente->pedidos; // Obtiene todos los pedidos del cliente
     * 
     * @example
     * // Contar pedidos de un cliente
     * $totalPedidos = $cliente->pedidos()->count();
     */
    public function pedidos(): HasMany
    {
        return $this->hasMany(Pedido::class, 'id_cliente', 'id_cliente');
    }
}