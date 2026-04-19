<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('feed_ingredients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->float('crude_protein')->default(0);       // %
            $table->float('metabolizable_energy')->default(0); // kcal/kg
            $table->float('crude_fat')->default(0);           // %
            $table->float('crude_fiber')->default(0);         // %
            $table->float('calcium')->default(0);             // %
            $table->float('phosphorus')->default(0);          // %
            $table->decimal('cost_per_sack', 10, 2)->nullable(); // optional cost
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('feed_ingredients');
    }
};
