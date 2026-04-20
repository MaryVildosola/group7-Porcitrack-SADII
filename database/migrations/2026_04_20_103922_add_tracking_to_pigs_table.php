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
            $table->decimal('weight', 8, 2)->default(0)->after('birth_date');
            $table->decimal('target_weight', 8, 2)->default(100)->after('weight');
            $table->string('health_status')->default('Healthy')->after('status'); // Healthy, Warning, Sick
            $table->text('remarks')->nullable()->after('health_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pigs', function (Blueprint $table) {
            $table->dropColumn(['weight', 'target_weight', 'health_status', 'remarks']);
        });
    }
};
