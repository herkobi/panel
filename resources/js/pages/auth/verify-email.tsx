// Components
import { Form, Head } from '@inertiajs/react';
import { Send } from 'lucide-react';
import TextLink from '@/components/text-link';
import { Button } from '@/components/ui/button';
import { Spinner } from '@/components/ui/spinner';
import { logout } from '@/routes';
import { send } from '@/routes/verification';

export default function VerifyEmail({ status }: { status?: string }) {
    return (
        <>
            <Head title="E-posta doğrulama" />

            {status === 'verification-link-sent' && (
                <div className="mb-4 text-center text-sm font-medium text-green-600">
                    Kayıt sırasında verdiğiniz e-posta adresine yeni bir
                    doğrulama bağlantısı gönderildi.
                </div>
            )}

            <Form {...send.form()} className="space-y-6 text-center">
                {({ processing }) => (
                    <>
                        <Button disabled={processing} variant="secondary">
                            {processing ? <Spinner /> : <Send />}
                            Doğrulama e-postasını yeniden gönder
                        </Button>

                        <TextLink
                            href={logout()}
                            className="mx-auto block text-sm"
                        >
                            Çıkış yap
                        </TextLink>
                    </>
                )}
            </Form>
        </>
    );
}

VerifyEmail.layout = {
    title: 'E-posta doğrulama',
    description:
        'Size gönderdiğimiz bağlantıya tıklayarak e-posta adresinizi doğrulayın.',
};
