<?php

declare(strict_types=1);

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
        Schema::create('cities', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('country_id')->constrained()->cascadeOnDelete();
            $table->string('code', 16);
            $table->string('name');
            $table->string('status')->default(Status::Active->value)->index();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['country_id', 'code']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cities');
    }
};
