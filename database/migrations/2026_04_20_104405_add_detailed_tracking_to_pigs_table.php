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
        Schema::table('pigs', function (Blueprint $table) {
            $table->string('breed')->nullable()->after('tag');
            $table->integer('bcs_score')->default(3)->after('weight'); // Body Condition Score 1-5
            $table->string('feeding_status')->default('Normal')->after('bcs_score'); // Active, Normal, Poor
            $table->string('symptoms')->nullable()->after('health_status'); // Lethargic, Coughing, etc.
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pigs', function (Blueprint $table) {
            $table->dropColumn(['breed', 'bcs_score', 'feeding_status', 'symptoms']);
        });
    }
};
