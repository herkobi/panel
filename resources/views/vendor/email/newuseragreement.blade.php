<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yeni Yönetici Sözleşme Versiyonu Yayınlandı</title>
</head>

<body>
    <h2>{{ $agreement->title }} Güncelleniyor</h2>

    <p>Sayın {{ $user->name }} {{ $user->surname }},</p>

    <p><strong>{{ $agreement->title }}</strong> sözleşmesinin yeni bir versiyonu ({{ $version->version }}) yayınlandı.
    </p>

    @if ($version->block_access)
        <p>Bu sözleşme versiyonunu kabul etmediğiniz sürece sisteme erişiminiz kısıtlanacaktır.</p>
    @elseif($version->require_acceptance)
        <p>Bu sözleşme versiyonunu incelemeniz ve kabul etmeniz gerekmektedir.</p>
    @endif

    <p>İyi günler dileriz,<br>
        {{ Setting::get('title') }} Ekibi<br>{{ Setting::get('slogan') }}
    </p>
</body>

</html>
