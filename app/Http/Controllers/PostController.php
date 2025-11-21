<?php
// app/Http/Controllers/PostController.php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tenant;
use Inertia\Inertia;
use Illuminate\Support\Facades\Log;

class PostController extends Controller
{
    public function index()
    {
        // DEBUG: Ver qué está pasando
        $currentTenant = Tenant::current();
        $host = request()->getHost();
        
        //  FORZAR DETECCIÓN MANUAL
        if (!$currentTenant) {
            $currentTenant = Tenant::where('domain', $host)->first();
            if ($currentTenant) {
                $currentTenant->makeCurrent();
            }
        }
        
        //  FORZAR FILTRADO MANUAL
        if ($currentTenant) {
            $posts = Post::where('tenant_id', $currentTenant->id)
                        ->with(['user', 'tenant'])
                        ->latest()
                        ->get();
        } else {
            // Si no hay tenant, mostrar todos (solo para debug)
            $posts = Post::with(['user', 'tenant'])->latest()->get();
        }

        return Inertia::render('posts/index', [
            'posts' => $posts,
            'currentTenant' => $currentTenant
        ]);
    }
}