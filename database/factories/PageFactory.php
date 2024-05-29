<?php

namespace Database\Factories;

use App\Enums\Status;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Page>
 */
class PageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $pages = ['Gizlilik Politikası', 'Çerez Politikası', 'Kullanım Sözleşmesi', 'KVKK Politikası', 'Kullanıcı Aydınlatma Metni', 'Ziyaretçi Aydınlatma Metni', 'Üyelik Sözleşmesi', 'Hizmet Sözleşmesi'];
        foreach($pages as $page)
        {
            return [
                'status' => Status::ACTIVE,
                'title' => $page,
                'slug' => Str::slug($page),
                'text' => '',
            ];
        }

    }
}
