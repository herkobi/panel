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
        // Merkezi sahiplik varlığı: member kullanıcılar ve member verileri buna bağlanır.
        Schema::create('accounts', function (Blueprint $table) {
            $table->uuid('id')->primary();

            // E-posta doğrulamasında üretilen benzersiz kod; ünvan sonradan girilir.
            $table->string('code', 16)->unique();
            $table->string('title')->nullable();

            $table->timestamps();
        });

        // Kullanıcılar bir Account'a bağlanır (admin'ler için null).
        Schema::table('users', function (Blueprint $table) {
            $table->foreignUuid('account_id')
                ->nullable()
                ->after('media_directory')
                ->constrained('accounts')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('account_id');
        });

        Schema::dropIfExists('accounts');
    }
};
