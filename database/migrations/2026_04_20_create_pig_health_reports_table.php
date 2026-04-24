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
        Schema::create('pig_health_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pig_id')->constrained('pigs')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('symptom')->default('Healthy');
            $table->integer('body_condition_score')->nullable();
            $table->string('feeding_behavior')->nullable();
            $table->float('weight')->nullable();
            $table->text('physical_checks')->nullable(); // JSON array of checked items
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->index('pig_id');
            $table->index('user_id');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pig_health_reports');
    }
};
