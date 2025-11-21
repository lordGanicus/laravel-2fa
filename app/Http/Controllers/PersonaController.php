<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use Illuminate\Http\Request;
use Inertia\Inertia;

/**
 * Controlador para gestionar personas en el sistema
 * 
 * Maneja todas las operaciones relacionadas con personas: listar, mostrar,
 * crear, actualizar y eliminar. Trabaja en conjunto con el modelo Persona
 * para mantener la información personal de los individuos en el sistema.
 * 
 * @package App\Http\Controllers
 * @version 1.0.0
 * 
 * @author Desarrollo Ribert <ribertxdxd@gmail.com>
 * @copyright 2025 Ribert 
 */
class PersonaController extends Controller
{
    /**
     * Muestra la lista de todas las personas registradas
     * 
     * Retorna una vista de Inertia con la colección completa de personas.
     * Esta vista se renderiza en el frontend con React para una experiencia
     * de usuario más dinámica e interactiva.
     * 
     * @return \Inertia\Response
     * 
     * @example
     * // Acceso través de: GET /personas
     * // Retorna vista con datos para React
     */
    public function index()
    {
        return Inertia::render('personas', [
            'personas' => Persona::all(),
        ]);
    }

    /**
     * Muestra los detalles de una persona específica
     * 
     * Busca una persona por su ID único y retorna todos sus datos.
     * Si la persona no existe, automáticamente retorna error 404.
     * Funciona mostrar información detallada en modales o páginas individuales.
     * 
     * @param int $id ID único de la persona a buscar
     * @return \App\Models\Persona
     * 
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     * 
     * @example
     * // Acceso través de: GET /personas/1
     * // Retorna: {"id_persona": 1, "nombre": "Juan", ...}
     */
    public function show($id)
    {
        return Persona::where('id_persona', $id)->firstOrFail();
    }

    /**
     * Crea una nueva persona en el sistema
     * 
     * Valida los datos recibidos y crea un nuevo registro de persona.
     * La validación asegura que el ID sea único y los nombres tengan formato correcto.
     * Retorna la persona recién creada con todos sus datos.
     * 
     * @param \Illuminate\Http\Request $request Datos de la nueva persona
     * @return \App\Models\Persona
     * 
     * @throws \Illuminate\Validation\ValidationException
     * 
     * @example
     * // Envío por POST /personas con:
     * {
     *   "id_persona": 6,
     *   "nombre": "Laura",
     *   "apellido_paterno": "Gonzalez",
     *   "apellido_materno": "Lopez"
     * }
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_persona' => 'required|integer|unique:personas,id_persona',
            'nombre' => 'required|string|max:50',
            'apellido_paterno' => 'required|string|max:50',
            'apellido_materno' => 'required|string|max:50',
        ]);
        
        return Persona::create($validated);
    }

    /**
     * Actualiza la información de una persona existente
     * 
     * Permite modificar los datos de una persona ya registrada.
     * Los campos son opcionales (sometimes) para permitir actualizaciones parciales.
     * Busca la persona por ID y aplica solo los cambios proporcionados.
     * 
     * @param \Illuminate\Http\Request $request Datos a actualizar
     * @param int $id ID de la persona a modificar
     * @return \App\Models\Persona
     * 
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     * @throws \Illuminate\Validation\ValidationException
     * 
     * @example
     * // Envío por PUT /personas/1 con:
     * {
     *   "nombre": "Juan Carlos",
     *   "apellido_paterno": "Pérez"
     * }
     */
    public function update(Request $request, $id)
    {
        $persona = Persona::where('id_persona', $id)->firstOrFail();
        
        $validated = $request->validate([
            'nombre' => 'sometimes|required|string|max:50',
            'apellido_paterno' => 'sometimes|required|string|max:50',
            'apellido_materno' => 'sometimes|required|string|max:50',
        ]);
        
        $persona->update($validated);
        return $persona;
    }

    /**
     * Elimina una persona del sistema
     * 
     * Remueve permanentemente a una persona de la base de datos.
     * Antes de eliminar, verifica que la persona exista.
     * Retorna un mensaje de confirmación en formato JSON.
     * 
     * @param int $id ID de la persona a eliminar
     * @return \Illuminate\Http\JsonResponse
     * 
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     * 
     * @example
     * // Envío por DELETE /personas/1
     * // Retorna: {"message": "Persona eliminada"}
     */
    public function destroy($id)
    {
        $persona = Persona::where('id_persona', $id)->firstOrFail();
        $persona->delete();
        
        return response()->json(['message' => 'Persona eliminada']);
    }
}