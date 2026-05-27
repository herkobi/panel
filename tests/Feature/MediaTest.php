<?php

declare(strict_types=1);

use App\Models\Account;
use App\Models\Country;
use App\Models\Media;
use App\Services\Support\FileService;
use App\Services\Support\MediaService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

test('attaches a private file under the account code directory', function () {
    Storage::fake(FileService::PRIVATE_DISK);

    $account = Account::factory()->create();
    $media = app(MediaService::class)->attach(
        $account,
        UploadedFile::fake()->create('doc.pdf', 10, 'application/pdf'),
        'documents',
    );

    expect($media->disk)->toBe(FileService::PRIVATE_DISK)
        ->and($media->path)->toStartWith($account->code.'/')
        ->and($media->collection)->toBe('documents')
        ->and($media->mediable->is($account))->toBeTrue();

    Storage::disk(FileService::PRIVATE_DISK)->assertExists($media->path);
});

test('attaches a public file then detach removes file and row', function () {
    Storage::fake(FileService::PUBLIC_DISK);

    $account = Account::factory()->create();
    $service = app(MediaService::class);

    $media = $service->attach(
        $account,
        UploadedFile::fake()->image('photo.jpg'),
        'gallery',
        private: false,
    );

    expect($media->disk)->toBe(FileService::PUBLIC_DISK)
        ->and($media->path)->toStartWith($account->code.'/')
        ->and($media->url())->toContain($media->path);
    Storage::disk(FileService::PUBLIC_DISK)->assertExists($media->path);

    $service->detach($media);

    Storage::disk(FileService::PUBLIC_DISK)->assertMissing($media->path);
    expect(Media::query()->whereKey($media->getKey())->exists())->toBeFalse();
});

test('reorders media within a collection', function () {
    Storage::fake(FileService::PRIVATE_DISK);

    $account = Account::factory()->create();
    $service = app(MediaService::class);

    $first = $service->attach($account, UploadedFile::fake()->create('1.pdf', 1, 'application/pdf'), 'docs');
    $second = $service->attach($account, UploadedFile::fake()->create('2.pdf', 1, 'application/pdf'), 'docs');

    $service->reorder($account, 'docs', [$second->id, $first->id]);

    expect($second->fresh()->sort_order)->toBe(0)
        ->and($first->fresh()->sort_order)->toBe(1);
});

test('rejects owners that do not use the HasMedia trait', function () {
    expect(fn () => app(MediaService::class)->attach(
        new Country,
        UploadedFile::fake()->create('x.pdf', 1, 'application/pdf'),
    ))->toThrow(InvalidArgumentException::class);
});
