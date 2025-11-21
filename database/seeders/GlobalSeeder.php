<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GlobalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Personas
        DB::table('personas')->insert([
            ['id_persona' => 1, 'nombre' => 'Juan', 'apellido_paterno' => 'Pérez', 'apellido_materno' => 'Gómez'],
            ['id_persona' => 2, 'nombre' => 'Ana', 'apellido_paterno' => 'López', 'apellido_materno' => 'Martínez'],
            ['id_persona' => 3, 'nombre' => 'Luis', 'apellido_paterno' => 'Ramírez', 'apellido_materno' => 'Sánchez'],
            ['id_persona' => 4, 'nombre' => 'María', 'apellido_paterno' => 'Torres', 'apellido_materno' => 'Fernández'],
            ['id_persona' => 5, 'nombre' => 'Carlos', 'apellido_paterno' => 'García', 'apellido_materno' => 'Ruiz'],
        ]);

        // Pasaportes
        DB::table('pasaportes')->insert([
            ['id_pasaporte' => 101, 'numero' => 'A123456', 'id_persona' => 1],
            ['id_pasaporte' => 102, 'numero' => 'B234567', 'id_persona' => 2],
            ['id_pasaporte' => 103, 'numero' => 'C345678', 'id_persona' => 3],
            ['id_pasaporte' => 104, 'numero' => 'D456789', 'id_persona' => 4],
            ['id_pasaporte' => 105, 'numero' => 'E567890', 'id_persona' => 5],
        ]);

        // Clientes
        DB::table('clientes')->insert([
            [
                'id_cliente' => 1,
                'nombre' => 'Pedro',
                'apellido' => 'Ramírez',
                'correo' => 'pedro.ramirez@email.com',
                'telefono' => '555-1234',
                'direccion' => 'Calle 1 #123',
                'ciudad' => 'Ciudad A',
                'pais' => 'País X',
                'fecha_registro' => '2024-01-10',
                'estado_cuenta' => 'activo',
                'tipo_cliente' => 'regular',
            ],
            [
                'id_cliente' => 2,
                'nombre' => 'Lucía',
                'apellido' => 'Gómez',
                'correo' => 'lucia.gomez@email.com',
                'telefono' => '555-5678',
                'direccion' => 'Avenida 2 #456',
                'ciudad' => 'Ciudad B',
                'pais' => 'País Y',
                'fecha_registro' => '2024-02-15',
                'estado_cuenta' => 'inactivo',
                'tipo_cliente' => 'premium',
            ],
            [
                'id_cliente' => 3,
                'nombre' => 'Sofía',
                'apellido' => 'Martínez',
                'correo' => 'sofia.martinez@email.com',
                'telefono' => '555-9999',
                'direccion' => 'Boulevard 3 #789',
                'ciudad' => 'Ciudad C',
                'pais' => 'País Z',
                'fecha_registro' => '2024-03-20',
                'estado_cuenta' => 'activo',
                'tipo_cliente' => 'vip',
            ],
        ]);

        // Pedidos
        DB::table('pedidos')->insert([
            [
                'id_pedido' => 1001,
                'fecha' => '2024-03-01',
                'id_cliente' => 1,
                'total' => 150.75,
                'metodo_pago' => 'tarjeta',
                'estado_pedido' => 'enviado',
                'direccion_envio' => 'Calle 1 #123',
                'ciudad_envio' => 'Ciudad A',
                'pais_envio' => 'País X',
                'fecha_envio' => '2024-03-02',
                'observaciones' => 'Entregar por la mañana',
            ],
            [
                'id_pedido' => 1002,
                'fecha' => '2024-03-05',
                'id_cliente' => 2,
                'total' => 320.00,
                'metodo_pago' => 'efectivo',
                'estado_pedido' => 'pendiente',
                'direccion_envio' => 'Avenida 2 #456',
                'ciudad_envio' => 'Ciudad B',
                'pais_envio' => 'País Y',
                'fecha_envio' => '2024-03-06',
                'observaciones' => null,
            ],
            [
                'id_pedido' => 1003,
                'fecha' => '2024-03-10',
                'id_cliente' => 3,
                'total' => 500.00,
                'metodo_pago' => 'transferencia',
                'estado_pedido' => 'en proceso',
                'direccion_envio' => 'Boulevard 3 #789',
                'ciudad_envio' => 'Ciudad C',
                'pais_envio' => 'País Z',
                'fecha_envio' => '2024-03-12',
                'observaciones' => 'Llamar antes de entregar',
            ],
            [
                'id_pedido' => 1004,
                'fecha' => '2024-03-12',
                'id_cliente' => 1,
                'total' => 75.50,
                'metodo_pago' => 'tarjeta',
                'estado_pedido' => 'entregado',
                'direccion_envio' => 'Calle 1 #123',
                'ciudad_envio' => 'Ciudad A',
                'pais_envio' => 'País X',
                'fecha_envio' => '2024-03-13',
                'observaciones' => null,
            ],
            [
                'id_pedido' => 1005,
                'fecha' => '2024-03-15',
                'id_cliente' => 2,
                'total' => 210.00,
                'metodo_pago' => 'efectivo',
                'estado_pedido' => 'enviado',
                'direccion_envio' => 'Avenida 2 #456',
                'ciudad_envio' => 'Ciudad B',
                'pais_envio' => 'País Y',
                'fecha_envio' => '2024-03-16',
                'observaciones' => 'Dejar en portería',
            ],
            [
                'id_pedido' => 1006,
                'fecha' => '2024-03-18',
                'id_cliente' => 3,
                'total' => 1200.00,
                'metodo_pago' => 'tarjeta',
                'estado_pedido' => 'pendiente',
                'direccion_envio' => 'Boulevard 3 #789',
                'ciudad_envio' => 'Ciudad C',
                'pais_envio' => 'País Z',
                'fecha_envio' => '2024-03-19',
                'observaciones' => null,
            ],
            [
                'id_pedido' => 1007,
                'fecha' => '2024-03-20',
                'id_cliente' => 1,
                'total' => 60.00,
                'metodo_pago' => 'efectivo',
                'estado_pedido' => 'en proceso',
                'direccion_envio' => 'Calle 1 #123',
                'ciudad_envio' => 'Ciudad A',
                'pais_envio' => 'País X',
                'fecha_envio' => '2024-03-21',
                'observaciones' => null,
            ],
            [
                'id_pedido' => 1008,
                'fecha' => '2024-03-22',
                'id_cliente' => 2,
                'total' => 450.00,
                'metodo_pago' => 'transferencia',
                'estado_pedido' => 'enviado',
                'direccion_envio' => 'Avenida 2 #456',
                'ciudad_envio' => 'Ciudad B',
                'pais_envio' => 'País Y',
                'fecha_envio' => '2024-03-23',
                'observaciones' => 'No llamar',
            ],
            [
                'id_pedido' => 1009,
                'fecha' => '2024-03-25',
                'id_cliente' => 3,
                'total' => 300.00,
                'metodo_pago' => 'tarjeta',
                'estado_pedido' => 'entregado',
                'direccion_envio' => 'Boulevard 3 #789',
                'ciudad_envio' => 'Ciudad C',
                'pais_envio' => 'País Z',
                'fecha_envio' => '2024-03-26',
                'observaciones' => null,
            ],
            [
                'id_pedido' => 1010,
                'fecha' => '2024-03-28',
                'id_cliente' => 1,
                'total' => 80.00,
                'metodo_pago' => 'efectivo',
                'estado_pedido' => 'pendiente',
                'direccion_envio' => 'Calle 1 #123',
                'ciudad_envio' => 'Ciudad A',
                'pais_envio' => 'País X',
                'fecha_envio' => '2024-03-29',
                'observaciones' => 'Entregar después de las 5pm',
            ],
            [
                'id_pedido' => 1011,
                'fecha' => '2024-03-30',
                'id_cliente' => 3,
                'total' => 950.00,
                'metodo_pago' => 'transferencia',
                'estado_pedido' => 'enviado',
                'direccion_envio' => 'Boulevard 3 #789',
                'ciudad_envio' => 'Ciudad C',
                'pais_envio' => 'País Z',
                'fecha_envio' => '2024-03-31',
                'observaciones' => 'Urgente',
            ],
            [
                'id_pedido' => 1012,
                'fecha' => '2024-04-01',
                'id_cliente' => 2,
                'total' => 110.00,
                'metodo_pago' => 'tarjeta',
                'estado_pedido' => 'en proceso',
                'direccion_envio' => 'Avenida 2 #456',
                'ciudad_envio' => 'Ciudad B',
                'pais_envio' => 'País Y',
                'fecha_envio' => '2024-04-02',
                'observaciones' => null,
            ],
        ]);

        // Estudiantes
        DB::table('estudiantes')->insert([
            ['id_estudiante' => 1, 'nombre' => 'Miguel', 'apellido' => 'Santos'],
            ['id_estudiante' => 2, 'nombre' => 'Laura', 'apellido' => 'Mendoza'],
            ['id_estudiante' => 3, 'nombre' => 'Andrés', 'apellido' => 'Vega'],
            ['id_estudiante' => 4, 'nombre' => 'Paula', 'apellido' => 'Castro'],
            ['id_estudiante' => 5, 'nombre' => 'Jorge', 'apellido' => 'Silva'],
            ['id_estudiante' => 6, 'nombre' => 'Valeria', 'apellido' => 'Ríos'],
            ['id_estudiante' => 7, 'nombre' => 'Ricardo', 'apellido' => 'Paredes'],
            ['id_estudiante' => 8, 'nombre' => 'Camila', 'apellido' => 'Morales'],
            ['id_estudiante' => 9, 'nombre' => 'Santiago', 'apellido' => 'Herrera'],
            ['id_estudiante' => 10, 'nombre' => 'Daniela', 'apellido' => 'Navarro'],
        ]);

        // Cursos
        DB::table('cursos')->insert([
            ['id_curso' => 1, 'nombre' => 'Matemáticas'],
            ['id_curso' => 2, 'nombre' => 'Historia'],
            ['id_curso' => 3, 'nombre' => 'Biología'],
            ['id_curso' => 4, 'nombre' => 'Física'],
            ['id_curso' => 5, 'nombre' => 'Química'],
            ['id_curso' => 6, 'nombre' => 'Literatura'],
            ['id_curso' => 7, 'nombre' => 'Arte'],
            ['id_curso' => 8, 'nombre' => 'Educación Física'],
            ['id_curso' => 9, 'nombre' => 'Informática'],
            ['id_curso' => 10, 'nombre' => 'Geografía'],
        ]);

        // Estudiante_Curso (relaciones)
        DB::table('estudiante_curso')->insert([
            ['id_estudiante' => 1, 'id_curso' => 1],
            ['id_estudiante' => 1, 'id_curso' => 2],
            ['id_estudiante' => 2, 'id_curso' => 3],
            ['id_estudiante' => 3, 'id_curso' => 1],
            ['id_estudiante' => 4, 'id_curso' => 4],
            ['id_estudiante' => 5, 'id_curso' => 5],
            ['id_estudiante' => 6, 'id_curso' => 6],
            ['id_estudiante' => 7, 'id_curso' => 7],
            ['id_estudiante' => 8, 'id_curso' => 8],
            ['id_estudiante' => 9, 'id_curso' => 9],
            // algunos estudiantes en más de un curso
            ['id_estudiante' => 2, 'id_curso' => 2],
            ['id_estudiante' => 3, 'id_curso' => 3],
            ['id_estudiante' => 10, 'id_curso' => 10],
            ['id_estudiante' => 10, 'id_curso' => 1],
        ]);
    }
}
