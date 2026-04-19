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
            $table->string('status')->default('active')->after('pen_id'); // active, sold, deceased
        });
    }

    public function down(): void
    {
        Schema::table('pigs', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
