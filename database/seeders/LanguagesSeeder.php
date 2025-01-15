<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Language;
use App\Enums\Status;

class LanguagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $languages = [
            [
                'name' => 'Türkçe',
                'code' => 'tr',
                'regional_code' => 'tr_TR',
                'charset' => 'UTF-8',
                'direction' => 'ltr'
            ],

            // En Yaygın Diller - Batı
            [
                'name' => 'İngilizce (ABD)',
                'code' => 'en',
                'regional_code' => 'en_US',
                'charset' => 'UTF-8',
                'direction' => 'ltr'
            ],
            [
                'name' => 'İngilizce (İngiltere)',
                'code' => 'en',
                'regional_code' => 'en_GB',
                'charset' => 'UTF-8',
                'direction' => 'ltr'
            ],
            [
                'name' => 'İspanyolca (İspanya)',
                'code' => 'es',
                'regional_code' => 'es_ES',
                'charset' => 'UTF-8',
                'direction' => 'ltr'
            ],
            [
                'name' => 'İspanyolca (Latin Amerika)',
                'code' => 'es',
                'regional_code' => 'es_419',
                'charset' => 'UTF-8',
                'direction' => 'ltr'
            ],
            [
                'name' => 'Fransızca (Fransa)',
                'code' => 'fr',
                'regional_code' => 'fr_FR',
                'charset' => 'UTF-8',
                'direction' => 'ltr'
            ],
            [
                'name' => 'Fransızca (Kanada)',
                'code' => 'fr',
                'regional_code' => 'fr_CA',
                'charset' => 'UTF-8',
                'direction' => 'ltr'
            ],
            [
                'name' => 'Portekizce (Portekiz)',
                'code' => 'pt',
                'regional_code' => 'pt_PT',
                'charset' => 'UTF-8',
                'direction' => 'ltr'
            ],
            [
                'name' => 'Portekizce (Brezilya)',
                'code' => 'pt',
                'regional_code' => 'pt_BR',
                'charset' => 'UTF-8',
                'direction' => 'ltr'
            ],
            [
                'name' => 'Almanca',
                'code' => 'de',
                'regional_code' => 'de_DE',
                'charset' => 'UTF-8',
                'direction' => 'ltr'
            ],

            // En Yaygın Diller - Asya
            [
                'name' => 'Çince (Basitleştirilmiş)',
                'code' => 'zh',
                'regional_code' => 'zh_CN',
                'charset' => 'UTF-8',
                'direction' => 'ltr'
            ],
            [
                'name' => 'Çince (Geleneksel)',
                'code' => 'zh',
                'regional_code' => 'zh_TW',
                'charset' => 'UTF-8',
                'direction' => 'ltr'
            ],
            [
                'name' => 'Japonca',
                'code' => 'ja',
                'regional_code' => 'ja_JP',
                'charset' => 'UTF-8',
                'direction' => 'ltr'
            ],
            [
                'name' => 'Korece',
                'code' => 'ko',
                'regional_code' => 'ko_KR',
                'charset' => 'UTF-8',
                'direction' => 'ltr'
            ],
            [
                'name' => 'Hintçe',
                'code' => 'hi',
                'regional_code' => 'hi_IN',
                'charset' => 'UTF-8',
                'direction' => 'ltr'
            ],
            [
                'name' => 'Bengali',
                'code' => 'bn',
                'regional_code' => 'bn_BD',
                'charset' => 'UTF-8',
                'direction' => 'ltr'
            ],
            [
                'name' => 'Rusça',
                'code' => 'ru',
                'regional_code' => 'ru_RU',
                'charset' => 'UTF-8',
                'direction' => 'ltr'
            ],

            // En Yaygın Diller - Güneydoğu Asya
            [
                'name' => 'Endonezce',
                'code' => 'id',
                'regional_code' => 'id_ID',
                'charset' => 'UTF-8',
                'direction' => 'ltr'
            ],
            [
                'name' => 'Malayca',
                'code' => 'ms',
                'regional_code' => 'ms_MY',
                'charset' => 'UTF-8',
                'direction' => 'ltr'
            ],

            // En Yaygın Diller - Orta Doğu ve Afrika
            [
                'name' => 'Arapça (Modern Standart)',
                'code' => 'ar',
                'regional_code' => 'ar_001',
                'charset' => 'UTF-8',
                'direction' => 'rtl'
            ],
            [
                'name' => 'Farsça',
                'code' => 'fa',
                'regional_code' => 'fa_IR',
                'charset' => 'UTF-8',
                'direction' => 'rtl'
            ],
            [
                'name' => 'Urduca',
                'code' => 'ur',
                'regional_code' => 'ur_PK',
                'charset' => 'UTF-8',
                'direction' => 'rtl'
            ],
            [
                'name' => 'Svahili',
                'code' => 'sw',
                'regional_code' => 'sw_KE',
                'charset' => 'UTF-8',
                'direction' => 'ltr'
            ]
        ];

        foreach ($languages as $language) {
            Language::create([
                'status' => $language['code'] === 'tr' ? Status::ACTIVE : Status::PASSIVE,
                'name' => $language['name'],
                'code' => $language['code'],
                'regional_code' => $language['regional_code'],
                'charset' => $language['charset'],
                'direction' => $language['direction'],
            ]);
        }
    }
}
