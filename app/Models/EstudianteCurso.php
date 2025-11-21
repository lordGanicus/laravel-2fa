<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * Modelo EstudianteCurso - Tabla intermedia para relación muchos-a-muchos
 * 
 * Representa la tabla intermedia que gestiona la relación muchos-a-muchos
 * entre estudiantes y cursos. Esta tabla almacena las inscripciones de
 * estudiantes en cursos específicos mediante pares de IDs.
 * 
 * Al extender de Pivot en lugar de Model, indicamos que esta clase
 * representa una tabla intermedia en una relación muchos-a-muchos.
 * 
 * @package App\Models
 * @version 1.0.0
 * 
 * @property int $id_estudiante Identificador del estudiante
 * @property int $id_curso Identificador del curso
 * 
 * @author Desarrollo Ribert <ribertxdxd@gmail.com>
 * @copyright 2025 Ribert
 */
class EstudianteCurso extends Pivot
{
    /**
     * Nombre de la tabla asociada al modelo
     * 
     * Definimos explícitamente 'estudiante_curso' como nombre
     * de la tabla intermedia que gestiona esta relación.
     */
    protected $table = 'estudiante_curso';

    /**
     * Indica si el modelo debe gestionar timestamps
     * 
     * La tabla intermedia no incluye campos de timestamp,
     * por lo que desactivamos esta funcionalidad.
     */
    public $timestamps = false;

    /**
     * Atributos que pueden ser asignados masivamente
     * 
     * Define qué campos pueden llenarse usando create() o fill().
     * En este caso, solo los IDs de estudiante y curso pueden
     * asignarse masivamente para crear nuevas inscripciones.
     * 
     * @var array<string>
     */
    protected $fillable = [
        'id_estudiante',
        'id_curso',
    ];

    // NOTA: En relaciones muchos-a-muchos, normalmente no necesitamos
    // definir métodos de relación adicionales en el modelo Pivot,
    // ya que las relaciones principales están definidas en los
    // modelos Estudiante y Curso. Sin embargo, si necesitáramos
    // agregar campos adicionales a la tabla intermedia (como
    // fecha_inscripcion, calificacion, etc.), podríamos definir
    // relaciones belongsTo aquí.
}