<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Modelo Estudiante - Gestiona los estudiantes del sistema académico
 * 
 * Representa a un estudiante en el sistema educativo con sus datos básicos.
 * Cada estudiante puede estar inscrito en muchos cursos y cada curso puede
 * tener muchos estudiantes, estableciendo una relación muchos-a-muchos
 * a través de la tabla intermedia estudiante_curso.
 * 
 * @package App\Models
 * @version 1.0.0
 * 
 * @property int $id_estudiante Identificador único del estudiante
 * @property string $nombre Nombre del estudiante
 * @property string $apellido Apellido del estudiante
 * 
 * 
 * @author Desarrollo Ribert <ribertxdxd@gmail.com>
 * @copyright 2025 Ribert
 */
class Estudiante extends Model
{
    /**
     * Nombre de la tabla asociada al modelo
     */
    protected $table = 'estudiantes';

    /**
     * Clave primaria personalizada de la tabla
     * 
     * Usamos 'id_estudiante' como identificador principal para
     * mantener consistencia con el diseño de la base de datos.
     */
    protected $primaryKey = 'id_estudiante';

    /**
     * Indica si el modelo debe gestionar timestamps
     * 
     * La tabla de estudiantes no incluye los timestamps automáticos
     * de Laravel, por lo que desactivamos esta funcionalidad.
     */
    public $timestamps = false;

    /**
     * Atributos que pueden ser asignados masivamente
     * 
     * Campos permitidos para creación y actualización masiva.
     * Incluye solo los datos básicos de identificación del estudiante.
     * 
     * @var array<string>
     */
    protected $fillable = [
        'nombre',
        'apellido',
    ];

    /**
     * Relación muchos-a-muchos con el modelo Curso
     * 
     * Un estudiante puede estar inscrito en muchos cursos.
     * Esta relación es la inversa de la definida en el modelo Curso
     * y utiliza la misma tabla intermedia para gestionar las inscripciones.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     * 
     * @example
     * $estudiante = Estudiante::find(1);
     * $cursos = $estudiante->cursos; // Todos los cursos del estudiante
     * 
     * @example
     * // Inscribir al estudiante en un curso
     * $estudiante->cursos()->attach(1);
     * 
     * @example
     * // Obtener estudiantes con sus cursos
     * $estudiantesConCursos = Estudiante::with('cursos')->get();
     */
    public function cursos(): BelongsToMany
    {
        return $this->belongsToMany(
            Curso::class,           // Modelo relacionado
            'estudiante_curso',     // Tabla intermedia
            'id_estudiante',        // Clave foránea de este modelo en la tabla intermedia
            'id_curso'              // Clave foránea del modelo relacionado
        );
    }
}