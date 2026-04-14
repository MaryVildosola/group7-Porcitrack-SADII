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
        Schema::table('weekly_reports', function (Blueprint $table) {
            $table->integer('total_pigs')->default(0)->after('user_id');
            $table->integer('sick_pigs')->default(0)->after('total_pigs');
            $table->float('avg_weight')->default(0)->after('sick_pigs');
            $table->float('feed_consumed')->default(0)->after('avg_weight');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('weekly_reports', function (Blueprint $table) {
            $table->dropColumn(['total_pigs', 'sick_pigs', 'avg_weight', 'feed_consumed']);
        });
    }
};
