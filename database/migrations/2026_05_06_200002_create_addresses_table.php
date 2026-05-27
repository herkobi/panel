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
        Schema::create('addresses', function (Blueprint $table) {
            $table->uuid('id')->primary();

            // Account ile birebir adres bilgisi.
            $table->foreignUuid('account_id')
                ->unique()
                ->constrained()
                ->cascadeOnDelete();

            $table->text('address')->nullable();
            $table->string('postal_code', 16)->nullable();

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
        Schema::dropIfExists('addresses');
    }
};
