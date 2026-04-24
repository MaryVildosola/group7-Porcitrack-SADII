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
        Schema::table('pig_activities', function (Blueprint $table) {
            $table->text('admin_response')->nullable()->after('is_critical_alert');
            $table->string('new_health_status')->nullable()->after('admin_response');
            $table->string('new_feeding_status')->nullable()->after('new_health_status');
        });
    }

    public function down(): void
    {
        Schema::table('pig_activities', function (Blueprint $table) {
            $table->dropColumn(['admin_response', 'new_health_status', 'new_feeding_status']);
        });
    }
};
