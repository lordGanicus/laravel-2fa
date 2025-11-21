<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Modelo Pasaporte - Gestiona documentos de identificación internacional
 * 
 * Representa un pasaporte en el sistema con su información específica.
 * Cada pasaporte pertenece a una única persona mediante relación uno-a-uno.
 * 
 * @package App\Models
 * @version 1.0.0
 * 
 * @property int $id_pasaporte Identificador único del pasaporte
 * @property string $numero Número oficial del documento
 * @property int $id_persona Referencia a la persona dueña
 * 
 * @property-read \App\Models\Persona $persona Persona dueña del pasaporte
 * 
 * 
 * @author Desarrollo Ribert <ribertxdxd@gmail.com>
 * @copyright 2025 Ribert 
 */
class Pasaporte extends Model
{
    /**
     * Nombre de la tabla asociada al modelo
     */
    protected $table = 'pasaportes';

    /**
     * Clave primaria personalizada de la tabla
     * 
     * Usamos 'id_pasaporte' como identificador principal
     * en lugar del 'id' por defecto de Laravel.
     */
    protected $primaryKey = 'id_pasaporte';

    /**
     * Indica si el modelo debe gestionar timestamps
     * 
     * Nuestra tabla no tiene campos de timestamp automáticos
     */
    public $timestamps = false;

    /**
     * Atributos que pueden ser asignados masivamente
     * 
     * Campos permitidos para creación y actualización masiva.
     * Incluye la referencia a la persona dueña.
     * 
     * @var array<string>
     */
    protected $fillable = [
        'id_pasaporte',
        'numero',
        'id_persona',
    ];

    /**
     * Relación muchos-a-uno con el modelo Persona
     * 
     * Un pasaporte pertenece a una única persona.
     * La relación inversa de la definida en el modelo Persona.
     * 
     * @example
     * $pasaporte = Pasaporte::find(101);
     * $persona = $pasaporte->persona; // Obtiene la persona dueña
     */
    public function persona()
    {
        return $this->belongsTo(Persona::class, 'id_persona', 'id_persona');
    }
}