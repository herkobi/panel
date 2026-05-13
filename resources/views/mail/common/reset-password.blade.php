<x-mail::message>
# Merhaba,

Hesabınız için bir şifre sıfırlama talebi aldık.

<x-mail::button :url="$resetUrl">
Şifreyi Sıfırla
</x-mail::button>

Bu bağlantı {{ $expireMinutes }} dakika içinde geçerliliğini yitirecek.

Bu işlemi siz başlatmadıysanız herhangi bir işlem yapmanız gerekmez.

Saygılar,<br>
{{ config('app.name') }}

<x-slot:subcopy>
Şifreyi Sıfırla butonuna tıklayamıyorsanız aşağıdaki bağlantıyı kopyalayıp tarayıcınıza yapıştırın:
[{{ $resetUrl }}]({{ $resetUrl }})
</x-slot:subcopy>
</x-mail::message>
