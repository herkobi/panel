<x-mail::message>
# Merhaba,

Hesabiniza daha once kullanilmayan bir cihazdan giris yapildi.

<x-mail::panel>
IP adresi: {{ $ipAddress }}

Zaman: {{ $loginAt }}

Tarayici: {{ $userAgent ?? 'Bilinmiyor' }}
</x-mail::panel>

Bu girisi siz yaptiysaniz herhangi bir islem yapmaniz gerekmez.

Bu girisi siz yapmadiysaniz lutfen sifrenizi degistirin ve destek ekibiyle iletisime gecin.

Saygilar,<br>
{{ config('app.name') }}
</x-mail::message>
