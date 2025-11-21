<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Illuminate\Http\Request;

/**
 * Controlador para gestionar pedidos en el sistema
 * 
 * Maneja todas las operaciones relacionadas con pedidos: listar, mostrar detalles,
 * crear nuevos pedidos, actualizar información y eliminar registros.
 * Trabaja en conjunto con el modelo Cliente para mantener la integridad
 * de la relación uno-a-muchos entre clientes y sus pedidos.
 * 
 * @package App\Http\Controllers
 * @version 1.0.0
 * 
 * @author Desarrollo Ribert <ribertxdxd@gmail.com>
 * @copyright 2025 Ribert
 */
class PedidoController extends Controller
{
    /**
     * Obtiene la lista completa de pedidos registrados
     * 
     * Retorna todos los pedidos del sistema sin filtros.
     * Útil para vistas administrativas o reportes donde se
     * necesita visualizar el historial completo de pedidos.
     * 
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     * 
     * @example
     * // GET /pedidos
     * // Retorna: [{"id_pedido": 1001, "fecha": "2024-03-01", ...}, ...]
     */
    public function index()
    {
        return Pedido::all();
    }

    /**
     * Muestra los detalles de un pedido específico
     * 
     * Busca un pedido por su ID único y retorna todos sus datos.
     * Si el pedido no existe, automáticamente retorna error 404.
     * Útil para mostrar información detallada de un pedido específico
     * en modales o páginas de detalle.
     * 
     * @param int $id ID único del pedido a buscar
     * @return \App\Models\Pedido
     * 
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     * 
     * @example
     * // GET /pedidos/1001
     * // Retorna: {"id_pedido": 1001, "fecha": "2024-03-01", ...}
     */
    public function show($id)
    {
        return Pedido::findOrFail($id);
    }

    /**
     * Crea un nuevo pedido en el sistema
     * 
     * Valida y registra un nuevo pedido asociado a un cliente existente.
     * La validación incluye verificar que el cliente exista en la base
     * de datos y que todos los campos tengan el formato correcto.
     * 
     * @param \Illuminate\Http\Request $request Datos del nuevo pedido
     * @return \App\Models\Pedido
     * 
     * @throws \Illuminate\Validation\ValidationException
     * 
     * @example
     * // POST /pedidos
     * // Body: {
     * //   "fecha": "2024-04-10",
     * //   "id_cliente": 1,
     * //   "total": 150.75,
     * //   ... todos los campos requeridos
     * // }
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'fecha' => 'required|date',
            'id_cliente' => 'required|integer|exists:clientes,id_cliente',
            'total' => 'required|numeric',
            'metodo_pago' => 'required|string|max:30',
            'estado_pedido' => 'required|string|max:30',
            'direccion_envio' => 'required|string|max:100',
            'ciudad_envio' => 'required|string|max:50',
            'pais_envio' => 'required|string|max:50',
            'fecha_envio' => 'required|date',
            'observaciones' => 'nullable|string',
        ]);
        
        return Pedido::create($validated);
    }

    /**
     * Actualiza la información de un pedido existente
     * 
     * Permite modificar los datos de un pedido ya registrado.
     * Los campos son opcionales para permitir actualizaciones
     * parciales, como cambiar el estado del pedido o agregar
     * observaciones sin modificar toda la información.
     * 
     * @param \Illuminate\Http\Request $request Datos a actualizar
     * @param int $id ID del pedido a modificar
     * @return \App\Models\Pedido
     * 
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     * @throws \Illuminate\Validation\ValidationException
     * 
     * @example
     * // PUT /pedidos/1001
     * // Body: {"estado_pedido": "entregado", "observaciones": "Entregado satisfactoriamente"}
     */
    public function update(Request $request, $id)
    {
        $pedido = Pedido::findOrFail($id);
        
        $validated = $request->validate([
            'fecha' => 'sometimes|required|date',
            'id_cliente' => 'sometimes|required|integer|exists:clientes,id_cliente',
            'total' => 'sometimes|required|numeric',
            'metodo_pago' => 'sometimes|required|string|max:30',
            'estado_pedido' => 'sometimes|required|string|max:30',
            'direccion_envio' => 'sometimes|required|string|max:100',
            'ciudad_envio' => 'sometimes|required|string|max:50',
            'pais_envio' => 'sometimes|required|string|max:50',
            'fecha_envio' => 'sometimes|required|date',
            'observaciones' => 'nullable|string',
        ]);
        
        $pedido->update($validated);
        return $pedido;
    }

    /**
     * Elimina un pedido del sistema
     * 
     * Remueve permanentemente un pedido de la base de datos.
     * Antes de eliminar, verifica que el pedido exista.
     * Retorna un mensaje de confirmación en formato JSON
     * para notificar que la operación se completó exitosamente.
     * 
     * @param int $id ID del pedido a eliminar
     * @return \Illuminate\Http\JsonResponse
     * 
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     * 
     * @example
     * // DELETE /pedidos/1001
     * // Retorna: {"message": "Pedido eliminado"}
     */
    public function destroy($id)
    {
        $pedido = Pedido::findOrFail($id);
        $pedido->delete();
        
        return response()->json(['message' => 'Pedido eliminado']);
    }
}