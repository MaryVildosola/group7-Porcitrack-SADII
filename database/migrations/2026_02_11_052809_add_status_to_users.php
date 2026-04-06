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
        Schema::table('users', function (Blueprint $table):void {
            $table->boolean(column: 'status')->default(value: true);
            $table->date(column: 'birthdate')->nullable();
            $table->string(column: 'photo')->nullable();
            //
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table(table: 'users', callback:   function (Blueprint $table): void {$table->dropColumn(columns: 'status');
        $table->dropColumn(columns: 'status');       
        $table->dropColumn(columns: 'birthdate');
        $table->dropColumn(columns: 'photo');
        
            //
        });
    }
};
