<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Modelo Curso - Gestiona los cursos académicos del sistema
 * 
 * Representa un curso académico disponible en el sistema educativo.
 * Cada curso puede tener muchos estudiantes inscritos y cada estudiante
 * puede estar en muchos cursos, estableciendo una relación muchos-a-muchos
 * a través de la tabla intermedia estudiante_curso.
 * 
 * @package App\Models
 * @version 1.0.0
 * 
 * @property int $id_curso Identificador único del curso
 * @property string $nombre Nombre del curso académico

 * @author Desarrollo Ribert <ribertxdxd@gmail.com>
 * @copyright 2025 Ribert
 */
class Curso extends Model
{
    /**
     * Nombre de la tabla asociada al modelo
     * 
     * Definimos explícitamente 'cursos' para mayor claridad,
     * aunque Laravel lo inferiría automáticamente por convención.
     */
    protected $table = 'cursos';

    /**
     * Clave primaria personalizada de la tabla
     * 
     * Usamos 'id_curso' como identificador principal en lugar
     * del 'id' por defecto de Laravel para mantener consistencia
     * con el diseño existente de la base de datos.
     */
    protected $primaryKey = 'id_curso';

    /**
     * Indica si el modelo debe gestionar timestamps
     * 
     * Nuestra tabla de cursos no incluye los campos created_at
     * y updated_at automáticos de Laravel, por lo que desactivamos
     * esta funcionalidad para evitar errores.
     */
    public $timestamps = false;

    /**
     * Atributos que pueden ser asignados masivamente
     * 
     * Define qué campos pueden llenarse usando create() o fill().
     * En este caso, solo el nombre del curso puede asignarse
     * masivamente por seguridad.
     * 
     * @var array<string>
     */
    protected $fillable = [
        'nombre',
    ];

    /**
     * Relación muchos-a-muchos con el modelo Estudiante
     * 
     * Un curso puede tener muchos estudiantes inscritos.
     * Esta relación utiliza la tabla intermedia 'estudiante_curso'
     * para gestionar las inscripciones de estudiantes en cursos.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     * 
     * @example
     * $curso = Curso::find(1);
     * $estudiantes = $curso->estudiantes; // Todos los estudiantes del curso
     * 
     * @example
     * // Inscribir un estudiante en el curso
     * $curso->estudiantes()->attach(1);
     * 
     * @example
     * // Contar estudiantes inscritos
     * $totalEstudiantes = $curso->estudiantes()->count();
     */
    public function estudiantes(): BelongsToMany
    {
        return $this->belongsToMany(
            Estudiante::class,      // Modelo relacionado
            'estudiante_curso',     // Tabla intermedia
            'id_curso',             // Clave foránea de este modelo en la tabla intermedia
            'id_estudiante'         // Clave foránea del modelo relacionado
        );
    }
}