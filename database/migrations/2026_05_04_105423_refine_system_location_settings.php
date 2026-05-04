<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Clean up previous location settings
        DB::table('system_settings')->whereIn('key', [
            'farm_island_group', 
            'farm_region_name', 
            'farm_province', 
            'farm_city'
        ])->delete();

        // Add refined settings
        $settings = [
            [
                'key' => 'farm_region',
                'value' => 'Region IV-A (CALABARZON)',
                'type' => 'select',
                'group' => 'biosecurity',
                'label' => 'Farm Region',
                'description' => 'Select the administrative region.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'farm_province',
                'value' => 'Batangas',
                'type' => 'select',
                'group' => 'biosecurity',
                'label' => 'Farm Province',
                'description' => 'Select the province (filtered by region).',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'farm_city',
                'value' => 'Lipa City',
                'type' => 'string',
                'group' => 'biosecurity',
                'label' => 'City / Municipality',
                'description' => 'The specific city or town (Optional).',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('system_settings')->insert($settings);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('system_settings')->whereIn('key', ['farm_region', 'farm_province', 'farm_city'])->delete();
    }
};
