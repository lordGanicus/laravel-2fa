<?php
// app/Models/Tenant.php

/**
 * Modelo Tenant personalizado que extiende el modelo base de Spatie
 * Agrega relaciones y atributos específicos de la aplicación
 * @package App\Models
 * 
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Multitenancy\Models\Tenant as SpatieTenant;

class Tenant extends SpatieTenant
{
    use HasFactory;

    protected $fillable = ['name', 'domain', 'is_active'];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}