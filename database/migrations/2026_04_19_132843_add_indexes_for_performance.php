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
            $table->index('role');
            $table->index('status');
        });

        Schema::table('weekly_reports', function (Blueprint $table) {
            $table->index('week_start_date');
            $table->index('status');
        });

        Schema::table('feed_consumptions', function (Blueprint $table) {
            $table->index('pen_id');
            $table->index('consumption_date');
        });

        Schema::table('pigs', function (Blueprint $table) {
            $table->index('birth_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['role']);
            $table->dropIndex(['status']);
        });

        Schema::table('weekly_reports', function (Blueprint $table) {
            $table->dropIndex(['week_start_date']);
            $table->dropIndex(['status']);
        });

        Schema::table('feed_consumptions', function (Blueprint $table) {
            $table->dropIndex(['pen_id']);
            $table->dropIndex(['consumption_date']);
        });

        Schema::table('pigs', function (Blueprint $table) {
            $table->dropIndex(['birth_date']);
        });
    }
};
