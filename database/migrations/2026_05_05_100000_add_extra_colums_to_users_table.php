<?php

declare(strict_types=1);

use App\Enums\UserStatus;
use App\Enums\UserType;
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
        Schema::table('users', function (Blueprint $table) {
            $table->string('status', 20)->default(UserStatus::Active->value)->after('id')->index();
            $table->string('user_type', 20)->default(UserType::Member->value)->after('status')->index();
            $table->string('locale', 8)->default('tr')->after('user_type');
            $table->string('timezone', 64)->default('Europe/Istanbul')->after('locale');
            $table->string('media_directory', 9)->nullable()->unique()->after('timezone');
            $table->timestamp('last_login_at')->nullable()->after('password');
            $table->softDeletes()->after('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['status', 'user_type', 'locale', 'timezone', 'media_directory', 'last_login_at']);
            $table->dropSoftDeletes();
        });
    }
};
