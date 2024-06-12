<?php

namespace Database\Factories;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Language>
 */
class LanguageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'status' => Status::ACTIVE,
            'title' => 'Türkçe',
            'desc' => 'Türkçe Dili',
            'direction' => 'ltr',
            'code' => 'tr',
            'iso_code' => 'tr_TR',
            'charset' => 'utf-8',
        ];
    }

    /**
     * Define another language.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function otherLanguage()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => Status::ACTIVE,
                'title' => 'English - USA',
                'desc' => 'American English',
                'direction' => 'ltr',
                'code' => 'us',
                'iso_code' => 'en_US',
                'charset' => 'utf-8',
            ];
        });
    }
}
