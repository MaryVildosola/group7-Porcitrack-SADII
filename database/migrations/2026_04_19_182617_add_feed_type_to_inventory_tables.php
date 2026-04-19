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
        Schema::table('feed_deliveries', function (Blueprint $table) {
            $table->string('feed_type')->after('id')->default('Standard Feed');
        });
        Schema::table('feed_consumptions', function (Blueprint $table) {
            $table->string('feed_type')->after('pen_id')->default('Standard Feed');
        });
    }

    public function down(): void
    {
        Schema::table('feed_deliveries', function (Blueprint $table) {
            $table->dropColumn('feed_type');
        });
        Schema::table('feed_consumptions', function (Blueprint $table) {
            $table->dropColumn('feed_type');
        });
    }
};
