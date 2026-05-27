<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Account;
use App\Models\Media;
use App\Services\Support\FileService;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Media>
 */
class MediaFactory extends Factory
{
    public function definition(): array
    {
        return [
            'mediable_type' => (new Account)->getMorphClass(),
            'mediable_id' => Account::factory(),
            'disk' => FileService::PRIVATE_DISK,
            'path' => 'media/'.Str::uuid()->toString().'.bin',
            'original_name' => fake()->word().'.bin',
            'mime_type' => 'application/octet-stream',
            'size' => fake()->numberBetween(1, 1_000_000),
            'collection' => 'default',
            'sort_order' => 0,
        ];
    }
}
