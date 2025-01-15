<?php

use App\Enums\Status;
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
        Schema::create('countries', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('status')->default(Status::ACTIVE->value);
            $table->string('name', 100); // ülke adları için makul bir uzunluk
            $table->string('code', 2)->unique(); // ISO 3166-1 alpha-2 kodları unique olmalı
            $table->timestamps();

            $table->index(['status', 'code']);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('countries');
    }
};
