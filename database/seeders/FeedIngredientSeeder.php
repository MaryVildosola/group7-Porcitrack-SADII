<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FeedIngredient;

class FeedIngredientSeeder extends Seeder
{
    /**
     * Common Philippine swine feed ingredients with typical nutrient values.
     * CP = Crude Protein (%), ME = Metabolizable Energy (kcal/kg),
     * Fat = Crude Fat (%), Fiber = Crude Fiber (%),
     * Ca = Calcium (%), P = Phosphorus (%)
     */
    public function run(): void
    {
        $ingredients = [
            [
                'name'                   => 'Yellow Corn',
                'crude_protein'          => 8.9,
                'metabolizable_energy'   => 3370,
                'crude_fat'              => 3.8,
                'crude_fiber'            => 2.2,
                'calcium'                => 0.02,
                'phosphorus'             => 0.28,
                'cost_per_sack'          => null,
            ],
            [
                'name'                   => 'Soybean Meal (44% CP)',
                'crude_protein'          => 44.0,
                'metabolizable_energy'   => 2230,
                'crude_fat'              => 1.5,
                'crude_fiber'            => 7.0,
                'calcium'                => 0.29,
                'phosphorus'             => 0.65,
                'cost_per_sack'          => null,
            ],
            [
                'name'                   => 'Rice Bran (Stabilized)',
                'crude_protein'          => 12.0,
                'metabolizable_energy'   => 2180,
                'crude_fat'              => 13.0,
                'crude_fiber'            => 12.0,
                'calcium'                => 0.07,
                'phosphorus'             => 1.50,
                'cost_per_sack'          => null,
            ],
            [
                'name'                   => 'Copra Meal',
                'crude_protein'          => 21.0,
                'metabolizable_energy'   => 1540,
                'crude_fat'              => 8.0,
                'crude_fiber'            => 15.0,
                'calcium'                => 0.18,
                'phosphorus'             => 0.58,
                'cost_per_sack'          => null,
            ],
            [
                'name'                   => 'Fish Meal (Local, 65% CP)',
                'crude_protein'          => 65.0,
                'metabolizable_energy'   => 2820,
                'crude_fat'              => 9.0,
                'crude_fiber'            => 1.0,
                'calcium'                => 5.50,
                'phosphorus'             => 2.90,
                'cost_per_sack'          => null,
            ],
            [
                'name'                   => 'Wheat Bran',
                'crude_protein'          => 15.0,
                'metabolizable_energy'   => 1630,
                'crude_fat'              => 4.0,
                'crude_fiber'            => 10.0,
                'calcium'                => 0.14,
                'phosphorus'             => 1.17,
                'cost_per_sack'          => null,
            ],
            [
                'name'                   => 'Cassava Meal',
                'crude_protein'          => 2.5,
                'metabolizable_energy'   => 3220,
                'crude_fat'              => 0.5,
                'crude_fiber'            => 4.0,
                'calcium'                => 0.15,
                'phosphorus'             => 0.10,
                'cost_per_sack'          => null,
            ],
            [
                'name'                   => 'Blood Meal',
                'crude_protein'          => 80.0,
                'metabolizable_energy'   => 2970,
                'crude_fat'              => 1.0,
                'crude_fiber'            => 1.0,
                'calcium'                => 0.27,
                'phosphorus'             => 0.22,
                'cost_per_sack'          => null,
            ],
            [
                'name'                   => 'Meat and Bone Meal',
                'crude_protein'          => 50.0,
                'metabolizable_energy'   => 2280,
                'crude_fat'              => 9.0,
                'crude_fiber'            => 3.0,
                'calcium'                => 10.0,
                'phosphorus'             => 4.50,
                'cost_per_sack'          => null,
            ],
            [
                'name'                   => 'Molasses (Sugarcane)',
                'crude_protein'          => 3.0,
                'metabolizable_energy'   => 2460,
                'crude_fat'              => 0.0,
                'crude_fiber'            => 0.0,
                'calcium'                => 0.80,
                'phosphorus'             => 0.08,
                'cost_per_sack'          => null,
            ],
            [
                'name'                   => 'Dicalcium Phosphate',
                'crude_protein'          => 0.0,
                'metabolizable_energy'   => 0,
                'crude_fat'              => 0.0,
                'crude_fiber'            => 0.0,
                'calcium'                => 22.0,
                'phosphorus'             => 18.0,
                'cost_per_sack'          => null,
            ],
            [
                'name'                   => 'Limestone / Calcite',
                'crude_protein'          => 0.0,
                'metabolizable_energy'   => 0,
                'crude_fat'              => 0.0,
                'crude_fiber'            => 0.0,
                'calcium'                => 38.0,
                'phosphorus'             => 0.0,
                'cost_per_sack'          => null,
            ],
            [
                'name'                   => 'Salt (NaCl)',
                'crude_protein'          => 0.0,
                'metabolizable_energy'   => 0,
                'crude_fat'              => 0.0,
                'crude_fiber'            => 0.0,
                'calcium'                => 0.0,
                'phosphorus'             => 0.0,
                'cost_per_sack'          => null,
            ],
            [
                'name'                   => 'Vitamin-Mineral Premix',
                'crude_protein'          => 0.0,
                'metabolizable_energy'   => 0,
                'crude_fat'              => 0.0,
                'crude_fiber'            => 0.0,
                'calcium'                => 10.0,
                'phosphorus'             => 5.0,
                'cost_per_sack'          => null,
            ],
        ];

        foreach ($ingredients as $data) {
            FeedIngredient::firstOrCreate(['name' => $data['name']], $data);
        }
    }
}
