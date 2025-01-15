<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yönetici Hesabı Oluşturuldu</title>
</head>

<body>
    <p>Merhaba {{ $user->name }} {{ $user->surname }},</p>

    <p>{{ Setting::get('title') }} sitesi için hesap bilgileriniz aşağıdaki gibidir:</p>

    <ul>
        <li><strong>E-posta Adresi:</strong> {{ $user->email }}</li>
        <li><strong>Şifre:</strong> {{ $password }}</li>
    </ul>

    <p>Başka bir sorunuz veya yardıma ihtiyacınız varsa lütfen bize ulaşın.</p>

    <p>İyi günler dileriz,<br>
        {{ Setting::get('title') }} Ekibi<br>{{ Setting::get('slogan') }}</p>
</body>

</html>
