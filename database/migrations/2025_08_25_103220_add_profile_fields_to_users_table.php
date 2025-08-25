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
            $table->string('username', 20)->default('')->unique()->after('email');
            $table->string('bio', 500)->nullable()->after('username');
            $table->string('avatar')->nullable()->after('bio');

            $table->unsignedInteger('following_count')->default(0)->after('email_verified_at');
            $table->unsignedInteger('followers_count')->default(0)->after('following_count');
            $table->unsignedInteger('bookmarks_count')->default(0)->after('followers_count');
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
