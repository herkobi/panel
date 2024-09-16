<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Doğrulama Dil Satırları
    |--------------------------------------------------------------------------
    |
    | Aşağıdaki dil satırları, doğrulama sınıfı tarafından kullanılan varsayılan
    | hata mesajlarını içerir. Bazı kuralların birden fazla versiyonu vardır,
    | örneğin boyut kuralları. Bu mesajları burada istediğiniz gibi
    | düzenleyebilirsiniz.
    |
    */

    'accepted' => ':attribute alanı kabul edilmelidir.',
    'accepted_if' => ':attribute alanı, :other :value olduğunda kabul edilmelidir.',
    'active_url' => ':attribute geçerli bir URL olmalıdır.',
    'after' => ':attribute alanı :date tarihinden sonra bir tarih olmalıdır.',
    'after_or_equal' => ':attribute alanı :date tarihine eşit veya bu tarihten sonra bir tarih olmalıdır.',
    'alpha' => ':attribute alanı sadece harfler içermelidir.',
    'alpha_dash' => ':attribute alanı sadece harfler, sayılar, tire ve alt çizgi içerebilir.',
    'alpha_num' => ':attribute alanı sadece harfler ve sayılar içerebilir.',
    'array' => ':attribute bir dizi olmalıdır.',
    'ascii' => ':attribute yalnızca tek baytlık alfanumerik karakterler ve semboller içermelidir.',
    'before' => ':attribute alanı :date tarihinden önce bir tarih olmalıdır.',
    'before_or_equal' => ':attribute alanı :date tarihine eşit veya bu tarihten önce bir tarih olmalıdır.',
    'between' => [
        'array' => ':attribute alanı :min ile :max öğe arasında olmalıdır.',
        'file' => ':attribute dosyası :min ile :max kilobayt arasında olmalıdır.',
        'numeric' => ':attribute alanı :min ile :max arasında olmalıdır.',
        'string' => ':attribute alanı :min ile :max karakter arasında olmalıdır.',
    ],
    'boolean' => ':attribute alanı doğru veya yanlış olmalıdır.',
    'can' => ':attribute alanı yetkisiz bir değer içeriyor.',
    'confirmed' => ':attribute alanı doğrulama ile eşleşmiyor.',
    'contains' => ':attribute alanı gerekli bir değeri içermiyor.',
    'current_password' => 'Parola yanlış.',
    'date' => ':attribute geçerli bir tarih olmalıdır.',
    'date_equals' => ':attribute alanı :date ile eşit bir tarih olmalıdır.',
    'date_format' => ':attribute alanı :format formatı ile eşleşmelidir.',
    'decimal' => ':attribute alanı :decimal ondalık basamak içermelidir.',
    'declined' => ':attribute reddedilmelidir.',
    'declined_if' => ':other :value olduğunda :attribute reddedilmelidir.',
    'different' => ':attribute ve :other farklı olmalıdır.',
    'digits' => ':attribute :digits basamaklı olmalıdır.',
    'digits_between' => ':attribute :min ile :max basamak arasında olmalıdır.',
    'dimensions' => ':attribute geçersiz görsel boyutlarına sahiptir.',
    'distinct' => ':attribute alanında tekrar eden bir değer var.',
    'doesnt_end_with' => ':attribute şu değerlerden biriyle bitmemelidir: :values.',
    'doesnt_start_with' => ':attribute şu değerlerden biriyle başlamamalıdır: :values.',
    'email' => ':attribute geçerli bir e-posta adresi olmalıdır.',
    'ends_with' => ':attribute şu değerlerden biriyle bitmelidir: :values.',
    'enum' => 'Seçilen :attribute geçersiz.',
    'exists' => 'Seçilen :attribute geçersiz.',
    'extensions' => ':attribute şu uzantılardan biri olmalıdır: :values.',
    'file' => ':attribute bir dosya olmalıdır.',
    'filled' => ':attribute alanı doldurulmalıdır.',
    'gt' => [
        'array' => ':attribute alanı :value öğeden fazla olmalıdır.',
        'file' => ':attribute dosyası :value kilobayttan büyük olmalıdır.',
        'numeric' => ':attribute :value sayısından büyük olmalıdır.',
        'string' => ':attribute :value karakterden büyük olmalıdır.',
    ],
    'gte' => [
        'array' => ':attribute alanı :value öğe veya daha fazla içermelidir.',
        'file' => ':attribute dosyası :value kilobayt veya daha büyük olmalıdır.',
        'numeric' => ':attribute :value veya daha büyük olmalıdır.',
        'string' => ':attribute :value karakter veya daha fazla olmalıdır.',
    ],
    'hex_color' => ':attribute geçerli bir onaltılık renk kodu olmalıdır.',
    'image' => ':attribute bir görsel olmalıdır.',
    'in' => 'Seçilen :attribute geçersiz.',
    'in_array' => ':attribute alanı :other içinde bulunmalıdır.',
    'integer' => ':attribute tam sayı olmalıdır.',
    'ip' => ':attribute geçerli bir IP adresi olmalıdır.',
    'ipv4' => ':attribute geçerli bir IPv4 adresi olmalıdır.',
    'ipv6' => ':attribute geçerli bir IPv6 adresi olmalıdır.',
    'json' => ':attribute geçerli bir JSON dizisi olmalıdır.',
    'list' => ':attribute bir liste olmalıdır.',
    'lowercase' => ':attribute küçük harf olmalıdır.',
    'lt' => [
        'array' => ':attribute alanı :value öğeden az olmalıdır.',
        'file' => ':attribute dosyası :value kilobayttan küçük olmalıdır.',
        'numeric' => ':attribute :value sayısından küçük olmalıdır.',
        'string' => ':attribute :value karakterden küçük olmalıdır.',
    ],
    'lte' => [
        'array' => ':attribute alanı :value öğeden fazla olmamalıdır.',
        'file' => ':attribute dosyası :value kilobayttan küçük veya eşit olmalıdır.',
        'numeric' => ':attribute :value sayısından küçük veya eşit olmalıdır.',
        'string' => ':attribute :value karakterden küçük veya eşit olmalıdır.',
    ],
    'mac_address' => ':attribute geçerli bir MAC adresi olmalıdır.',
    'max' => [
        'array' => ':attribute alanı en fazla :max öğe içerebilir.',
        'file' => ':attribute dosyası :max kilobayttan büyük olamaz.',
        'numeric' => ':attribute :max sayısından büyük olamaz.',
        'string' => ':attribute :max karakterden fazla olamaz.',
    ],
    'max_digits' => ':attribute :max basamaktan fazla olamaz.',
    'mimes' => ':attribute şu dosya türlerinden biri olmalıdır: :values.',
    'mimetypes' => ':attribute şu dosya türlerinden biri olmalıdır: :values.',
    'min' => [
        'array' => ':attribute en az :min öğe içermelidir.',
        'file' => ':attribute en az :min kilobayt olmalıdır.',
        'numeric' => ':attribute en az :min olmalıdır.',
        'string' => ':attribute en az :min karakter olmalıdır.',
    ],
    'min_digits' => ':attribute en az :min basamak olmalıdır.',
    'missing' => ':attribute alanı eksik olmalıdır.',
    'missing_if' => ':attribute alanı, :other :value olduğunda eksik olmalıdır.',
    'missing_unless' => ':attribute alanı, :other :value olmadıkça eksik olmalıdır.',
    'missing_with' => ':attribute alanı, :values mevcut olduğunda eksik olmalıdır.',
    'missing_with_all' => ':attribute alanı, :values mevcut olduğunda eksik olmalıdır.',
    'multiple_of' => ':attribute :value katı olmalıdır.',
    'not_in' => 'Seçilen :attribute geçersiz.',
    'not_regex' => ':attribute formatı geçersiz.',
    'numeric' => ':attribute bir sayı olmalıdır.',
    'password' => [
        'letters' => ':attribute en az bir harf içermelidir.',
        'mixed' => ':attribute en az bir büyük ve bir küçük harf içermelidir.',
        'numbers' => ':attribute en az bir sayı içermelidir.',
        'symbols' => ':attribute en az bir sembol içermelidir.',
        'uncompromised' => 'Verilen :attribute bir veri ihlalinde bulundu. Lütfen farklı bir :attribute seçin.',
    ],
    'present' => ':attribute alanı mevcut olmalıdır.',
    'prohibited' => ':attribute alanı yasaktır.',
    'prohibited_if' => ':attribute alanı, :other :value olduğunda yasaktır.',
    'prohibited_unless' => ':attribute alanı, :other :values içinde olmadıkça yasaktır.',
    'prohibits' => ':attribute alanı, :other alanının mevcut olmasını engelliyor.',
    'regex' => ':attribute formatı geçersiz.',
    'required' => ':attribute alanı gereklidir.',
    'required_array_keys' => ':attribute alanı şunlar için girişler içermelidir: :values.',
    'required_if' => ':attribute alanı, :other :value olduğunda gereklidir.',
    'required_if_accepted' => ':attribute alanı, :other kabul edildiğinde gereklidir.',
    'required_unless' => ':attribute alanı, :other :values içinde olmadıkça gereklidir.',
    'required_with' => ':attribute alanı, :values mevcut olduğunda gereklidir.',
    'required_with_all' => ':attribute alanı, :values mevcut olduğunda gereklidir.',
    'required_without' => ':attribute alanı, :values mevcut olmadığında gereklidir.',
    'required_without_all' => ':attribute alanı, :values değerlerinden hiçbiri mevcut olmadığında gereklidir.',
    'same' => ':attribute ve :other eşleşmelidir.',
    'size' => [
        'array' => ':attribute :size öğe içermelidir.',
        'file' => ':attribute :size kilobayt olmalıdır.',
        'numeric' => ':attribute :size olmalıdır.',
        'string' => ':attribute :size karakter olmalıdır.',
    ],
    'starts_with' => ':attribute şu değerlerden biriyle başlamalıdır: :values.',
    'string' => ':attribute bir dizi olmalıdır.',
    'timezone' => ':attribute geçerli bir saat dilimi olmalıdır.',
    'ulid' => ':attribute geçerli bir ULID olmalıdır.',
    'unique' => ':attribute daha önce alınmış.',
    'uploaded' => ':attribute yüklenemedi.',
    'uppercase' => ':attribute büyük harf olmalıdır.',
    'url' => ':attribute geçerli bir URL olmalıdır.',
    'uuid' => ':attribute geçerli bir UUID olmalıdır.',

    /*
    |--------------------------------------------------------------------------
    | Özel Doğrulama Mesajları
    |--------------------------------------------------------------------------
    |
    | Belirli alanlar için özel doğrulama mesajları tanımlayabilirsiniz. Bu,
    | belirli bir alanın doğrulama kuralına göre belirli mesajları
    | tanımlamak için kullanışlıdır. Aşağıdaki örnekte gösterildiği gibi.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'özel-mesaj',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Özel Doğrulama Alanları
    |--------------------------------------------------------------------------
    |
    | Aşağıdaki dil satırları, "attribute" yer tutucusunu daha okunabilir
    | hale getirmek için kullanılır. Bu, kullanıcı dostu mesajlar
    | oluşturmanıza yardımcı olur. Örneğin, "email" yerine "E-posta Adresi".
    |
    */

    'attributes' => [],

];
