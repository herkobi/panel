import { Head, router } from '@inertiajs/react';
import {
    AlertTriangle,
    CalendarDays,
    Database,
    Eye,
    FileCode2,
    Route,
    Settings,
    Trash2,
} from 'lucide-react';
import { useState } from 'react';
import {
    AlertDialog,
    AlertDialogAction,
    AlertDialogCancel,
    AlertDialogContent,
    AlertDialogDescription,
    AlertDialogFooter,
    AlertDialogHeader,
    AlertDialogTitle,
} from '@/components/ui/alert-dialog';
import { Button } from '@/components/ui/button';
import { dashboard } from '@/routes';
import { clear } from '@/routes/panel/tools/cache';

const cacheTypes = [
    {
        id: 'application',
        title: 'Uygulama Önbelleği',
        description: 'Uygulama düzeyinde önbelleğe alınmış verileri temizler.',
        icon: Database,
        iconColor: 'text-blue-500',
    },
    {
        id: 'config',
        title: 'Yapılandırma Önbelleği',
        description: 'Yapılandırma dosyalarının önbelleğini temizler.',
        icon: Settings,
        iconColor: 'text-amber-500',
    },
    {
        id: 'route',
        title: 'Rota Önbelleği',
        description: 'Derlenmiş rota tanımlarının önbelleğini temizler.',
        icon: Route,
        iconColor: 'text-emerald-500',
    },
    {
        id: 'view',
        title: 'Görünüm Önbelleği',
        description: 'Derlenmiş Blade görünümlerinin önbelleğini temizler.',
        icon: Eye,
        iconColor: 'text-purple-500',
    },
    {
        id: 'event',
        title: 'Olay Önbelleği',
        description: 'Olay ve dinleyici önbelleğini temizler.',
        icon: CalendarDays,
        iconColor: 'text-rose-500',
    },
    {
        id: 'compiled',
        title: 'Derlenmiş Önbellek',
        description: 'Derlenmiş sınıf dosyalarının önbelleğini temizler.',
        icon: FileCode2,
        iconColor: 'text-slate-500',
    },
];

export default function Cache() {
    const [open, setOpen] = useState(false);
    const [selectedType, setSelectedType] = useState<string | null>(null);

    const selected = cacheTypes.find((t) => t.id === selectedType);
    const selectedTitle =
        selectedType === 'all' ? 'Tüm Önbellekler' : selected?.title;

    const handleOpen = (type: string) => {
        setSelectedType(type);
        setOpen(true);
    };

    const handleConfirm = () => {
        if (!selectedType) {
            return;
        }

        router.post(clear({ type: selectedType }).url);
        setOpen(false);
        setSelectedType(null);
    };

    return (
        <>
            <Head title="Önbellek Yönetimi" />

            <div className="flex h-full flex-1 flex-col gap-6 overflow-x-auto rounded-xl">
                <div className="relative overflow-hidden rounded-xl border border-destructive/20 bg-gradient-to-r from-destructive/5 to-destructive/10 p-6">
                    <div className="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                        <div className="flex items-center gap-4">
                            <div className="flex size-12 shrink-0 items-center justify-center rounded-xl bg-destructive/15">
                                <Trash2 className="size-6 text-destructive" />
                            </div>
                            <div>
                                <h3 className="text-lg font-semibold">
                                    Tüm Önbellekleri Temizle
                                </h3>
                                <p className="text-sm text-muted-foreground">
                                    Uygulama, yapılandırma, rota, görünüm, olay
                                    ve derlenmiş önbellekleri tek seferde
                                    temizler.
                                </p>
                            </div>
                        </div>
                        <Button
                            variant="destructive"
                            className="w-full sm:w-auto"
                            onClick={() => handleOpen('all')}
                        >
                            <Trash2 className="size-4" />
                            Tümünü Temizle
                        </Button>
                    </div>
                </div>

                <div className="grid auto-rows-min gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    {cacheTypes.map((type) => {
                        const Icon = type.icon;

                        return (
                            <div
                                key={type.id}
                                className="group relative flex flex-col gap-5 overflow-hidden rounded-xl border p-6 transition-all hover:border-primary/30 hover:shadow-md"
                            >
                                <div className="flex items-start justify-between">
                                    <div className="flex size-12 shrink-0 items-center justify-center rounded-xl bg-muted">
                                        <Icon
                                            className={`size-6 ${type.iconColor}`}
                                        />
                                    </div>
                                </div>
                                <div className="flex flex-col gap-1">
                                    <h3 className="text-base font-semibold">
                                        {type.title}
                                    </h3>
                                    <p className="text-sm text-muted-foreground">
                                        {type.description}
                                    </p>
                                </div>
                                <div className="mt-auto pt-2">
                                    <Button
                                        variant="outline"
                                        size="sm"
                                        className="w-full"
                                        onClick={() => handleOpen(type.id)}
                                    >
                                        <Trash2 className="size-4" />
                                        Temizle
                                    </Button>
                                </div>
                            </div>
                        );
                    })}
                </div>
            </div>

            <AlertDialog open={open} onOpenChange={setOpen}>
                <AlertDialogContent>
                    <AlertDialogHeader>
                        <div className="flex items-center gap-3">
                            <div className="flex size-10 shrink-0 items-center justify-center rounded-full bg-destructive/10">
                                <AlertTriangle className="size-5 text-destructive" />
                            </div>
                            <AlertDialogTitle>
                                Önbellek Temizleme Onayı
                            </AlertDialogTitle>
                        </div>
                        <AlertDialogDescription>
                            <strong>{selectedTitle}</strong> önbelleğini
                            temizlemek istediğinize emin misiniz? Bu işlem geri
                            alınamaz.
                        </AlertDialogDescription>
                    </AlertDialogHeader>
                    <AlertDialogFooter>
                        <AlertDialogCancel>İptal</AlertDialogCancel>
                        <AlertDialogAction
                            variant="destructive"
                            onClick={handleConfirm}
                        >
                            Evet, Temizle
                        </AlertDialogAction>
                    </AlertDialogFooter>
                </AlertDialogContent>
            </AlertDialog>
        </>
    );
}

Cache.layout = {
    breadcrumbs: [
        {
            title: 'Önbellek Yönetimi',
            href: dashboard(),
        },
    ],
};
