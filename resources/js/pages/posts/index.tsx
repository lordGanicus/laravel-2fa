// resources/js/Pages/Posts/Index.tsx
import React from 'react';
import { Head, usePage } from '@inertiajs/react';
import AppLayout from '@/layouts/app-layout';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
    {
        title: 'Posts',
        href: '/posts',
    },
];

export default function PostIndex() {
    const { props } = usePage();
    const { posts = [], currentTenant, auth = {} } = props as any;

    // MANEJO SEGURO de datos null/undefined
    const safeTenant = currentTenant || { 
        id: 0, 
        name: 'Tenant no detectado', 
        domain: 'unknown' 
    };
    
    const safeAuth = auth || { user: { name: 'No autenticado', email: '' } };
    const safePosts = posts || [];

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Posts" />
            
            <div className="flex flex-1 flex-col gap-6 p-6">
                {/* Información del Tenant */}
                <div className="bg-card rounded-lg border border-border p-6 shadow-sm">
                    <h1 className="text-2xl font-bold mb-4">
                         Posts de {safeTenant.name}
                    </h1>
                    <div className="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                        <div>
                            <span className="font-semibold">Dominio:</span> 
                            <span className="ml-2 text-blue-600">{safeTenant.domain}</span>
                        </div>
                        <div>
                            <span className="font-semibold">Tenant ID:</span> 
                            <span className="ml-2 text-green-600">{safeTenant.id}</span>
                        </div>
                        <div>
                            <span className="font-semibold">Total Posts:</span> 
                            <span className="ml-2 text-purple-600">{safePosts.length}</span>
                        </div>
                    </div>
                    
                    {!currentTenant && (
                        <div className="mt-4 p-3 bg-yellow-50 rounded border border-yellow-200 dark:bg-yellow-900/20">
                            <p className="text-yellow-800 dark:text-yellow-300 text-sm">
                                 <strong>Tenant no detectado automáticamente:</strong> Usando tenant por defecto
                            </p>
                        </div>
                    )}
                </div>

                {/* Lista de Posts */}
                <div className="grid gap-4">
                    {safePosts.length > 0 ? (
                        safePosts.map((post: any) => (
                            <div key={post.id} className="bg-card rounded-lg border border-border p-6 shadow-sm">
                                <h3 className="text-lg font-semibold text-foreground mb-3">
                                    {post.title}
                                </h3>
                                <p className="text-muted-foreground mb-4">{post.content}</p>
                                <div className="flex justify-between items-center text-sm text-muted-foreground border-t pt-3">
                                    <span> Autor: {post.user?.name || 'Desconocido'}</span>
                                    <span> Tenant ID: {post.tenant_id}</span>
                                </div>
                            </div>
                        ))
                    ) : (
                        <div className="bg-card rounded-lg border border-border p-8 text-center">
                            <p className="text-muted-foreground text-lg">
                                No hay posts para este tenant
                            </p>
                        </div>
                    )}
                </div>

                {/* Panel de Debug */}
                <div className="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-4 border border-blue-200 dark:border-blue-800">
                    <h3 className="font-semibold text-blue-800 dark:text-blue-300 mb-3">🔍 Información de Debug:</h3>
                    <div className="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm text-blue-700 dark:text-blue-400">
                        <div>
                            <strong>Tenant Actual:</strong> {safeTenant.name} (ID: {safeTenant.id})
                        </div>
                        <div>
                            <strong>URL Actual:</strong> {typeof window !== 'undefined' ? window.location.host : ''}
                        </div>
                        <div>
                            <strong>Usuario:</strong> {safeAuth.user?.name || 'No autenticado'}
                        </div>
                        <div>
                            <strong>Email:</strong> {safeAuth.user?.email || 'N/A'}
                        </div>
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}