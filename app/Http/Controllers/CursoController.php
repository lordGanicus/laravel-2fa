<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use Illuminate\Http\Request;

/**
 * Controlador para gestionar cursos académicos en el sistema
 * 
 * Maneja todas las operaciones relacionadas con cursos: listar, mostrar detalles,
 * crear nuevos cursos, actualizar información y eliminar registros.
 * Incluye funcionalidades avanzadas para trabajar con la relación muchos-a-muchos
 * con estudiantes mediante la tabla intermedia estudiante_curso.
 * 
 * @package App\Http\Controllers
 * @version 1.0.0
 * 
 * @author Desarrollo Ribert <ribertxdxd@gmail.com>
 * @copyright 2025 Ribert
 */
class CursoController extends Controller
{
    /**
     * Obtiene la lista completa de cursos con información de estudiantes
     * 
     * Retorna todos los cursos registrados en el sistema, incluyendo
     * el conteo de estudiantes inscritos en cada curso. El método incluye
     * ejemplos comentados de diferentes formas de filtrar y manipular
     * los datos según necesidades específicas de consulta.
     * 
     * @return \Illuminate\Http\JsonResponse
     * 
     * @example
     * // Retorna: [{"id_curso": 1, "nombre": "Matemáticas", "estudiantes_count": 5}, ...]
     */
    public function index()
    {
        // Obtenemos todos los cursos con el conteo de estudiantes inscritos
        // Esto es útil para mostrar una vista general de cursos con estadísticas
        $cursoEstudiante = Curso::withCount('estudiantes')->get();
        
        return response()->json($cursoEstudiante);

        // EJEMPLOS DE CONSULTAS AVANZADAS (COMENTADAS):
        //
        // Obtener cursos con estudiantes relacionados:
        // $cursoEstudiante = Curso::with('estudiantes')->get();
        //
        // Filtrar cursos que tienen al estudiante con ID 1:
        // ->whereHas('estudiantes', function ($query) {
        //     $query->where('estudiantes.id_estudiante', 1);
        // })
        //
        // Filtrar cursos que tienen estudiantes con apellido específico:
        // ->whereHas('estudiantes', function ($query) {
        //     $query->where('estudiantes.apellido', 'Mendoza');
        // })
        //
        // Filtrar curso específico con estudiante específico:
        // ->whereHas('estudiantes', function ($query) {
        //     $query->where('cursos.id_curso', 3)
        //           ->where('estudiantes.id_estudiante', 2);           
        // })
        //
        // Filtrar estudiantes específicos dentro de la relación:
        // $cursoEstudiante = Curso::with(['estudiantes' => function ($query) {
        //     $query->where('estudiantes.id_estudiante', 2);
        // }])
        // ->whereHas('estudiantes', function ($query) {
        //     $query->where('cursos.id_curso', 3);         
        // })
    }

    /**
     * Muestra los detalles de un curso específico
     * 
     * Busca un curso por su ID único y retorna todos sus datos.
     * Si el curso no existe en la base de datos, automáticamente
     * retorna una respuesta de error 404 Not Found.
     * 
     * @param int $id ID único del curso a buscar
     * @return \App\Models\Curso
     * 
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     * 
     * @example
     * // GET /cursos/1
     * // Retorna: {"id_curso": 1, "nombre": "Matemáticas"}
     */
    public function show($id)
    {
        return Curso::findOrFail($id);
    }

    /**
     * Crea un nuevo curso en el sistema
     * 
     * Valida y almacena un nuevo registro de curso académico.
     * La validación asegura que el nombre del curso tenga el
     * formato correcto y cumpla con las restricciones de la
     * base de datos antes de realizar la creación.
     * 
     * @param \Illuminate\Http\Request $request Datos del nuevo curso
     * @return \App\Models\Curso
     * 
     * @throws \Illuminate\Validation\ValidationException
     * 
     * @example
     * // POST /cursos
     * // Body: {"nombre": "Nuevo Curso"}
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:50',
        ]);
        
        return Curso::create($validated);
    }

    /**
     * Actualiza la información de un curso existente
     * 
     * Permite modificar los datos de un curso ya registrado.
     * El campo nombre es opcional (sometimes) para permitir
     * actualizaciones parciales sin necesidad de enviar todos
     * los datos en cada solicitud.
     * 
     * @param \Illuminate\Http\Request $request Datos a actualizar
     * @param int $id ID del curso a modificar
     * @return \App\Models\Curso
     * 
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     * @throws \Illuminate\Validation\ValidationException
     * 
     * @example
     * // PUT /cursos/1
     * // Body: {"nombre": "Matemáticas Avanzadas"}
     */
    public function update(Request $request, $id)
    {
        $curso = Curso::findOrFail($id);
        
        $validated = $request->validate([
            'nombre' => 'sometimes|required|string|max:50',
        ]);
        
        $curso->update($validated);
        return $curso;
    }

    /**
     * Elimina un curso del sistema
     * 
     * Remueve permanentemente un curso de la base de datos.
     * Antes de eliminar, verifica que el curso exista.
     * Retorna un mensaje de confirmación en formato JSON
     * para notificar que la operación se completó exitosamente.
     * 
     * @param int $id ID del curso a eliminar
     * @return \Illuminate\Http\JsonResponse
     * 
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     * 
     * @example
     * // DELETE /cursos/1
     * // Retorna: {"message": "Curso eliminado"}
     */
    public function destroy($id)
    {
        $curso = Curso::findOrFail($id);
        $curso->delete();
        
        return response()->json(['message' => 'Curso eliminado']);
    }
}