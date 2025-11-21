<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use Illuminate\Http\Request;

/**
 * Controlador para gestionar estudiantes en el sistema académico
 * 
 * Maneja todas las operaciones relacionadas con estudiantes: listar, mostrar detalles,
 * crear nuevos estudiantes, actualizar información y eliminar registros.
 * Incluye funcionalidades para trabajar con la relación muchos-a-muchos
 * con cursos mediante la tabla intermedia estudiante_curso.
 * 
 * @package App\Http\Controllers
 * @version 1.0.0
 * 
 * @author Desarrollo Ribert <ribertxdxd@gmail.com>
 * @copyright 2025 Ribert
 */
class EstudianteController extends Controller
{
    /**
     * Obtiene la lista completa de estudiantes con sus cursos
     * 
     * Retorna todos los estudiantes registrados en el sistema, incluyendo
     * los cursos en los que están inscritos. El método incluye ejemplos
     * comentados de diferentes formas de filtrar estudiantes según
     * los cursos en los que están matriculados.
     * 
     * @return \Illuminate\Http\JsonResponse
     * 
     * @example
     * // Retorna: [{"id_estudiante": 1, "nombre": "Miguel", "cursos": [...]}, ...]
     */
    public function index()
    {
        // Obtenemos todos los estudiantes con sus cursos relacionados
        // Esto es útil para mostrar una vista completa de estudiantes
        // con su carga académica actual
        $estudianteCurso = Estudiante::with('cursos')->get();
        
        return response()->json($estudianteCurso);

        // EJEMPLOS DE CONSULTAS AVANZADAS (COMENTADAS):
        //
        // Filtrar estudiantes que están en un curso específico (por ID):
        // ->whereHas('cursos', function ($query) {
        //     $query->where('cursos.id_curso', 2);
        // })
        //
        // Filtrar estudiantes que están en Matemáticas (curso ID 1):
        // ->whereHas('cursos', function ($query) {
        //     $query->where('cursos.id_curso', 1);
        // })
        //
        // Obtener estudiantes con conteo de cursos:
        // $estudianteCurso = Estudiante::withCount('cursos')->get();
        //
        // Filtrar estudiantes que están en más de 2 cursos:
        // $estudianteCurso = Estudiante::withCount('cursos')
        //     ->having('cursos_count', '>', 2)
        //     ->get();
    }

    /**
     * Muestra los detalles de un estudiante específico
     * 
     * Busca un estudiante por su ID único y retorna todos sus datos.
     * Si el estudiante no existe, automáticamente retorna error 404.
     * Útil para mostrar información detallada de un estudiante
     * incluyendo su perfil académico completo.
     * 
     * @param int $id ID único del estudiante a buscar
     * @return \App\Models\Estudiante
     * 
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     * 
     * @example
     * // GET /estudiantes/1
     * // Retorna: {"id_estudiante": 1, "nombre": "Miguel", ...}
     */
    public function show($id)
    {
        return Estudiante::findOrFail($id);
    }

    /**
     * Crea un nuevo estudiante en el sistema
     * 
     * Valida y almacena un nuevo registro de estudiante con sus
     * datos básicos de identificación. La validación asegura que
     * los campos tengan el formato correcto antes de la creación.
     * 
     * @param \Illuminate\Http\Request $request Datos del nuevo estudiante
     * @return \App\Models\Estudiante
     * 
     * @throws \Illuminate\Validation\ValidationException
     * 
     * @example
     * // POST /estudiantes
     * // Body: {"nombre": "Nuevo", "apellido": "Estudiante"}
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:50',
            'apellido' => 'required|string|max:50',
        ]);
        
        return Estudiante::create($validated);
    }

    /**
     * Actualiza la información de un estudiante existente
     * 
     * Permite modificar los datos de un estudiante ya registrado.
     * Los campos son opcionales para permitir actualizaciones
     * parciales, como corregir un nombre o apellido sin modificar
     * toda la información del estudiante.
     * 
     * @param \Illuminate\Http\Request $request Datos a actualizar
     * @param int $id ID del estudiante a modificar
     * @return \App\Models\Estudiante
     * 
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     * @throws \Illuminate\Validation\ValidationException
     * 
     * @example
     * // PUT /estudiantes/1
     * // Body: {"nombre": "Miguel Ángel", "apellido": "Santos García"}
     */
    public function update(Request $request, $id)
    {
        $estudiante = Estudiante::findOrFail($id);
        
        $validated = $request->validate([
            'nombre' => 'sometimes|required|string|max:50',
            'apellido' => 'sometimes|required|string|max:50',
        ]);
        
        $estudiante->update($validated);
        return $estudiante;
    }

    /**
     * Elimina un estudiante del sistema
     * 
     * Remueve permanentemente a un estudiante de la base de datos.
     * Antes de eliminar, verifica que el estudiante exista.
     * Retorna un mensaje de confirmación en formato JSON
     * para notificar que la operación se completó exitosamente.
     * 
     * @param int $id ID del estudiante a eliminar
     * @return \Illuminate\Http\JsonResponse
     * 
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     * 
     * @example
     * // DELETE /estudiantes/1
     * // Retorna: {"message": "Estudiante eliminado"}
     */
    public function destroy($id)
    {
        $estudiante = Estudiante::findOrFail($id);
        $estudiante->delete();
        
        return response()->json(['message' => 'Estudiante eliminado']);
    }
}