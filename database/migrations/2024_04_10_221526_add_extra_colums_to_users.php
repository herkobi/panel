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
            $table->string('title')->nullable()->after('surname');
            $table->text('about')->nullable()->after('title');
            $table->text('settings')->after('about');
            $table->timestamp('last_login_at')->nullable()->after('settings');
            $table->string('last_login_ip')->nullable()->after('last_login_at');
            $table->text('agent')->nullable()->after('last_login_ip');
            $table->boolean('terms')->default(false)->after('settings');
            $table->integer('created_by')->default(0)->after('terms');
            $table->string('created_by_name')->default('Owner')->after('created_by');
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
