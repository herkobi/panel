<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('media', function (Blueprint $table) {
            $table->uuid('id')->primary();

            // Polymorphic sahip (Account, member-scoped modeller, admin modelleri…).
            $table->uuidMorphs('mediable');

            $table->string('disk', 32);
            $table->string('path');
            $table->string('original_name');
            $table->string('mime_type', 128)->nullable();
            $table->unsignedBigInteger('size')->default(0);
            $table->string('collection', 64)->default('default');
            $table->unsignedInteger('sort_order')->default(0);

            // Uygulamaya özel metadata (alt text, kapak işareti, focal point…).
            // Şema sabit DEĞİL; anlamı tüketen sisteme aittir, opsiyoneldir.
            $table->json('custom_properties')->nullable();

            $table->timestamps();

            $table->index(['mediable_type', 'mediable_id', 'collection']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media');
    }
};
