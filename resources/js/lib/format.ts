/**
 * Ortak tarih/para biçimleme yardımcıları (tr-TR).
 * Çekirdeğe ait genel yardımcılar; modüller `@/lib/format` ile kullanır.
 */

export function formatDate(value: string | null | undefined): string {
    if (!value) {
        return '-';
    }

    return new Date(value).toLocaleDateString('tr-TR');
}

export function formatDateTime(value: string | null | undefined): string {
    if (!value) {
        return '-';
    }

    return new Date(value).toLocaleString('tr-TR', {
        dateStyle: 'short',
        timeStyle: 'short',
    });
}

export function formatMoney(value: string | number | null | undefined): string {
    if (value === null || value === undefined || value === '') {
        return '-';
    }

    const amount = typeof value === 'string' ? Number(value) : value;

    if (Number.isNaN(amount)) {
        return String(value);
    }

    return new Intl.NumberFormat('tr-TR', {
        style: 'currency',
        currency: 'TRY',
        minimumFractionDigits: 2,
    }).format(amount);
}
