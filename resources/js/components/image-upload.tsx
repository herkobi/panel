import { ImageIcon, Trash2, UploadCloud } from 'lucide-react';
import { useEffect, useRef, useState } from 'react';
import type { ChangeEvent } from 'react';

import InputError from '@/components/input-error';
import { Button } from '@/components/ui/button';
import { Field, FieldDescription, FieldLabel } from '@/components/ui/field';

type Props = {
    title: string;
    description?: string;
    /** Currently stored image URL (server source of truth). */
    currentUrl?: string | null;
    /** Varsayılan görsel: özel bir görsel yokken önizlemede gösterilir. */
    fallbackUrl?: string | null;
    accept?: string;
    previewClassName?: string;
    /** Disables the actions while a request is in flight. */
    processing?: boolean;
    error?: string;
    /** Fired immediately when a file is picked (parent performs the upload). */
    onUpload: (file: File) => void;
    /** Fired immediately when the delete button is pressed. */
    onRemove: () => void;
};

/**
 * Reusable single-image field: square preview + "Değiştir" / "Sil" actions.
 * Both actions are immediate — the parent wires them to its own endpoints.
 */
export default function ImageUpload({
    title,
    description,
    currentUrl,
    fallbackUrl,
    accept = '.jpg,.jpeg,.png,image/jpeg,image/png',
    previewClassName = 'object-contain',
    processing = false,
    error,
    onUpload,
    onRemove,
}: Props) {
    const inputRef = useRef<HTMLInputElement>(null);
    const [objectUrl, setObjectUrl] = useState<string | null>(null);
    // Gerçek (özel) görsel: optimistik blob veya kayıtlı URL.
    const customUrl = objectUrl ?? currentUrl ?? null;
    // Önizleme: özel görsel yoksa varsayılana düşer.
    const previewUrl = customUrl ?? fallbackUrl ?? null;

    // Revoke the optimistic blob URL on unmount to avoid leaks.
    useEffect(() => {
        return () => {
            if (objectUrl) {
                URL.revokeObjectURL(objectUrl);
            }
        };
    }, [objectUrl]);

    function handleChange(event: ChangeEvent<HTMLInputElement>) {
        const file = event.target.files?.[0] ?? null;
        event.target.value = '';

        if (!file) {
            return;
        }

        setObjectUrl((prev) => {
            if (prev) {
                URL.revokeObjectURL(prev);
            }

            return URL.createObjectURL(file);
        });

        onUpload(file);
    }

    function handleRemove() {
        setObjectUrl((prev) => {
            if (prev) {
                URL.revokeObjectURL(prev);
            }

            return null;
        });

        onRemove();
    }

    return (
        <Field data-invalid={Boolean(error)} className="gap-3">
            <div className="flex min-w-0 flex-col gap-4 rounded-md border border-dashed p-4 sm:flex-row sm:items-center">
                <div className="flex size-24 shrink-0 items-center justify-center overflow-hidden rounded-md border bg-muted sm:size-28">
                    {previewUrl ? (
                        <img
                            src={previewUrl}
                            alt={title}
                            className={`size-full ${previewClassName}`}
                        />
                    ) : (
                        <ImageIcon className="text-muted-foreground" />
                    )}
                </div>

                <div className="flex min-w-0 flex-1 flex-col gap-3">
                    <div className="min-w-0">
                        <FieldLabel>{title}</FieldLabel>
                        {description ? (
                            <FieldDescription>{description}</FieldDescription>
                        ) : null}
                    </div>

                    <div className="flex flex-wrap items-center gap-2">
                        <Button
                            type="button"
                            variant="outline"
                            size="sm"
                            disabled={processing}
                            onClick={() => inputRef.current?.click()}
                        >
                            <UploadCloud data-icon="inline-start" />
                            Değiştir
                        </Button>
                        {customUrl ? (
                            <Button
                                type="button"
                                variant="outline"
                                size="sm"
                                disabled={processing}
                                onClick={handleRemove}
                            >
                                <Trash2 data-icon="inline-start" />
                                Sil
                            </Button>
                        ) : null}
                        <input
                            ref={inputRef}
                            type="file"
                            accept={accept}
                            className="sr-only"
                            onChange={handleChange}
                        />
                    </div>

                    <InputError message={error} />
                </div>
            </div>
        </Field>
    );
}
