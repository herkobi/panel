<x-mail::message>
# Merhaba {{ $user->name }},

Üyeliğinize ait e-posta adresi için değişiklik talebi oluşturuldu.

Mevcut e-posta adresi: **{{ $user->email }}**
Yeni e-posta adresi: **{{ $email }}**

Bu değişikliği onaylamak için aşağıdaki bağlantıya tıklayın. Bağlantıya tıkladığınızda e-posta adresiniz değiştirilecek, yeni adresiniz onaylanmış sayılacak ve hesabınıza ait diğer oturumlar kapatılacaktır.

<x-mail::button :url="$confirmationUrl">
E-posta Adresimi Değiştir
</x-mail::button>

Bu talebi siz beklemiyorsanız bağlantıya tıklamayın ve destek ekibiyle iletişime geçin.

Saygılar,<br>
{{ config('app.name') }}

<x-slot:subcopy>
E-posta Adresimi Değiştir butonuna tıklayamıyorsanız aşağıdaki bağlantıyı kopyalayıp tarayıcınıza yapıştırın:
[{{ $confirmationUrl }}]({{ $confirmationUrl }})
</x-slot:subcopy>
</x-mail::message>
