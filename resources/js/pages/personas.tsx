import { PlaceholderPattern } from '@/components/ui/placeholder-pattern';
import AppLayout from '@/layouts/app-layout';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/react';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
];

type Persona = {
    id_persona: number;
    nombre: string;
    apellido_paterno: string;
    apellido_materno: string;
};

type Props = {
    personas: Persona[];
};

export default function Dashboard({ personas }: Props) {
    
    return (
        <>
            <Head title="Personas" />
            <h1 className="text-2xl font-bold mb-4">Personas</h1>
            <div className="overflow-x-auto">
                <table className="min-w-full border border-gray-200">
                    <thead>
                        <tr className="bg-gray-100">
                            <th className="px-4 py-2 border">ID</th>
                            <th className="px-4 py-2 border">Nombre</th>
                            <th className="px-4 py-2 border">Apellido Paterno</th>
                            <th className="px-4 py-2 border">Apellido Materno</th>
                        </tr>
                    </thead>
                    <tbody>
                        {Array.isArray(personas) && personas.length > 0 ? (
                            personas.map((p) => (
                                <tr key={p.id_persona}>
                                    <td className="px-4 py-2 border">{p.id_persona}</td>
                                    <td className="px-4 py-2 border">{p.nombre}</td>
                                    <td className="px-4 py-2 border">{p.apellido_paterno}</td>
                                    <td className="px-4 py-2 border">{p.apellido_materno}</td>
                                </tr>
                            ))
                        ) : (
                            <tr>
                                <td colSpan={4} className="text-center py-4 text-gray-500">
                                    No hay personas disponibles
                                </td>
                            </tr>
                        )}
                    </tbody>
                </table>
            </div>
        </>
    );
}




