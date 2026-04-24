<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('pig_sales', function (Blueprint $table) {
        $table->id();
        $table->foreignId('pig_id')->constrained()->onDelete('cascade');
        $table->string('type'); // 'Sold' or 'Disposed/Deceased'
        $table->decimal('amount', 10, 2)->nullable(); // Magkano naibenta
        $table->string('buyer_name')->nullable();
        $table->date('transaction_date');
        $table->text('notes')->nullable(); // Reason for disposal or extra details
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pig_sales');
    }
};
