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
        Schema::create('pig_activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pig_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained();
            $table->string('type'); // Care, Medical, Growth
            $table->string('action'); // Bathing, Vaccination, Feeding, etc.
            $table->text('details')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pig_activities');
    }
};
