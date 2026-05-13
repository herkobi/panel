<?php

declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | Doğrulama Dil Satırları
    |--------------------------------------------------------------------------
    |
    | Aşağıdaki dil satırları doğrulayıcı sınıfı tarafından kullanılan
    | varsayılan hata mesajlarını içerir.
    |
    */

    'accepted' => ':attribute kabul edilmelidir.',
    'accepted_if' => ':other :value olduğunda :attribute kabul edilmelidir.',
    'active_url' => ':attribute geçerli bir URL olmalıdır.',
    'after' => ':attribute :date tarihinden sonra olmalıdır.',
    'after_or_equal' => ':attribute :date tarihinden sonra veya bu tarihe eşit olmalıdır.',
    'alpha' => ':attribute yalnızca harflerden oluşmalıdır.',
    'alpha_dash' => ':attribute yalnızca harf, rakam, tire ve alt çizgi içerebilir.',
    'alpha_num' => ':attribute yalnızca harf ve rakam içerebilir.',
    'any_of' => ':attribute geçersiz.',
    'array' => ':attribute dizi olmalıdır.',
    'ascii' => ':attribute yalnızca tek baytlık alfanumerik karakterler ve semboller içerebilir.',
    'before' => ':attribute :date tarihinden önce olmalıdır.',
    'before_or_equal' => ':attribute :date tarihinden önce veya bu tarihe eşit olmalıdır.',
    'between' => [
        'array' => ':attribute :min ile :max arasında öğe içermelidir.',
        'file' => ':attribute :min ile :max kilobayt arasında olmalıdır.',
        'numeric' => ':attribute :min ile :max arasında olmalıdır.',
        'string' => ':attribute :min ile :max karakter arasında olmalıdır.',
    ],
    'boolean' => ':attribute doğru veya yanlış olmalıdır.',
    'can' => ':attribute yetkisiz bir değer içeriyor.',
    'confirmed' => ':attribute onayı eşleşmiyor.',
    'contains' => ':attribute gerekli bir değeri içermiyor.',
    'current_password' => 'Şifre hatalı.',
    'date' => ':attribute geçerli bir tarih olmalıdır.',
    'date_equals' => ':attribute :date tarihine eşit olmalıdır.',
    'date_format' => ':attribute :format biçimiyle eşleşmelidir.',
    'decimal' => ':attribute :decimal ondalık basamağa sahip olmalıdır.',
    'declined' => ':attribute reddedilmelidir.',
    'declined_if' => ':other :value olduğunda :attribute reddedilmelidir.',
    'different' => ':attribute ile :other farklı olmalıdır.',
    'digits' => ':attribute :digits basamaklı olmalıdır.',
    'digits_between' => ':attribute :min ile :max basamak arasında olmalıdır.',
    'dimensions' => ':attribute geçersiz görsel boyutlarına sahip.',
    'distinct' => ':attribute yinelenen bir değere sahip.',
    'doesnt_contain' => ':attribute şunlardan hiçbirini içermemelidir: :values.',
    'doesnt_end_with' => ':attribute şunlardan biriyle bitmemelidir: :values.',
    'doesnt_start_with' => ':attribute şunlardan biriyle başlamamalıdır: :values.',
    'email' => ':attribute geçerli bir e-posta adresi olmalıdır.',
    'encoding' => ':attribute :encoding olarak kodlanmış olmalıdır.',
    'ends_with' => ':attribute şunlardan biriyle bitmelidir: :values.',
    'enum' => 'Seçilen :attribute geçersiz.',
    'exists' => 'Seçilen :attribute geçersiz.',
    'extensions' => ':attribute şu uzantılardan birine sahip olmalıdır: :values.',
    'file' => ':attribute dosya olmalıdır.',
    'filled' => ':attribute bir değer içermelidir.',
    'gt' => [
        'array' => ':attribute :value öğeden fazla içermelidir.',
        'file' => ':attribute :value kilobayttan büyük olmalıdır.',
        'numeric' => ':attribute :value değerinden büyük olmalıdır.',
        'string' => ':attribute :value karakterden uzun olmalıdır.',
    ],
    'gte' => [
        'array' => ':attribute en az :value öğe içermelidir.',
        'file' => ':attribute :value kilobayttan büyük veya buna eşit olmalıdır.',
        'numeric' => ':attribute :value değerinden büyük veya buna eşit olmalıdır.',
        'string' => ':attribute en az :value karakter olmalıdır.',
    ],
    'hex_color' => ':attribute geçerli bir onaltılık renk olmalıdır.',
    'image' => ':attribute görsel olmalıdır.',
    'in' => 'Seçilen :attribute geçersiz.',
    'in_array' => ':attribute :other içinde mevcut olmalıdır.',
    'in_array_keys' => ':attribute şu anahtarlardan en az birini içermelidir: :values.',
    'integer' => ':attribute tam sayı olmalıdır.',
    'ip' => ':attribute geçerli bir IP adresi olmalıdır.',
    'ipv4' => ':attribute geçerli bir IPv4 adresi olmalıdır.',
    'ipv6' => ':attribute geçerli bir IPv6 adresi olmalıdır.',
    'json' => ':attribute geçerli bir JSON metni olmalıdır.',
    'list' => ':attribute liste olmalıdır.',
    'lowercase' => ':attribute küçük harf olmalıdır.',
    'lt' => [
        'array' => ':attribute :value öğeden az içermelidir.',
        'file' => ':attribute :value kilobayttan küçük olmalıdır.',
        'numeric' => ':attribute :value değerinden küçük olmalıdır.',
        'string' => ':attribute :value karakterden kısa olmalıdır.',
    ],
    'lte' => [
        'array' => ':attribute :value öğeden fazla içermemelidir.',
        'file' => ':attribute :value kilobayttan küçük veya buna eşit olmalıdır.',
        'numeric' => ':attribute :value değerinden küçük veya buna eşit olmalıdır.',
        'string' => ':attribute en fazla :value karakter olmalıdır.',
    ],
    'mac_address' => ':attribute geçerli bir MAC adresi olmalıdır.',
    'max' => [
        'array' => ':attribute en fazla :max öğe içermelidir.',
        'file' => ':attribute :max kilobayttan büyük olmamalıdır.',
        'numeric' => ':attribute :max değerinden büyük olmamalıdır.',
        'string' => ':attribute en fazla :max karakter olmalıdır.',
    ],
    'max_digits' => ':attribute en fazla :max basamaklı olmalıdır.',
    'mimes' => ':attribute şu türlerden bir dosya olmalıdır: :values.',
    'mimetypes' => ':attribute şu türlerden bir dosya olmalıdır: :values.',
    'min' => [
        'array' => ':attribute en az :min öğe içermelidir.',
        'file' => ':attribute en az :min kilobayt olmalıdır.',
        'numeric' => ':attribute en az :min olmalıdır.',
        'string' => ':attribute en az :min karakter olmalıdır.',
    ],
    'min_digits' => ':attribute en az :min basamaklı olmalıdır.',
    'missing' => ':attribute mevcut olmamalıdır.',
    'missing_if' => ':other :value olduğunda :attribute mevcut olmamalıdır.',
    'missing_unless' => ':other :value değilse :attribute mevcut olmamalıdır.',
    'missing_with' => ':values mevcut olduğunda :attribute mevcut olmamalıdır.',
    'missing_with_all' => ':values mevcut olduğunda :attribute mevcut olmamalıdır.',
    'multiple_of' => ':attribute :value değerinin katı olmalıdır.',
    'not_in' => 'Seçilen :attribute geçersiz.',
    'not_regex' => ':attribute biçimi geçersiz.',
    'numeric' => ':attribute sayı olmalıdır.',
    'password' => [
        'letters' => ':attribute en az bir harf içermelidir.',
        'mixed' => ':attribute en az bir büyük ve bir küçük harf içermelidir.',
        'numbers' => ':attribute en az bir rakam içermelidir.',
        'symbols' => ':attribute en az bir sembol içermelidir.',
        'uncompromised' => 'Girilen :attribute bir veri sızıntısında yer almış. Lütfen farklı bir :attribute seçin.',
    ],
    'present' => ':attribute mevcut olmalıdır.',
    'present_if' => ':other :value olduğunda :attribute mevcut olmalıdır.',
    'present_unless' => ':other :value değilse :attribute mevcut olmalıdır.',
    'present_with' => ':values mevcut olduğunda :attribute mevcut olmalıdır.',
    'present_with_all' => ':values mevcut olduğunda :attribute mevcut olmalıdır.',
    'prohibited' => ':attribute yasaktır.',
    'prohibited_if' => ':other :value olduğunda :attribute yasaktır.',
    'prohibited_if_accepted' => ':other kabul edildiğinde :attribute yasaktır.',
    'prohibited_if_declined' => ':other reddedildiğinde :attribute yasaktır.',
    'prohibited_unless' => ':other :values içinde değilse :attribute yasaktır.',
    'prohibits' => ':attribute, :other alanının mevcut olmasını engeller.',
    'regex' => ':attribute biçimi geçersiz.',
    'required' => ':attribute zorunludur.',
    'required_array_keys' => ':attribute şu kayıtları içermelidir: :values.',
    'required_if' => ':other :value olduğunda :attribute zorunludur.',
    'required_if_accepted' => ':other kabul edildiğinde :attribute zorunludur.',
    'required_if_declined' => ':other reddedildiğinde :attribute zorunludur.',
    'required_unless' => ':other :values içinde değilse :attribute zorunludur.',
    'required_with' => ':values mevcut olduğunda :attribute zorunludur.',
    'required_with_all' => ':values mevcut olduğunda :attribute zorunludur.',
    'required_without' => ':values mevcut olmadığında :attribute zorunludur.',
    'required_without_all' => ':values değerlerinden hiçbiri mevcut olmadığında :attribute zorunludur.',
    'same' => ':attribute ile :other eşleşmelidir.',
    'size' => [
        'array' => ':attribute :size öğe içermelidir.',
        'file' => ':attribute :size kilobayt olmalıdır.',
        'numeric' => ':attribute :size olmalıdır.',
        'string' => ':attribute :size karakter olmalıdır.',
    ],
    'starts_with' => ':attribute şunlardan biriyle başlamalıdır: :values.',
    'string' => ':attribute metin olmalıdır.',
    'timezone' => ':attribute geçerli bir saat dilimi olmalıdır.',
    'unique' => ':attribute daha önce alınmış.',
    'uploaded' => ':attribute yüklenemedi.',
    'uppercase' => ':attribute büyük harf olmalıdır.',
    'url' => ':attribute geçerli bir URL olmalıdır.',
    'ulid' => ':attribute geçerli bir ULID olmalıdır.',
    'uuid' => ':attribute geçerli bir UUID olmalıdır.',

    /*
    |--------------------------------------------------------------------------
    | Özel Doğrulama Dil Satırları
    |--------------------------------------------------------------------------
    |
    | Burada "attribute.rule" adlandırma düzeniyle özel doğrulama mesajları
    | tanımlayabilirsiniz.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'özel-mesaj',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Özel Doğrulama Alan Adları
    |--------------------------------------------------------------------------
    |
    | Aşağıdaki dil satırları :attribute yer tutucusunu daha okunabilir alan
    | adlarıyla değiştirmek için kullanılır.
    |
    */

    'attributes' => [
        'email' => 'e-posta adresi',
        'password' => 'şifre',
        'password_confirmation' => 'şifre onayı',
        'current_password' => 'mevcut şifre',
        'name' => 'ad',
        'surname' => 'soyad',
        'locale' => 'dil',
        'timezone' => 'saat dilimi',
        'code' => 'kod',
        'title' => 'başlık',
        'address' => 'adres',
        'postal_code' => 'posta kodu',
        'country_id' => 'ülke',
        'city_id' => 'şehir',
        'district_id' => 'ilçe',
    ],

];
