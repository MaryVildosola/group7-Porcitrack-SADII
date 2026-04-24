<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pig_activities', function (Blueprint $table) {
            $table->boolean('is_critical_alert')->default(false)->after('details');
            $table->timestamp('acknowledged_at')->nullable()->after('is_critical_alert');
            $table->foreignId('acknowledged_by')->nullable()->constrained('users')->after('acknowledged_at');
        });
    }

    public function down(): void
    {
        Schema::table('pig_activities', function (Blueprint $table) {
            $table->dropColumn(['is_critical_alert', 'acknowledged_at', 'acknowledged_by']);
        });
    }
};
