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
    Schema::create('pigs', function (Blueprint $table) {
        $table->id();
        $table->string('tag')->unique();

        $table->string('breed')->nullable();

        $table->foreignId('pen_id')->constrained('pens')->onDelete('cascade');

        $table->string('status')->default('active');

        $table->date('birth_date')->nullable();

        // FULL TRACKING
        $table->integer('weight')->nullable();
        $table->string('health_status')->default('Healthy');

        $table->integer('bcs_score')->default(3);
        $table->string('feeding_status')->default('Normal');
        $table->string('symptoms')->nullable();

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pigs');
    }
};
