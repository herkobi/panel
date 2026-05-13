import { Form, Head } from '@inertiajs/react';
import { useState } from 'react';
import UsersController from '@/actions/App/Http/Controllers/Panel/Settings/User/UsersController';
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
import { create } from '@/routes/panel/settings/users';
import type { UserStatus } from '@/types';

type StatusOption = {
    value: UserStatus;
    label: string;
};

type RoleOption = {
    name: string;
};

type Props = {
    statuses: StatusOption[];
    roles: RoleOption[];
};

export default function Create({ statuses, roles }: Props) {
    const [status, setStatus] = useState<UserStatus>('active');
    const [emailVerified, setEmailVerified] = useState<boolean>(true);
    const [role, setRole] = useState<string>(roles[0]?.name ?? '');

    return (
        <>
            <Head title="Kullanıcı Ekle" />

            <div className="flex max-w-2xl flex-col gap-6">
                <div className="flex flex-col gap-1">
                    <h2 className="text-lg font-semibold">Kullanıcı Ekle</h2>
                    <p className="text-sm text-muted-foreground">
                        Panel erişimi olan yeni bir yönetici hesabı oluşturun.
                    </p>
                </div>

                <Form
                    {...UsersController.store.form()}
                    resetOnSuccess
                    className="flex flex-col gap-6"
                >
                    {({ errors, processing }) => (
                        <>
                            <input type="hidden" name="status" value={status} />
                            <input type="hidden" name="role" value={role} />
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
                                    placeholder="kullanici@ornek.com"
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

                            <div className="grid gap-2">
                                <Label>Rol</Label>
                                {roles.length === 0 ? (
                                    <p className="text-sm text-muted-foreground">
                                        Atayabileceğiniz bir rol bulunmuyor.
                                    </p>
                                ) : (
                                    <Select
                                        value={role}
                                        onValueChange={setRole}
                                    >
                                        <SelectTrigger className="w-full">
                                            <SelectValue placeholder="Rol seçin" />
                                        </SelectTrigger>
                                        <SelectContent>
                                            <SelectGroup>
                                                {roles.map((option) => (
                                                    <SelectItem
                                                        key={option.name}
                                                        value={option.name}
                                                    >
                                                        {option.name}
                                                    </SelectItem>
                                                ))}
                                            </SelectGroup>
                                        </SelectContent>
                                    </Select>
                                )}
                                <InputError message={errors.role} />
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
                                        Seçiliyse kullanıcı e-posta adresi
                                        onaylanmış olarak oluşturulur. Seçili
                                        değilse hoş geldin bağlantısı önce
                                        e-postayı onaylar, sonra şifre belirleme
                                        ekranına yönlendirir.
                                    </p>
                                </div>
                            </div>

                            <div className="flex justify-end">
                                <Button
                                    type="submit"
                                    disabled={processing || roles.length === 0}
                                >
                                    {processing && <Spinner />}
                                    Kullanıcı oluştur
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
            title: 'Kullanıcı Ekle',
            href: create(),
        },
    ],
};
