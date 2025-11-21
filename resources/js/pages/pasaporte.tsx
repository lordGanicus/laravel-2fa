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

type Pasaporte = {
    id_pasaporte: number;
    numero: string;
    id_persona: number;
};

type Props = {
    pasaportes: Pasaporte[];
};

export default function PasaportePage({ pasaportes }: Props) {
    return (
        <>
            <Head title="Pasaportes" />
            <h1 className="text-2xl font-bold mb-4">Pasaportes</h1>
            <div className="overflow-x-auto">
                <table className="min-w-full border border-gray-200">
                    <thead>
                        <tr className="bg-gray-100">
                            <th className="px-4 py-2 border">ID Pasaporte</th>
                            <th className="px-4 py-2 border">Número</th>
                            <th className="px-4 py-2 border">ID Persona</th>
                        </tr>
                    </thead>
                    <tbody>
                        {Array.isArray(pasaportes) && pasaportes.length > 0 ? (
                            pasaportes.map((p) => (
                                <tr key={p.id_pasaporte}>
                                    <td className="px-4 py-2 border">{p.id_pasaporte}</td>
                                    <td className="px-4 py-2 border">{p.numero}</td>
                                    <td className="px-4 py-2 border">{p.id_persona}</td>
                                </tr>
                            ))
                        ) : (
                            <tr>
                                <td colSpan={3} className="text-center py-4 text-gray-500">
                                    No hay pasaportes disponibles
                                </td>
                            </tr>
                        )}
                    </tbody>
                </table>
            </div>
        </>
    );
}




