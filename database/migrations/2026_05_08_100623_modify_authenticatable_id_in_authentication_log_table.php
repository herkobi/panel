<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('authentication_log', function (Blueprint $table) {
            // Sütunu UUID (string) tipine dönüştürüyoruz
            $table->string('authenticatable_id', 36)->change();
        });
    }

    public function down(): void
    {
        Schema::table('authentication_log', function (Blueprint $table) {
            // Geri almak istersen eski haline (bigint) çevirir
            $table->unsignedBigInteger('authenticatable_id')->change();
        });
    }
};
