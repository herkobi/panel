<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Page;
use App\Enums\Status;
use Illuminate\Support\Str;

class PagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pages = ['Gizlilik Politikası', 'Çerez Politikası', 'Kullanım Sözleşmesi', 'KVKK Politikası', 'Kullanıcı Aydınlatma Metni', 'Ziyaretçi Aydınlatma Metni', 'Üyelik Sözleşmesi', 'Hizmet Sözleşmesi'];

        foreach ($pages as $page) {
            Page::create([
                'status' => Status::ACTIVE,
                'title' => $page,
                'slug' => Str::slug($page),
                'content' => $page,
            ]);
        }
    }
}
