<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Modelo Pedido - Gestiona los pedidos realizados por clientes
 * 
 * Representa un pedido en el sistema con toda su información de envío,
 * pago y estado. Cada pedido pertenece a un único cliente, estableciendo
 * la relación inversa de uno-a-muchos con la tabla de clientes.
 * 
 * @package App\Models
 * @version 1.0.0
 * 
 * @property int $id_pedido Identificador único del pedido
 * @property string $fecha Fecha en que se realizó el pedido
 * @property int $id_cliente Cliente que realizó el pedido
 * @property string $total Monto total del pedido
 * @property string $metodo_pago Forma de pago utilizada
 * @property string $estado_pedido Estado actual del pedido
 * @property string $direccion_envio Dirección de envío
 * @property string $ciudad_envio Ciudad de destino
 * @property string $pais_envio País de destino
 * @property string $fecha_envio Fecha programada de envío
 * @property string|null $observaciones Notas adicionales opcionales
 * 
 * @property-read \App\Models\Cliente $cliente Cliente dueño del pedido
 * 
 * @author Desarrollo Ribert <ribertxdxd@gmail.com>
 * @copyright 2025 Ribert
 */
class Pedido extends Model
{
    /**
     * Nombre de la tabla asociada al modelo
     */
    protected $table = 'pedidos';

    /**
     * Clave primaria personalizada de la tabla
     * 
     * Usamos 'id_pedido' como identificador principal para
     * mantener consistencia con el diseño de la base de datos.
     */
    protected $primaryKey = 'id_pedido';

    /**
     * Indica si el modelo debe gestionar timestamps
     * 
     * La tabla de pedidos no incluye los timestamps automáticos
     * de Laravel, por lo que desactivamos esta funcionalidad.
     */
    public $timestamps = false;

    /**
     * Atributos que pueden ser asignados masivamente
     * 
     * Campos permitidos para creación y actualización masiva.
     * Incluye todos los datos necesarios para gestionar un pedido
     * completo, desde la información básica hasta los detalles de envío.
     * 
     * @var array<string>
     */
    protected $fillable = [
        'fecha',
        'id_cliente',
        'total',
        'metodo_pago',
        'estado_pedido',
        'direccion_envio',
        'ciudad_envio',
        'pais_envio',
        'fecha_envio',
        'observaciones',
    ];

    /**
     * Relación muchos-a-uno con el modelo Cliente
     * 
     * Un pedido pertenece a un único cliente.
     * Esta relación permite acceder fácilmente a la información
     * del cliente que realizó el pedido, útil para reportes
     * y seguimiento de órdenes.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * 
     * @example
     * $pedido = Pedido::find(1001);
     * $cliente = $pedido->cliente; // Obtiene el cliente del pedido
     * 
     * @example
     * // Buscar pedidos de un cliente específico
     * $pedidosCliente = Pedido::whereHas('cliente', function($query) {
     *     $query->where('nombre', 'Pedro');
     * })->get();
     */
    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class, 'id_cliente', 'id_cliente');
    }
}