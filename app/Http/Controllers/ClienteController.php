<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

/**
 * Controlador para gestionar clientes en el sistema
 * 
 * Maneja todas las operaciones relacionadas con clientes: listar, mostrar detalles,
 * crear nuevos clientes, actualizar información y eliminar registros.
 * Incluye funcionalidades para trabajar con la relación uno-a-muchos con pedidos.
 * 
 * @package App\Http\Controllers
 * @version 1.0.0
 * 
 * @author Desarrollo Ribert <ribertxdxd@gmail.com>
 * @copyright 2025 Ribert
 */
class ClienteController extends Controller
{
    /**
     * Obtiene la lista completa de clientes con sus pedidos
     * 
     * Retorna todos los clientes en el sistema, incluyendo
     * sus pedidos relacionados mediante eager loading. El método incluye
     * ejemplos comentados de diferentes formas de filtrar y manipular
     * los datos según necesidades específicas.
     * 
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     * 
     * @example
     * // Retorna: [{"id_cliente": 1, "nombre": "Pedro", "pedidos": [...]}, ...]
     * 
     * @example
     * // Ejemplos de consultas adicionales (actualmente comentadas):
     * // - Filtrar por ID específico
     * // - Ordenar clientes
     * // - Excluir clientes específicos
     * // - Seleccionar columnas específicas
     * // - Contar pedidos por cliente
     */
    public function index()
    {
        // Obtenemos todos los clientes con sus pedidos relacionados
        // Esto es útil para mostrar una vista completa de clientes
        // con su historial de pedidos en una sola consulta
        $clientesPedidos = Cliente::with('pedidos')->get();
        
        return $clientesPedidos;

        //  EJEMPLOS DE CONSULTAS ADICIONALES (COMENTADAS):
        // 
        // Filtrar cliente específico:
        // ->where('id_cliente', 2)
        //
        // Ordenar clientes de mayor a menor ID:
        // ->orderBy('id_cliente', 'desc')
        //
        // Clientes con ID mayor a 2:
        // ->where('id_cliente', '>', 2)
        //
        // Excluir cliente específico:
        // ->where('id_cliente', '!=', 2)
        //
        // Seleccionar columnas específicas:
        // ->select('id_cliente', 'nombre', 'apellido', 'correo')
        //
        // Contar total de pedidos por cliente:
        // ->withCount('pedidos as total_clientes')
    }

    /**
     * Muestra los detalles de un cliente específico
     * 
     * Busca un cliente por su ID único y retorna todos sus datos.
     * Si el cliente no existe en la base de datos, automáticamente
     * retorna una respuesta de error 404 Not Found.
     * 
     * @param int $id ID único del cliente a buscar
     * @return \App\Models\Cliente
     * 
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     * 
     * @example
     * // GET /clientes/1
     * // Retorna: {"id_cliente": 1, "nombre": "Pedro", ...}
     */
    public function show($id)
    {
        return Cliente::findOrFail($id);
    }

    /**
     * Crea un nuevo cliente en el sistema
     * 
     * Valida y almacena un nuevo registro de cliente con todos
     * los datos requeridos. La validación asegura que los campos
     * tengan el formato correcto y cumplan con las restricciones
     * de la base de datos antes de realizar la creación.
     * 
     * @param \Illuminate\Http\Request $request Datos del nuevo cliente
     * @return \App\Models\Cliente
     * 
     * @throws \Illuminate\Validation\ValidationException
     * 
     * @example
     * // POST /clientes
     * // Body: {
     * //   "nombre": "Nuevo",
     * //   "apellido": "Cliente",
     * //   "correo": "nuevo@email.com",
     * //   ... todos los campos requeridos
     * // }
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:50',
            'apellido' => 'required|string|max:50',
            'correo' => 'required|email|max:100',
            'telefono' => 'required|string|max:20',
            'direccion' => 'required|string|max:100',
            'ciudad' => 'required|string|max:50',
            'pais' => 'required|string|max:50',
            'fecha_registro' => 'required|date',
            'estado_cuenta' => 'required|string|max:20',
            'tipo_cliente' => 'required|string|max:30',
        ]);
        
        return Cliente::create($validated);
    }

    /**
     * Actualiza la información de un cliente existente
     * 
     * Permite modificar los datos de un cliente ya registrado.
     * Los campos son opcionales (sometimes) para permitir
     * actualizaciones parciales sin necesidad de enviar todos
     * los datos del cliente en cada solicitud.
     * 
     * @param \Illuminate\Http\Request $request Datos a actualizar
     * @param int $id ID del cliente a modificar
     * @return \App\Models\Cliente
     * 
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     * @throws \Illuminate\Validation\ValidationException
     * 
     * @example
     * // PUT /clientes/1
     * // Body: {"nombre": "Pedro Actualizado", "correo": "nuevo@email.com"}
     * // Solo se actualizan los campos enviados
     */
    public function update(Request $request, $id)
    {
        $cliente = Cliente::findOrFail($id);
        
        $validated = $request->validate([
            'nombre' => 'sometimes|required|string|max:50',
            'apellido' => 'sometimes|required|string|max:50',
            'correo' => 'sometimes|required|email|max:100',
            'telefono' => 'sometimes|required|string|max:20',
            'direccion' => 'sometimes|required|string|max:100',
            'ciudad' => 'sometimes|required|string|max:50',
            'pais' => 'sometimes|required|string|max:50',
            'fecha_registro' => 'sometimes|required|date',
            'estado_cuenta' => 'sometimes|required|string|max:20',
            'tipo_cliente' => 'sometimes|required|string|max:30',
        ]);
        
        $cliente->update($validated);
        return $cliente;
    }

    /**
     * Elimina un cliente del sistema
     * 
     * Remueve permanentemente a un cliente de la base de datos.
     * Antes de eliminar, verifica que el cliente exista.
     * Retorna un mensaje de confirmación en formato JSON
     * para notificar que la operación se completó exitosamente.
     * 
     * @param int $id ID del cliente a eliminar
     * @return \Illuminate\Http\JsonResponse
     * 
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     * 
     * @example
     * // DELETE /clientes/1
     * // Retorna: {"message": "Cliente eliminado"}
     */
    public function destroy($id)
    {
        $cliente = Cliente::findOrFail($id);
        $cliente->delete();
        
        return response()->json(['message' => 'Cliente eliminado']);
    }
}