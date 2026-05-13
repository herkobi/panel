import { Head, Link } from '@inertiajs/react';
import { Building2, ShieldCheck, User } from 'lucide-react';
import Heading from '@/components/heading';
import { Button } from '@/components/ui/button';
import { account, dashboard } from '@/routes/app';
import { edit, security } from '@/routes/app/profile';

const shortcuts = [
    {
        title: 'Hesap Bilgileri',
        description: 'Firma ve adres bilgilerinizi güncelleyin.',
        href: account(),
        icon: Building2,
    },
    {
        title: 'Profil',
        description: 'Kişisel bilgilerinizi düzenleyin.',
        href: edit(),
        icon: User,
    },
    {
        title: 'Güvenlik',
        description: 'Şifre ve iki aşamalı doğrulama ayarlarınızı yönetin.',
        href: security(),
        icon: ShieldCheck,
    },
];

export default function Dashboard() {
    return (
        <>
            <Head title="Başlangıç" />

            <div className="space-y-6 p-4">
                <Heading
                    title="Başlangıç"
                    description="Hesabınızla ilgili temel işlemlere hızlı erişim."
                />

                <div className="grid gap-4 md:grid-cols-3">
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
            title: 'Başlangıç',
            href: dashboard(),
        },
    ],
};
