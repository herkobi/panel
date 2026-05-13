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
        Schema::create('accounts', function (Blueprint $table) {
            $table->uuid('id')->primary();

            // Kullanıcı ile birebir ilişki
            $table->foreignUuid('user_id')
                ->unique()
                ->constrained()
                ->cascadeOnDelete();

            // Ünvan ve Adres Bilgileri[cite: 17]
            $table->string('title')->nullable();
            $table->text('address')->nullable();
            $table->string('postal_code', 16)->nullable();

            // Lokasyon İlişkileri (String yerine UUID Referansları)
            $table->foreignUuid('country_id')
                ->nullable()
                ->constrained('countries')
                ->nullOnDelete();

            $table->foreignUuid('city_id')
                ->nullable()
                ->constrained('cities')
                ->nullOnDelete();

            $table->foreignUuid('district_id')
                ->nullable()
                ->constrained('districts')
                ->nullOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};
