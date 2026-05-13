<x-mail::message>
# Merhaba {{ $user->name }},

Panel hesabınızın durumu **{{ $status->label() }}** olarak güncellendi.

Bu işlem size ait değilse lütfen destek ekibiyle iletişime geçin.

Saygılar,<br>
{{ config('app.name') }}
</x-mail::message>
