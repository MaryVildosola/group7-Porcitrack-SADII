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

        $table->string('type');
        $table->string('action');
        $table->text('details')->nullable();

        // MERGED ALERT SYSTEM
        $table->boolean('is_critical_alert')->default(false);
        $table->timestamp('acknowledged_at')->nullable();
        $table->foreignId('acknowledged_by')->nullable()->constrained('users');

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
