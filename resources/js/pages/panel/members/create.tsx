import { Form, Head } from '@inertiajs/react';
import { UserPlus } from 'lucide-react';
import { useState } from 'react';
import MembersController from '@/actions/App/Http/Controllers/Panel/Members/MembersController';
import InputError from '@/components/input-error';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import {
    Select,
    SelectContent,
    SelectGroup,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';
import { Spinner } from '@/components/ui/spinner';
import { create } from '@/routes/panel/members';
import type { UserStatus } from '@/types';

type StatusOption = {
    value: UserStatus;
    label: string;
};

type Props = {
    statuses: StatusOption[];
};

export default function Create({ statuses }: Props) {
    const [status, setStatus] = useState<UserStatus>('active');
    const [emailVerified, setEmailVerified] = useState<boolean>(true);

    return (
        <>
            <Head title="Üye Ekle" />

            <div className="flex max-w-2xl flex-col gap-6">
                <div className="flex flex-col gap-1">
                    <h2 className="text-lg font-semibold">Üye Ekle</h2>
                    <p className="text-sm text-muted-foreground">
                        Yeni bir üye hesabı oluşturun. Kullanıcıya şifresini
                        belirlemesi için bir hoş geldin bağlantısı gönderilecek.
                    </p>
                </div>

                <Form
                    {...MembersController.store.form()}
                    resetOnSuccess
                    className="flex flex-col gap-6"
                >
                    {({ errors, processing }) => (
                        <>
                            <input type="hidden" name="status" value={status} />
                            <input
                                type="hidden"
                                name="email_verified"
                                value={emailVerified ? '1' : '0'}
                            />

                            <div className="grid gap-2">
                                <Label htmlFor="name">Ad soyad</Label>
                                <Input
                                    id="name"
                                    name="name"
                                    required
                                    autoComplete="name"
                                    placeholder="Ad soyad"
                                    aria-invalid={Boolean(errors.name)}
                                />
                                <InputError message={errors.name} />
                            </div>

                            <div className="grid gap-2">
                                <Label htmlFor="email">E-posta adresi</Label>
                                <Input
                                    id="email"
                                    type="email"
                                    name="email"
                                    required
                                    autoComplete="email"
                                    placeholder="uye@ornek.com"
                                    aria-invalid={Boolean(errors.email)}
                                />
                                <InputError message={errors.email} />
                            </div>

                            <div className="grid gap-2">
                                <Label>Durum</Label>
                                <Select
                                    value={status}
                                    onValueChange={(value) =>
                                        setStatus(value as UserStatus)
                                    }
                                >
                                    <SelectTrigger className="w-full">
                                        <SelectValue />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectGroup>
                                            {statuses.map((option) => (
                                                <SelectItem
                                                    key={option.value}
                                                    value={option.value}
                                                >
                                                    {option.label}
                                                </SelectItem>
                                            ))}
                                        </SelectGroup>
                                    </SelectContent>
                                </Select>
                                <InputError message={errors.status} />
                            </div>

                            <div className="flex items-start gap-3 rounded-lg border p-4">
                                <Checkbox
                                    id="email_verified"
                                    checked={emailVerified}
                                    onCheckedChange={(checked) =>
                                        setEmailVerified(checked === true)
                                    }
                                />
                                <div className="grid gap-1.5">
                                    <Label htmlFor="email_verified">
                                        E-posta adresini onayla
                                    </Label>
                                    <p className="text-sm text-muted-foreground">
                                        Seçiliyse üye e-posta adresi onaylanmış
                                        olarak oluşturulur. Seçili değilse hoş
                                        geldin bağlantısı önce e-postayı
                                        onaylar, sonra şifre belirleme ekranına
                                        yönlendirir.
                                    </p>
                                </div>
                            </div>

                            <div className="flex justify-end">
                                <Button type="submit" disabled={processing}>
                                    {processing ? <Spinner /> : <UserPlus />}
                                    Üye oluştur
                                </Button>
                            </div>
                        </>
                    )}
                </Form>
            </div>
        </>
    );
}

Create.layout = {
    breadcrumbs: [
        {
            title: 'Üye Ekle',
            href: create(),
        },
    ],
};
