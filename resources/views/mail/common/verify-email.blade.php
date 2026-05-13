<x-mail::message>
# Merhaba,

Hesabınızı kullanmaya devam etmek için e-posta adresinizi doğrulamanız gerekiyor.

<x-mail::button :url="$verificationUrl">
E-posta Adresimi Doğrula
</x-mail::button>

Bu hesabı siz oluşturmadıysanız herhangi bir işlem yapmanız gerekmez.

Saygılar,<br>
{{ config('app.name') }}

<x-slot:subcopy>
E-posta Adresimi Doğrula butonuna tıklayamıyorsanız aşağıdaki bağlantıyı kopyalayıp tarayıcınıza yapıştırın:
[{{ $verificationUrl }}]({{ $verificationUrl }})
</x-slot:subcopy>
</x-mail::message>
