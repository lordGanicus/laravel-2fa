<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Modelo Persona - Información personal de individuos
 * 
 * Representa a una persona en el sistema con sus datos básicos de identificación.
 * Cada persona puede tener un único pasaporte asociado mediante relación uno-a-uno.
 * 
 * @package App\Models
 * @version 1.0.0
 * 
 * @property int $id_persona Identificador único de la persona
 * @property string $nombre Nombre de pila de la persona
 * @property string $apellido_paterno Primer apellido
 * @property string $apellido_materno Segundo apellido
 * 
 * @property-read \App\Models\Pasaporte|null $pasaporte Pasaporte asociado a la persona
 * 
  * @author Desarrollo Ribert <ribertxdxd@gmail.com>
 * @copyright 2025 Ribert 
 */
class Persona extends Model
{
    /**
     * Nombre de la tabla asociada al modelo
     * 
     * Por defecto Laravel usaría 'personas' pero lo definimos 
     * para mayor claridad en el código.
     */
    protected $table = 'personas';

    /**
     * Clave primaria personalizada de la tabla
     * 
     * Usamos 'id_persona' en lugar del 'id' por defecto de Laravel
     * para mantener consistencia con el diseño de la base de datos.
     */
    protected $primaryKey = 'id_persona';

    /**
     * Indica si el modelo debe gestionar timestamps
     * 
     * Como nuestra tabla no tiene created_at y updated_at,
     * desactivamos esta funcionalidad para evitar errores.
     */
    public $timestamps = false;

    /**
     * Atributos que pueden ser asignados masivamente
     * 
     * Define qué campos pueden llenarse usando create() o fill().
     * Importante para seguridad contra asignación masiva.
     * 
     * @var array<string>
     */
    protected $fillable = [
        'id_persona',
        'nombre',
        'apellido_paterno',
        'apellido_materno',
    ];

    /**
     * Relación uno-a-uno con el modelo Pasaporte
     * 
     * Una persona puede tener un único pasaporte asociado.
     * La relación se establece mediante el campo 'id_persona' en ambas tablas.
     * 
     * @example
     * $persona = Persona::find(1);
     * $pasaporte = $persona->pasaporte; // Obtiene el pasaporte si existe
     */
    public function pasaporte()
    {
        return $this->hasOne(Pasaporte::class, 'id_persona', 'id_persona');
    }
}