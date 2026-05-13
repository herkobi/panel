<x-mail::message>
# Merhaba {{ $user->name }},

Panel hesabınız oluşturuldu.

Şifrenizi belirlemek ve hesabınızı kullanmaya başlamak için aşağıdaki bağlantıya tıklayın.

@if ($verifiesEmail)
Bağlantıya tıkladığınızda e-posta adresiniz önce onaylanacak, ardından şifrenizi belirleyeceğiniz ekrana yönlendirileceksiniz.
@else
E-posta adresiniz onaylanmış durumda; bağlantı sizi doğrudan şifre belirleme ekranına yönlendirecek.
@endif

<x-mail::button :url="$welcomeUrl">
Şifremi Belirle
</x-mail::button>

Bu bağlantı {{ $expireMinutes }} dakika içinde geçerliliğini yitirecek.

Bu hesabı beklemiyorsanız bağlantıya tıklamayın ve destek ekibiyle iletişime geçin.

Saygılar,<br>
{{ config('app.name') }}

<x-slot:subcopy>
Şifremi Belirle butonuna tıklayamıyorsanız aşağıdaki bağlantıyı kopyalayıp tarayıcınıza yapıştırın:
[{{ $welcomeUrl }}]({{ $welcomeUrl }})
</x-slot:subcopy>
</x-mail::message>
