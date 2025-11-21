<?php

namespace App\Http\Controllers;

use App\Models\Pasaporte;
use Illuminate\Http\Request;
use Inertia\Inertia;

/**
 * Controlador para gestionar pasaportes en el sistema
 * 
 * Maneja todas las operaciones relacionadas con documentos de pasaporte.
 * Cada pasaporte está vinculado a una persona mediante relación uno-a-uno.
 * Incluye validaciones para garantizar la integridad de los datos.
 * 
 * @package App\Http\Controllers
 * @version 1.0.0
 * 
 * @author Desarrollo Ribert <ribertxdxd@gmail.com>
 * @copyright 2025 Ribert 
 */
class PasaporteController extends Controller
{
    /**
     * Muestra la lista de todos los pasaportes registrados
     * 
     * Retorna una vista de Inertia con la colección completa de pasaportes.
     * La vista se renderiza en el frontend para una interfaz moderna.
     * 
     * @return \Inertia\Response
     * 
     * @example
     * // Acceso través de: GET /pasaportes
     * // Retorna vista con datos para la vista lado del front
     */
    public function index()
    {
        return Inertia::render('pasaporte', [        
            'pasaportes' => Pasaporte::all(),
        ]);
    }

    /**
     * Muestra los detalles de un pasaporte específico
     * 
     * Busca un pasaporte por su ID único y retorna todos sus datos.
     * Si el pasaporte no existe, automáticamente retorna error 404.
     * Útil para verificar información de documentos específicos.
     * 
     * @param int $id ID único del pasaporte a buscar
     * @return \App\Models\Pasaporte
     * 
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     * 
     * @example
     * // Acceso través de: GET /pasaportes/101
     * // Retorna: {"id_pasaporte": 101, "numero": "A123456", ...}
     */
    public function show($id)
    {
        return Pasaporte::where('id_pasaporte', $id)->firstOrFail();
    }

    /**
     * Crea un nuevo pasaporte en el sistema
     * 
     * Valida y registra un nuevo documento de pasaporte.
     * La validación asegura que el ID y número sean únicos, y que la persona exista.
     * La relación uno-a-uno se mantiene mediante la unicidad de id_persona.
     * 
     * @param \Illuminate\Http\Request $request Datos del nuevo pasaporte
     * @return \App\Models\Pasaporte
     * 
     * @throws \Illuminate\Validation\ValidationException
     * 
     * @example
     * // Envío por POST /pasaportes con:
     * {
     *   "id_pasaporte": 106,
     *   "numero": "F678901",
     *   "id_persona": 6
     * }
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_pasaporte' => 'required|integer|unique:pasaportes,id_pasaporte',
            'numero' => 'required|string|max:20',
            'id_persona' => 'required|integer|unique:pasaportes,id_persona|exists:personas,id_persona',
        ]);
        
        return Pasaporte::create($validated);
    }

    /**
     * Actualiza la información de un pasaporte existente
     * 
     * Permite modificar los datos de un pasaporte ya registrado.
     * Los campos son opcionales para permitir actualizaciones parciales.
     * Incluye validación especial para evitar duplicados al cambiar la persona.
     * 
     * @param \Illuminate\Http\Request $request Datos a actualizar
     * @param int $id ID del pasaporte a modificar
     * @return \App\Models\Pasaporte
     * 
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     * @throws \Illuminate\Validation\ValidationException
     * 
     * @example
     * // Envío por PUT /pasaportes/101 con:
     * {
     *   "numero": "A1234567",
     *   "id_persona": 2
     * }
     */
    public function update(Request $request, $id)
    {
        $pasaporte = Pasaporte::where('id_pasaporte', $id)->firstOrFail();
        
        $validated = $request->validate([
            'numero' => 'sometimes|required|string|max:20',
            'id_persona' => 'sometimes|required|integer|unique:pasaportes,id_persona,' . $pasaporte->id . '|exists:personas,id_persona',
        ]);
        
        $pasaporte->update($validated);
        return $pasaporte;
    }

    /**
     * Elimina un pasaporte del sistema
     * 
     * Remueve permanentemente un pasaporte de la base de datos.
     * Antes de eliminar, verifica que el pasaporte exista.
     * Retorna un mensaje de confirmación en formato JSON.
     * 
     * @param int $id ID del pasaporte a eliminar
     * @return \Illuminate\Http\JsonResponse
     * 
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     * 
     * @example
     * // Envío por DELETE /pasaportes/101
     * // Retorna: {"message": "Pasaporte eliminado"}
     */
    public function destroy($id)
    {
        $pasaporte = Pasaporte::where('id_pasaporte', $id)->firstOrFail();
        $pasaporte->delete();
        
        return response()->json(['message' => 'Pasaporte eliminado']);
    }
}