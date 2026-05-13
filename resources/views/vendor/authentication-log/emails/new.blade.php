@component('mail::message')
# Merhaba!

{{ config('app.name') }} hesabınıza yeni bir cihazdan giriş yapıldı.

> **Hesap:** {{ $account->email }}<br>
> **Zaman:** {{ $time->toCookieString() }}<br>
> **IP Adresi:** {{ $ipAddress }}<br>
> **Tarayıcı:** {{ $browser }}

Bu giriş size aitse bu uyarıyı dikkate almayabilirsiniz. Hesabınızda şüpheli bir hareket olduğunu düşünüyorsanız lütfen şifrenizi değiştirin.

Saygılar,<br>{{ config('app.name') }}
@endcomponent
