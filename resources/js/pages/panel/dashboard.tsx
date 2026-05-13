import { Head, Link } from '@inertiajs/react';
import { Activity, Database, Settings, Users } from 'lucide-react';
import Heading from '@/components/heading';
import { Button } from '@/components/ui/button';
import { dashboard } from '@/routes/panel';
import { edit as generalSettings } from '@/routes/panel/settings/general';
import { index as usersIndex } from '@/routes/panel/settings/users';
import { activity, cache } from '@/routes/panel/tools';

const shortcuts = [
    {
        title: 'Kullanıcılar',
        description: 'Panel kullanıcılarını görüntüleyin.',
        href: usersIndex(),
        icon: Users,
    },
    {
        title: 'Genel Ayarlar',
        description: 'Uygulama temel ayarlarını düzenleyin.',
        href: generalSettings(),
        icon: Settings,
    },
    {
        title: 'Aktivite Kayıtları',
        description: 'Sistem hareketlerini inceleyin.',
        href: activity(),
        icon: Activity,
    },
    {
        title: 'Cache Yönetimi',
        description: 'Uygulama önbellek işlemlerini yönetin.',
        href: cache(),
        icon: Database,
    },
];

export default function Dashboard() {
    return (
        <>
            <Head title="Panel" />

            <div className="space-y-6 p-4">
                <Heading
                    title="Panel"
                    description="Sık kullanılan yönetim alanlarına hızlı erişim."
                />

                <div className="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                    {shortcuts.map((item) => (
                        <div
                            key={item.title}
                            className="flex min-h-40 flex-col justify-between rounded-lg border p-4"
                        >
                            <div className="space-y-3">
                                <item.icon className="size-5 text-muted-foreground" />
                                <div>
                                    <h2 className="font-medium">
                                        {item.title}
                                    </h2>
                                    <p className="mt-1 text-sm text-muted-foreground">
                                        {item.description}
                                    </p>
                                </div>
                            </div>

                            <Button asChild variant="secondary">
                                <Link href={item.href}>Aç</Link>
                            </Button>
                        </div>
                    ))}
                </div>
            </div>
        </>
    );
}

Dashboard.layout = {
    breadcrumbs: [
        {
            title: 'Panel',
            href: dashboard(),
        },
    ],
};
