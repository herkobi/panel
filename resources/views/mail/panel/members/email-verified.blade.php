<x-mail::message>
# Merhaba {{ $user->name }},

Üyeliğinize ait e-posta adresi bir yönetici tarafından onaylandı.

Bu işlem size ait değilse lütfen destek ekibiyle iletişime geçin.

Saygılar,<br>
{{ config('app.name') }}
</x-mail::message>
