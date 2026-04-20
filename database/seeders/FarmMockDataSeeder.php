<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Pen;
use App\Models\Pig;
use App\Models\User;
use App\Models\Task;
use App\Models\FeedDelivery;
use App\Models\FeedConsumption;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

use Illuminate\Support\Facades\DB;

class FarmMockDataSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        // 1. Create a Worker if not exists
        $worker = User::firstOrCreate(
            ['email' => 'worker@porcitrack.com'],
            [
                'name' => 'Juan Dela Cruz',
                'password' => Hash::make('password'),
                'role' => 'farm_worker'
            ]
        );

        // 2. Create Pens
        Pen::truncate();
        $pens = [];
        $sections = ['Nursery', 'Growth', 'Finishing', 'Breeding', 'Gestation'];
        foreach ($sections as $index => $section) {
            $num = $index + 1;
            $pens[] = Pen::firstOrCreate(
                ['name' => "Pen $num"],
                ['section' => $section, 'status' => 'Good']
            );
        }

        // 3. Create Pigs for each pen
        Pig::truncate();
        $breeds = ['Landrace', 'Large White', 'Duroc', 'Berkshire', 'Yorkshire'];
        $feedingOptions = ['Active', 'Normal', 'Poor'];
        $symptomsList = [null, null, null, 'Minor Cough', 'Lethargic', 'Skin Irritation'];

        foreach ($pens as $index => $pen) {
            $prefix = chr(65 + $index); // A, B, C...
            for ($j = 1; $j <= 12; $j++) {
                $status = (rand(1, 10) > 8) ? 'Warning' : 'Healthy';
                $weight = rand(20, 95);
                $target = rand(100, 115);
                
                Pig::firstOrCreate(
                    ['tag' => "$prefix$j-00" . str_pad($j, 2, '0', STR_PAD_LEFT)],
                    [
                        'pen_id' => $pen->id,
                        'breed' => $breeds[array_rand($breeds)],
                        'status' => 'active',
                        'health_status' => $status === 'Warning' ? (rand(1,2) == 1 ? 'Warning' : 'Sick') : 'Healthy',
                        'weight' => $weight,
                        'target_weight' => $target,
                        'bcs_score' => rand(2, 4),
                        'feeding_status' => $feedingOptions[array_rand($feedingOptions)],
                        'symptoms' => $status !== 'Healthy' ? $symptomsList[array_rand(array_slice($symptomsList, 3))] : null,
                        'birth_date' => now()->subMonths(rand(1, 4)),
                        'remarks' => $status !== 'Healthy' ? 'Requires immediate clinical observation.' : 'Standard growth pattern observed.'
                    ]
                );
            }
        }

        // 4. Create Deliveries
        FeedDelivery::truncate();
        $supplies = [
            'Pre-Starter Feed', 'Starter Feed', 'Grower Mix', 'Finisher Feed', 'Gestation Feed', 'Lactation Feed',
            'Piglet Vaccines', 'Dewormer', 'Vitamins & Boosters', 'Antibiotics',
            'Farm Disinfectant', 'Industrial Soap', 'Rodent Control'
        ];
        
        foreach ($supplies as $type) {
            FeedDelivery::create([
                'feed_type' => $type,
                'delivery_date' => now()->subDays(rand(5, 60)),
                'quantity' => rand(20, 100)
            ]);
        }

        // 5. Create Consumptions
        FeedConsumption::truncate();
        foreach (array_slice($pens, 0, 3) as $pen) {
            foreach ($supplies as $type) {
                FeedConsumption::create([
                    'pen_id' => $pen->id,
                    'feed_type' => $type,
                    'consumption_date' => now()->subDays(rand(1, 10)),
                    'quantity' => rand(1, 5),
                    'user_id' => $worker->id
                ]);
            }
        }

        // 6. Create some Tasks
        Task::truncate();
        $titles = ['Morning Feeding', 'Evening Feeding', 'Pen Cleaning', 'Vitamin Injection', 'Water Check'];
        foreach ($titles as $title) {
            Task::create([
                'title' => $title,
                'description' => "Standard routine task: $title",
                'assigned_to' => $worker->id,
                'due_date' => now()->addDays(rand(0, 3)),
                'status' => 'pending'
            ]);
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
