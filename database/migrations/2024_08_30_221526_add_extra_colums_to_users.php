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
            $table->integer('status')->default(1)->after('id');
            $table->integer('type')->after('status');
            $table->string('surname')->after('name');
            $table->timestamp('last_login_at')->nullable()->after('password');
            $table->string('last_login_ip')->nullable()->after('last_login_at');
            $table->text('agent')->nullable()->after('last_login_ip');
            $table->uuid('created_by')->default(0)->after('agent');
            $table->string('created_by_name')->default('Owner')->after('created_by');
            $table->boolean('terms')->after('created_by_name')->default(true);
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
