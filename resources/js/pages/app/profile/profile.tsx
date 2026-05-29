import { Form, Head, Link } from '@inertiajs/react';
import { Mail, Save, X } from 'lucide-react';
import { useState } from 'react';
import ProfileController from '@/actions/App/Http/Controllers/App/Profile/ProfileController';
import Heading from '@/components/heading';
import InputError from '@/components/input-error';
import { Button } from '@/components/ui/button';
import {
    Dialog,
    DialogClose,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
} from '@/components/ui/dialog';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import { useAppAuth } from '@/hooks/use-app-auth';
import { edit } from '@/routes/app/profile';
import { send } from '@/routes/verification';

export default function Profile({
    mustVerifyEmail,
    status,
}: {
    mustVerifyEmail: boolean;
    status?: string;
}) {
    const { user } = useAppAuth();
    const [emailDialogOpen, setEmailDialogOpen] = useState<boolean>(false);

    return (
        <>
            <Head title="Bilgilerim" />

            <h1 className="sr-only">Bilgilerim</h1>

            <div className="space-y-6">
                <Heading
                    variant="small"
                    title="Profil bilgileri"
                    description="Adınızı ve e-posta adresinizi güncelleyin"
                />

                <Form
                    {...ProfileController.update.form()}
                    options={{
                        preserveScroll: true,
                    }}
                    className="w-full max-w-md space-y-6"
                >
                    {({ processing, errors }) => (
                        <>
                            <div className="grid gap-2">
                                <Label htmlFor="name">Ad soyad</Label>

                                <Input
                                    id="name"
                                    className="mt-1 block w-full"
                                    defaultValue={user?.name}
                                    name="name"
                                    required
                                    autoComplete="name"
                                    placeholder="Ad soyad"
                                />

                                <InputError
                                    className="mt-2"
                                    message={errors.name}
                                />
                            </div>

                            <div className="grid gap-2">
                                <Label htmlFor="email">E-posta adresi</Label>

                                <Input
                                    id="email"
                                    type="email"
                                    className="mt-1 block w-full"
                                    value={user?.email ?? ''}
                                    autoComplete="username"
                                    placeholder="E-posta adresi"
                                    disabled
                                />

                                <div className="-mt-1">
                                    <Button
                                        type="button"
                                        variant="link"
                                        className="h-auto cursor-pointer px-0 py-0"
                                        onClick={() => setEmailDialogOpen(true)}
                                    >
                                        E-posta adresini değiştir
                                    </Button>
                                </div>
                            </div>

                            {mustVerifyEmail &&
                                user?.email_verified_at === null && (
                                    <div>
                                        <p className="-mt-4 text-sm text-muted-foreground">
                                            E-posta adresiniz doğrulanmamış.{' '}
                                            <Link
                                                href={send()}
                                                as="button"
                                                className="text-foreground underline decoration-neutral-300 underline-offset-4 transition-colors duration-300 ease-out hover:decoration-current! dark:decoration-neutral-500"
                                            >
                                                Doğrulama e-postasını yeniden
                                                göndermek için tıklayın.
                                            </Link>
                                        </p>

                                        {status ===
                                            'verification-link-sent' && (
                                            <div className="mt-2 text-sm font-medium text-green-600">
                                                E-posta adresinize yeni bir
                                                doğrulama bağlantısı gönderildi.
                                            </div>
                                        )}
                                    </div>
                                )}

                            <div className="flex items-center gap-4">
                                <Button
                                    disabled={processing}
                                    data-test="update-profile-button"
                                >
                                    <Save />
                                    Kaydet
                                </Button>
                            </div>
                        </>
                    )}
                </Form>

                <Dialog
                    open={emailDialogOpen}
                    onOpenChange={setEmailDialogOpen}
                >
                    <DialogContent>
                        <DialogHeader>
                            <DialogTitle>E-posta adresini değiştir</DialogTitle>
                            <DialogDescription>
                                E-posta adresinizi değiştirdiğinizde yeni
                                adresinizi tekrar doğrulamanız gerekir.
                                Güvenliğiniz için tüm cihazlardaki oturumlarınız
                                kapatılır.
                            </DialogDescription>
                        </DialogHeader>

                        <Form
                            {...ProfileController.updateEmail.form()}
                            className="space-y-6"
                        >
                            {({ errors, processing }) => (
                                <>
                                    <div className="grid gap-2">
                                        <Label htmlFor="new_email">
                                            Yeni e-posta adresi
                                        </Label>
                                        <Input
                                            id="new_email"
                                            type="email"
                                            name="email"
                                            required
                                            autoComplete="email"
                                            placeholder="yeni@ornek.com"
                                        />
                                        <InputError message={errors.email} />
                                    </div>

                                    <DialogFooter>
                                        <DialogClose asChild>
                                            <Button
                                                type="button"
                                                variant="outline"
                                                disabled={processing}
                                            >
                                                <X />
                                                Vazgeç
                                            </Button>
                                        </DialogClose>
                                        <Button
                                            type="submit"
                                            disabled={processing}
                                        >
                                            {processing ? <Spinner /> : <Mail />}
                                            E-postayı değiştir
                                        </Button>
                                    </DialogFooter>
                                </>
                            )}
                        </Form>
                    </DialogContent>
                </Dialog>
            </div>
        </>
    );
}

Profile.layout = {
    breadcrumbs: [
        {
            title: 'Bilgilerim',
            href: edit(),
        },
    ],
};
