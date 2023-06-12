<?php

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
            $table->tinyInteger('status')->default(1);
            $table->integer('terms')->after('password')->default(1);
            $table->datetime('last_login_at')->nullable()->after('password');
            $table->string('last_login_ip')->nullable()->after('password');
            $table->integer('created_by')->after('email_verified_at');
            $table->string('created_by_name')->after('email_verified_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
