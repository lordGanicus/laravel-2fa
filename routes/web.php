<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;
use App\Http\Controllers\PostController;

// TEMPORALMENTE
Route::get('/debug-tenant-deep', function () {
    $currentTenant = \App\Models\Tenant::current();
    $host = request()->getHost();
    
    // 1. Verificar detección de tenant
    $tenantByDomain = \App\Models\Tenant::where('domain', $host)->first();
    
    // 2. Verificar el query SQL que se ejecuta
    $query = \App\Models\Post::query()->toSql();
    $postsWithoutScope = \App\Models\Post::withoutGlobalScopes()->get();
    $postsWithScope = \App\Models\Post::get();
    
    // 3. Verificar traits del modelo Post
    $postTraits = class_uses(\App\Models\Post::class);
    
    // 4. Verificar configuración Spatie
    $config = config('multitenancy');
    
    return [
        'debug_info' => [
            'request_host' => $host,
            'current_tenant_from_spatie' => $currentTenant?->only(['id', 'name', 'domain']),
            'tenant_by_domain_manual' => $tenantByDomain?->only(['id', 'name', 'domain']),
            'are_tenants_equal' => $currentTenant && $tenantByDomain && $currentTenant->id === $tenantByDomain->id,
        ],
        
        'model_analysis' => [
            'post_model_class' => get_class(new \App\Models\Post()),
            'post_model_traits' => $postTraits,
            'has_tenant_connection_trait' => in_array('Spatie\Multitenancy\Models\Concerns\UsesTenantConnection', $postTraits),
        ],
        
        'query_analysis' => [
            'sql_query_generated' => $query,
            'posts_count_without_scope' => $postsWithoutScope->count(),
            'posts_count_with_scope' => $postsWithScope->count(),
            'posts_with_scope_tenant_ids' => $postsWithScope->pluck('tenant_id')->unique()->values(),
        ],
        
        'configuration_check' => [
            'tenant_finder' => $config['tenant_finder'] ?? 'NOT SET',
            'switch_tenant_tasks' => $config['switch_tenant_tasks'] ?? [],
            'tenant_model' => $config['tenant_model'] ?? 'NOT SET',
        ]
    ];
});

Route::get('/posts', [PostController::class, 'index'])->name('posts.index');

Route::get('/', function () {
    return Inertia::render('welcome', [
        'canRegister' => Features::enabled(Features::registration()),
    ]);
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');
});

//Crea una ruta para personas en tipo get
Route::get('/personas', [App\Http\Controllers\PersonaController::class, 'index']);

//crea una ruta para pasaportes en tipo get
Route::get('/pasaportes', [App\Http\Controllers\PasaporteController::class, 'index']);


//crear la ruta para cliente tipo get
Route::get('/clientes', [App\Http\Controllers\ClienteController::class, 'index']);
//crear la ruta para pedidos tipo get
Route::get('/pedidos', [App\Http\Controllers\PedidoController::class, 'index']);

//crear la ruta para los estudiantes tipo get
Route::get('/estudiantes', [App\Http\Controllers\EstudianteController::class, 'index']);

//crear la ruta apra los cursos tipo get
Route::get('/cursos', [App\Http\Controllers\CursoController::class, 'index']);


require __DIR__.'/settings.php';





