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
        Schema::table('pens', function (Blueprint $table) {
            $table->string('section')->nullable();
            $table->string('status')->default('Good');
            $table->integer('healthy_pigs')->default(0);
            $table->integer('sick_pigs')->default(0);
            $table->string('avg_weight')->nullable();
            $table->string('target_weight')->nullable();
            $table->string('batch_cost')->nullable();
            $table->string('feed_cons')->nullable();
            $table->string('profit_margin')->nullable();
            $table->integer('progress')->default(0);
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pens', function (Blueprint $table) {
            $table->dropColumn([
                'section', 'status', 'healthy_pigs', 'sick_pigs', 'avg_weight',
                'target_weight', 'batch_cost', 'feed_cons', 'profit_margin',
                'progress', 'start_date', 'end_date'
            ]);
        });
    }
};
