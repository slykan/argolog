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
            $table->string('naziv_gospodarstva')->nullable()->after('name');
            $table->string('mipg')->nullable()->after('naziv_gospodarstva');
            $table->string('oib')->nullable()->after('mipg');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['naziv_gospodarstva', 'mipg', 'oib']);
        });
    }
};
