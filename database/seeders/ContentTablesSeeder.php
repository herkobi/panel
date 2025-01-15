<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Enums\Status;
use App\Models\Page;
use Illuminate\Support\Str;

class ContentTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pages = ['Hakkımızda', 'İletişim'];

        foreach ($pages as $page) {
            Page::create([
                'status' => Status::ACTIVE,
                'title' => $page,
                'slug' => Str::slug($page),
                'content' => $page
            ]);
        }
    }
}
