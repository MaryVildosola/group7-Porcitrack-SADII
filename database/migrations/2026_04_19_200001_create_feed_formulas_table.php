<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('feed_formulas', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('life_stage'); // starter | grower | finisher | breeder
            $table->float('total_batch_sacks')->default(0);
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('feed_formulas');
    }
};
