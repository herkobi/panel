/**
 * ⚠️ HENÜZ HİÇBİR SAYFAYA BAĞLI DEĞİL — ileride lazım olsun diye hazır duruyor.
 *
 * Bağlamak için (örn. Account galerisi / Product görselleri):
 *   1. Sahibe-özel, oturuma kilitli route'lar aç (store / destroy / reorder).
 *      Client'tan morph type/id ALMA; sahibi server'da belirle (authz güvenliği).
 *   2. Backend zaten hazır: App\Services\Support\MediaService
 *      → attach($owner, $file, 'gallery', private: false)  // public görsel
 *      → detach($media)
 *      → reorder($owner, 'gallery', $orderedIds)
 *   3. Bu component'i şöyle besle:
 *      items     ← sahibin media'sı (id, url, name) — sıralı
 *      onUpload  → router.post(...)   (forceFormData)
 *      onRemove  → router.delete(...)
 *      onReorder → router.patch(...)  (MediaService.reorder)
 *
 * ImageUpload ile aynı felsefe: tamamen presentational, backend-agnostic.
 */
import { ImagePlus, Trash2 } from 'lucide-react';
import { useRef, useState } from 'react';
import type { ChangeEvent, DragEvent } from 'react';

import InputError from '@/components/input-error';
import { Button } from '@/components/ui/button';

export type MediaItem = {
    id: string;
    url: string | null;
    name?: string | null;
};

type Props = {
    /** Existing media (server source of truth, already ordered). */
    items: MediaItem[];
    accept?: string;
    /** Optional cap on total items; hides the add tile when reached. */
    max?: number;
    /** Disables actions while a request is in flight. */
    processing?: boolean;
    error?: string;
    /** Fired when files are picked (parent performs the upload). */
    onUpload: (files: File[]) => void;
    /** Fired when a tile's delete button is pressed (parent deletes it). */
    onRemove: (id: string) => void;
    /** Optional drag-reorder; receives the full id list in the new order. */
    onReorder?: (orderedIds: string[]) => void;
};

/**
 * Reusable multi-image gallery: grid of tiles (each immediately deletable),
 * an add tile (immediate multi-upload), and optional drag reordering.
 * Presentational — the parent wires every action to its own endpoints.
 */
export default function MediaGallery({
    items,
    accept = '.jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp',
    max,
    processing = false,
    error,
    onUpload,
    onRemove,
    onReorder,
}: Props) {
    const inputRef = useRef<HTMLInputElement>(null);
    const [draggingId, setDraggingId] = useState<string | null>(null);

    const canAdd = max === undefined || items.length < max;

    function handlePick(event: ChangeEvent<HTMLInputElement>) {
        const files = Array.from(event.target.files ?? []);
        event.target.value = '';

        if (files.length > 0) {
            onUpload(files);
        }
    }

    function handleDrop(targetId: string) {
        if (!onReorder || draggingId === null || draggingId === targetId) {
            setDraggingId(null);

            return;
        }

        const ids = items.map((item) => item.id);
        const from = ids.indexOf(draggingId);
        const to = ids.indexOf(targetId);

        if (from === -1 || to === -1) {
            setDraggingId(null);

            return;
        }

        ids.splice(from, 1);
        ids.splice(to, 0, draggingId);

        setDraggingId(null);
        onReorder(ids);
    }

    return (
        <div className="flex flex-col gap-3">
            <div className="grid grid-cols-3 gap-3 sm:grid-cols-4 md:grid-cols-6">
                {items.map((item) => (
                    <div
                        key={item.id}
                        draggable={Boolean(onReorder) && !processing}
                        onDragStart={() => setDraggingId(item.id)}
                        onDragEnd={() => setDraggingId(null)}
                        onDragOver={(event: DragEvent) =>
                            event.preventDefault()
                        }
                        onDrop={() => handleDrop(item.id)}
                        className={`group relative aspect-square overflow-hidden rounded-md border bg-muted ${
                            onReorder ? 'cursor-move' : ''
                        } ${draggingId === item.id ? 'opacity-50' : ''}`}
                    >
                        {item.url ? (
                            <img
                                src={item.url}
                                alt={item.name ?? ''}
                                className="size-full object-cover"
                            />
                        ) : null}

                        <Button
                            type="button"
                            variant="destructive"
                            size="icon"
                            disabled={processing}
                            onClick={() => onRemove(item.id)}
                            className="absolute top-1 right-1 size-7 opacity-0 transition-opacity group-hover:opacity-100 focus-visible:opacity-100"
                            aria-label="Görseli sil"
                        >
                            <Trash2 />
                        </Button>
                    </div>
                ))}

                {canAdd ? (
                    <button
                        type="button"
                        disabled={processing}
                        onClick={() => inputRef.current?.click()}
                        className="flex aspect-square flex-col items-center justify-center gap-1 rounded-md border border-dashed text-muted-foreground transition-colors hover:bg-muted disabled:opacity-50"
                    >
                        <ImagePlus className="size-5" />
                        <span className="text-xs">Ekle</span>
                    </button>
                ) : null}

                <input
                    ref={inputRef}
                    type="file"
                    accept={accept}
                    multiple
                    className="sr-only"
                    onChange={handlePick}
                />
            </div>

            <InputError message={error} />
        </div>
    );
}
