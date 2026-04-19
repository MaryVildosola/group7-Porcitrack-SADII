<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('feed_formula_ingredients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('feed_formula_id')->constrained()->cascadeOnDelete();
            $table->foreignId('feed_ingredient_id')->constrained()->cascadeOnDelete();
            $table->float('quantity_sacks'); // number of sacks of this ingredient
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('feed_formula_ingredients');
    }
};
