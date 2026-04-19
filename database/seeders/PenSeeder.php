<?php

namespace Database\Seeders;

use App\Models\Pen;
use Illuminate\Database\Seeder;

class PenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pens = [
            ['name' => 'Pen A1'],
            ['name' => 'Pen A2'],
            ['name' => 'Pen B1'],
            ['name' => 'Pen B2'],
            ['name' => 'Isolation Pen'],
            ['name' => 'Farrowing Pen'],
        ];

        foreach ($pens as $pen) {
            Pen::firstOrCreate($pen);
        }
    }
}
