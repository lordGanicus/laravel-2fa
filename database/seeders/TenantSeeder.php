<?php
// database/seeders/TenantSeeder.php

namespace Database\Seeders;

use App\Models\Tenant;
use App\Models\User;
use App\Models\Post;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class TenantSeeder extends Seeder
{
    public function run(): void
    {
        // Limpiar primero
        DB::table('posts')->delete();
        DB::table('users')->delete();
        DB::table('tenants')->delete();

        // Tenant 1 - Empresa A
        $tenant1 = Tenant::create([
            'name' => 'Empresa A',
            'domain' => 'empresa-a.test',
            // QUITAR 'database' => 'tenant_1',
            'is_active' => true,
        ]);

        $user1 = User::create([
            'name' => 'Usuario Empresa A',
            'email' => 'usuario@empresa-a.test',
            'password' => Hash::make('password'),
            'tenant_id' => $tenant1->id,
        ]);

        Post::create([
            'title' => 'Primer post Empresa A',
            'content' => 'Este es el contenido del primer post de la Empresa A. Solo visible para tenant 1.',
            'user_id' => $user1->id,
            'tenant_id' => $tenant1->id,
        ]);

        // Tenant 2 - Empresa B  
        $tenant2 = Tenant::create([
            'name' => 'Empresa B',
            'domain' => 'empresa-b.test',
            // QUITAR 'database' => 'tenant_2',
            'is_active' => true,
        ]);

        $user2 = User::create([
            'name' => 'Usuario Empresa B',
            'email' => 'usuario@empresa-b.test',
            'password' => Hash::make('password'),
            'tenant_id' => $tenant2->id,
        ]);

        Post::create([
            'title' => 'Primer post Empresa B',
            'content' => 'Este es el contenido del primer post de la Empresa B. Solo visible para tenant 2.',
            'user_id' => $user2->id,
            'tenant_id' => $tenant2->id,
        ]);

        $this->command->info(' Tenants creados exitosamente!');
    }
}