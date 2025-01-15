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
        Schema::create('languages', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('status')->default(Status::ACTIVE->value);
            $table->string('name', 100); // dil adı
            $table->string('code', 2); // ISO 639-1 dil kodu (en, tr, fr gibi)
            $table->string('regional_code', 8);
            $table->string('charset');
            $table->string('direction');
            $table->timestamps();

            $table->unique('regional_code'); // her bölgesel kod unique olmalı
            $table->index(['status', 'code']); // sık kullanılan alanlar
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('languages');
    }
};
