<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

/**
 * Migracion principal del sistema - Creación de todas las tablas
 * 
 * Esta migracion establece la estructura completa de la base de datos del sistema,
 * incluyendo tres tipos de relaciones: uno-a-uno, uno-a-muchos y muchos-a-muchos.
 * Se implementa en una sola migración para garantizar la integridad referencial
 * y el orden correcto de dependencias entre tablas.
 * 
 * Nota: Mantener todas las tablas en una unica migración facilita el
 * orden y el seguimiento mientras el proyecto no sea grande. Para
 * proyectos más grandes o con equipos, se recomienda dividir las
 * migraciones por dominio/entidad para mejorar el mantenimiento.
 * 
 * @version 1.0.0
 * @package Database\Migrations
 * 
 * @author Desarrollo Ribert <ribertxdxd@gmail.com>
 * @copyright 2025 Ribert 
 */
return new class extends Migration
{
    /**
     * Ejecutar la migración
     * 
     * Crea la estructura completa de la base de datos con:
     * - Tablas base para entidades principales
     * - Relaciones de integridad referencial
     * - Campos optimizados para cada tipo de dato
     * - Claves primarias y foráneas adecuadas
     * 
     * @return void
     * 
     * @throws \Illuminate\Database\QueryException
     * 
     * @example
     * php artisan migrate --path=database/migrations/2025_11_11_132345_migracion_global.php
     */
    public function up(): void
    {
        // ==================== RELACIÓN UNO A UNO ====================
        
        /**
         * Tabla personas - Entidad principal para relación uno-a-uno
         * 
         * Almacena la información básica de personas que pueden tener
         * un pasaporte asociado mediante relación única.
         */
        Schema::create('personas', function (Blueprint $table) {
            // ==================== CLAVES PRIMARIAS ====================
            
            /**
             * ID interno de Laravel (auto-incremental)
             * Tipo: BIGINT UNSIGNED
             * Clave primaria automática
             */
            $table->id()->comment('ID único interno generado por Laravel');
            
            /**
             * ID de persona identificador unico para: persona 
             * Tipo: INTEGER
             * Unique: Sí (identificador único)
             */
            $table->integer('id_persona')
                  ->unique()
                  ->comment('Identificador único de persona ');
            
            // ==================== DATOS PERSONALES ====================
            
            /**
             * Nombre de pila
             * Tipo: VARCHAR(50)
             * Nullable: NO
             */
            $table->string('nombre', 50)
                  ->comment('Nombre de pila de la persona');
            
            /**
             * Primer apellido
             * Tipo: VARCHAR(50)
             * Nullable: NO
             */
            $table->string('apellido_paterno', 50)
                  ->comment('Primer apellido de la persona');
            
            /**
             * Segundo apellido
             * Tipo: VARCHAR(50)
             * Nullable: NO
             */
            $table->string('apellido_materno', 50)
                  ->comment('Segundo apellido de la persona');
        });

        /**
         * Tabla pasaportes - Entidad relacionada uno-a-uno con personas
         * 
         * Almacena información de pasaportes con relación única hacia personas.
         * Cada persona puede tener solo un pasaporte y viceversa.
         */
        Schema::create('pasaportes', function (Blueprint $table) {
            // ==================== CLAVES PRIMARIAS ====================
            
            $table->id()->comment('ID único interno generado por Laravel');
            
            /**
             * ID único del pasaporte
             * Tipo: INTEGER
             * Unique: Sí (identificador único de documento)
             */
            $table->integer('id_pasaporte')
                  ->unique()
                  ->comment('Identificador único del documento de pasaporte');
            
            // ==================== DATOS DEL DOCUMENTO ====================
            
            /**
             * Número del pasaporte
             * Tipo: VARCHAR(20)
             * Nullable: NO
             */
            $table->string('numero', 20)
                  ->comment('Número del documento de pasaporte');
            
            /**
             * Relación con persona dueña
             * Tipo: INTEGER
             * Unique: Sí (una persona, un pasaporte)
             * Foreign: Sí (referencia a personas.id_persona)
             */
            $table->integer('id_persona')
                  ->unique()
                  ->comment('Referencia única a la persona dueña del pasaporte');
            
            // ==================== CLAVES FORÁNEAS ====================
            
            /**
             * Clave foránea hacia tabla personas
             * Garantiza integridad referencial: cada pasaporte pertenece a una persona válida
             */
            $table->foreign('id_persona')
                  ->references('id_persona')
                  ->on('personas')
                  ->comment('Vinculo referencial con la tabla de personas');
        });

          // ==================== RELACIÓN UNO A MUCHOS ====================
        
        /**
         * Tabla clientes - Entidad principal para relación uno-a-muchos
         * 
         * Almacena la información completa de clientes del sistema.
         * Un cliente puede realizar múltiples pedidos (relación 1:N).
         */
        Schema::create('clientes', function (Blueprint $table) {
            /**
             * Identificador único del cliente
             * Tipo: INTEGER
             * Primary: Sí (clave primaria personalizada)
             */
            $table->integer('id_cliente')
                  ->primary()
                  ->comment('Identificador único del cliente en el sistema');
            
            /**
             * Nombre del cliente
             * Tipo: VARCHAR(50)
             * Nullable: NO
             */
            $table->string('nombre', 50)
                  ->comment('Nombre del cliente');
            
            /**
             * Apellido del cliente
             * Tipo: VARCHAR(50)
             * Nullable: NO
             */
            $table->string('apellido', 50)
                  ->comment('Apellido del cliente');
            
            /**
             * Correo electrónico
             * Tipo: VARCHAR(100)
             * Nullable: NO
             */
            $table->string('correo', 100)
                  ->comment('Dirección de correo electrónico del cliente');
            
            /**
             * Número de teléfono
             * Tipo: VARCHAR(20)
             * Nullable: NO
             */
            $table->string('telefono', 20)
                  ->comment('Número de teléfono de contacto');
            
            /**
             * Dirección física
             * Tipo: VARCHAR(100)
             * Nullable: NO
             */
            $table->string('direccion', 100)
                  ->comment('Dirección física principal del cliente');
            
            /**
             * Ciudad de residencia
             * Tipo: VARCHAR(50)
             * Nullable: NO
             */
            $table->string('ciudad', 50)
                  ->comment('Ciudad de residencia del cliente');
            
            /**
             * País de residencia
             * Tipo: VARCHAR(50)
             * Nullable: NO
             */
            $table->string('pais', 50)
                  ->comment('País de residencia del cliente');
            
            /**
             * Fecha de registro en el sistema
             * Tipo: DATE
             * Nullable: NO
             */
            $table->date('fecha_registro')
                  ->comment('Fecha de registro del cliente en el sistema');
            
            /**
             * Estado actual de la cuenta
             * Tipo: VARCHAR(20)
             * Nullable: NO
             */
            $table->string('estado_cuenta', 20)
                  ->comment('Estado actual de la cuenta del cliente (activo/inactivo)');
            
            /**
             * Categorización del cliente
             * Tipo: VARCHAR(30)
             * Nullable: NO
             */
            $table->string('tipo_cliente', 30)
                  ->comment('Categorización del cliente (regular, premium, vip)');
        });

        /**
         * Tabla pedidos - Entidad relacionada uno-a-muchos con clientes
         * 
         * Almacena los pedidos realizados por los clientes.
         * Relación uno-a-muchos: un cliente puede tener múltiples pedidos.
         */
         Schema::create('pedidos', function (Blueprint $table) {
            /**
             * Identificador único del pedido
             * Tipo: INTEGER
             * Primary: Sí (clave primaria personalizada)
             */
            $table->integer('id_pedido')
                  ->primary()
                  ->comment('Identificador único del pedido en el sistema');
            
            /**
             * Fecha del pedido
             * Tipo: DATE
             * Nullable: NO
             */
            $table->date('fecha')
                  ->comment('Fecha en que se realizó el pedido');
            
            /**
             * Referencia al cliente
             * Tipo: INTEGER
             * Foreign: Sí (clave foránea hacia clientes)
             */
            $table->integer('id_cliente')
                  ->comment('Referencia al cliente que realizó el pedido');
            
            /**
             * Monto total del pedido
             * Tipo: DECIMAL(10,2)
             * Nullable: NO
             * Precisión: 10 dígitos total, 2 decimales
             */
            $table->decimal('total', 10, 2)
                  ->comment('Monto total del pedido con 2 decimales de precisión');
            
            /**
             * Método de pago utilizado
             * Tipo: VARCHAR(30)
             * Nullable: NO
             */
            $table->string('metodo_pago', 30)
                  ->comment('Método de pago utilizado en el pedido');
            
            /**
             * Estado actual del pedido
             * Tipo: VARCHAR(30)
             * Nullable: NO
             */
            $table->string('estado_pedido', 30)
                  ->comment('Estado actual del proceso del pedido');
            
            /**
             * Dirección de envío
             * Tipo: VARCHAR(100)
             * Nullable: NO
             */
            $table->string('direccion_envio', 100)
                  ->comment('Dirección de envío para el pedido');
            
            /**
             * Ciudad de envío
             * Tipo: VARCHAR(50)
             * Nullable: NO
             */
            $table->string('ciudad_envio', 50)
                  ->comment('Ciudad de destino del envío');
            
            /**
             * País de envío
             * Tipo: VARCHAR(50)
             * Nullable: NO
             */
            $table->string('pais_envio', 50)
                  ->comment('País de destino del envío');
            
            /**
             * Fecha programada de envío
             * Tipo: DATE
             * Nullable: NO
             */
            $table->date('fecha_envio')
                  ->comment('Fecha programada para el envío del pedido');
            
            /**
             * Observaciones adicionales
             * Tipo: TEXT
             * Nullable: SÍ (opcional)
             */
            $table->text('observaciones')
                  ->nullable()
                  ->comment('Observaciones o notas adicionales sobre el pedido');

            /**
             * Clave foránea hacia tabla clientes
             * Garantiza que cada pedido pertenece a un cliente válido
             */
            $table->foreign('id_cliente')
                  ->references('id_cliente')
                  ->on('clientes')
                  ->comment('Vinculo referencial con la tabla de clientes');
        });

         // ==================== RELACIÓN MUCHOS A MUCHOS ====================
        
        /**
         * Tabla estudiantes - Entidad para relación muchos-a-muchos
         * 
         * Almacena información básica de estudiantes del sistema académico.
         * Participa en relación N:N con cursos mediante tabla intermedia.
         */
         Schema::create('estudiantes', function (Blueprint $table) {
            /**
             * Identificador único del estudiante
             * Tipo: INTEGER
             * Primary: Sí (clave primaria personalizada)
             */
            $table->integer('id_estudiante')
                  ->primary()
                  ->comment('Identificador único del estudiante');
            
            /**
             * Nombre del estudiante
             * Tipo: VARCHAR(50)
             * Nullable: NO
             */
            $table->string('nombre', 50)
                  ->comment('Nombre del estudiante');
            
            /**
             * Apellido del estudiante
             * Tipo: VARCHAR(50)
             * Nullable: NO
             */
            $table->string('apellido', 50)
                  ->comment('Apellido del estudiante');
        });
         /**
         * Tabla cursos - Entidad para relación muchos-a-muchos
         * 
         * Almacena información de cursos disponibles.
         * Participa en relación N:N con estudiantes mediante tabla intermedia.
         */
        Schema::create('cursos', function (Blueprint $table) {
            /**
             * Identificador único del curso
             * Tipo: INTEGER
             * Primary: Sí (clave primaria personalizada)
             */
            $table->integer('id_curso')
                  ->primary()
                  ->comment('Identificador único del curso');
            
            /**
             * Nombre del curso académico
             * Tipo: VARCHAR(50)
             * Nullable: NO
             */
            $table->string('nombre', 50)
                  ->comment('Nombre del curso académico');
        });

        /**
         * Tabla intermedia estudiante_curso - Implementación relación muchos-a-muchos
         * 
         * Permite la relación muchos-a-muchos entre estudiantes y cursos.
         * Un estudiante puede inscribirse en muchos cursos y un curso puede tener muchos estudiantes.
         */
        Schema::create('estudiante_curso', function (Blueprint $table) {
            /**
             * ID del estudiante
             * Tipo: INTEGER
             * Foreign: Sí (referencia a estudiantes.id_estudiante)
             */
            $table->integer('id_estudiante')
                  ->comment('Referencia al estudiante inscrito');
            
            /**
             * ID del curso
             * Tipo: INTEGER
             * Foreign: Sí (referencia a cursos.id_curso)
             */
            $table->integer('id_curso')
                  ->comment('Referencia al curso en el que se inscribe');
            
            /**
             * Clave primaria compuesta
             * Garantiza combinaciones únicas de estudiante-curso
             */
            $table->primary(['id_estudiante', 'id_curso'])
                  ->comment('Clave primaria compuesta que garantiza inscripciones únicas');
            
            // ==================== CLAVES FORÁNEAS ====================
            
            $table->foreign('id_estudiante')
                  ->references('id_estudiante')
                  ->on('estudiantes')
                  ->comment('Vinculo referencial con la tabla de estudiantes');
                  
            $table->foreign('id_curso')
                  ->references('id_curso')
                  ->on('cursos')
                  ->comment('Vinculo referencial con la tabla de cursos');
        });

        // ==================== COMENTARIOS DE TABLAS ====================
        
        /**
         * Comentarios para documentación en base de datos
         */
        DB::statement("ALTER TABLE personas COMMENT = 'Tabla maestra de personas del sistema. Almacena información básica de personas para relaciones uno-a-uno con documentos como pasaportes.'");
        DB::statement("ALTER TABLE pasaportes COMMENT = 'Tabla de documentos de pasaporte. Relación uno-a-uno con personas donde cada persona puede tener un único pasaporte asociado.'");
        DB::statement("ALTER TABLE clientes COMMENT = 'Tabla de clientes del sistema. Entidad principal para gestión comercial y relación uno-a-muchos con pedidos.'");
        DB::statement("ALTER TABLE pedidos COMMENT = 'Tabla de pedidos realizados por clientes. Relación uno-a-muchos donde un cliente puede tener múltiples pedidos asociados.'");
        DB::statement("ALTER TABLE estudiantes COMMENT = 'Tabla de estudiantes del sistema académico. Participa en relación muchos-a-muchos con cursos mediante tabla intermedia.'");
        DB::statement("ALTER TABLE cursos COMMENT = 'Tabla de cursos académicos disponibles. Participa en relación muchos-a-muchos con estudiantes mediante tabla intermedia.'");
        DB::statement("ALTER TABLE estudiante_curso COMMENT = 'Tabla intermedia para relación muchos-a-muchos entre estudiantes y cursos. Registra las inscripciones de estudiantes en cursos académicos.'");
    }

    /**
     * Revertir la migración
     * 
     * Elimina completamente todas las tablas del sistema en orden inverso
     * para respetar las dependencias de claves foráneas.
     * 
     * @return void
     * 
     * @warning Esta operación elimina permanentemente todos los datos del sistema
     * @danger No ejecutar en producción sin backup previo
     * 
     * @example
     * php artisan migrate:rollback --step=1
     */
    public function down(): void
    {
        /**
         * Eliminación en orden inverso a la creación
         * Primero tablas con dependencias, luego tablas independientes
         */
        Schema::dropIfExists('estudiante_curso');
        Schema::dropIfExists('cursos');
        Schema::dropIfExists('estudiantes');
        Schema::dropIfExists('pedidos');
        Schema::dropIfExists('clientes');
        Schema::dropIfExists('pasaportes');
        Schema::dropIfExists('personas');
        
        /**
         * Log informativo en entornos de desarrollo
         */
        if (app()->environment('local', 'testing')) {
            info('Migración de tablas del sistema revertida exitosamente');
        }
    }
};
