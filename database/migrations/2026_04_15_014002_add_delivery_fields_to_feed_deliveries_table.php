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
            $table->date('delivery_date')->after('id')->nullable(false);
            $table->integer('quantity')->after('delivery_date')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('feed_deliveries', function (Blueprint $table) {
            $table->dropColumn(['delivery_date', 'quantity']);
        });
    }
};
