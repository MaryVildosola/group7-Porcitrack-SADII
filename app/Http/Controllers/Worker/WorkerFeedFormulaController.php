<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;
use App\Models\FeedFormula;

class WorkerFeedFormulaController extends Controller
{
    // NRC-based nutrient requirements per life stage
    private const REQUIREMENTS = [
        'starter'  => ['cp' => 20.0, 'me' => 3265, 'fat_min' => 3.0, 'fat_max' => 5.0, 'fiber_max' => 4.0, 'ca' => 0.80, 'p' => 0.65],
        'grower'   => ['cp' => 16.0, 'me' => 3265, 'fat_min' => 3.0, 'fat_max' => 5.0, 'fiber_max' => 5.0, 'ca' => 0.60, 'p' => 0.55],
        'finisher' => ['cp' => 14.0, 'me' => 3265, 'fat_min' => 3.0, 'fat_max' => 5.0, 'fiber_max' => 6.0, 'ca' => 0.50, 'p' => 0.45],
        'breeder'  => ['cp' => 15.0, 'me' => 3000, 'fat_min' => 3.0, 'fat_max' => 5.0, 'fiber_max' => 8.0, 'ca' => 0.85, 'p' => 0.70],
    ];

    private const KG_PER_SACK = 50;

    public function index()
    {
        $formulas = FeedFormula::with('formulaIngredients.ingredient')
            ->orderByDesc('created_at')
            ->get()
            ->map(function ($formula) {
                $nutrients  = $this->computeNutrients($formula);
                $req        = self::REQUIREMENTS[$formula->life_stage] ?? [];
                $checks     = $this->checkRequirements($nutrients, $req);
                $formula->nutrient_summary = $nutrients;
                $formula->requirement      = $req;
                $formula->all_pass         = !empty($checks) && !in_array(false, $checks);
                return $formula;
            });

        // Build a plain PHP array safe for @json() in Blade (no closures inside)
        $formulasData = [];
        foreach ($formulas as $formula) {
            $ingredients = [];
            foreach ($formula->formulaIngredients as $item) {
                $ingredients[] = [
                    'name'  => $item->ingredient->name,
                    'sacks' => $item->quantity_sacks,
                    'kg'    => $item->quantity_sacks * self::KG_PER_SACK,
                    'pct'   => $formula->total_batch_sacks > 0
                        ? round($item->quantity_sacks / $formula->total_batch_sacks * 100, 1)
                        : 0,
                ];
            }

            $formulasData[] = [
                'id'           => $formula->id,
                'name'         => $formula->name,
                'life_stage'   => $formula->life_stage,
                'total_sacks'  => $formula->total_batch_sacks,
                'all_pass'     => $formula->all_pass,
                'notes'        => $formula->notes,
                'nutrients'    => $formula->nutrient_summary,
                'requirements' => $formula->requirement,
                'ingredients'  => $ingredients,
            ];
        }

        return view('worker.feed-formulas', compact('formulas', 'formulasData'));
    }

    private function computeNutrients(FeedFormula $formula): array
    {
        $totalKg = $formula->total_batch_sacks * self::KG_PER_SACK;

        if ($totalKg == 0) {
            return ['cp' => 0, 'me' => 0, 'fat' => 0, 'fiber' => 0, 'ca' => 0, 'p' => 0];
        }

        $sumCP = $sumME = $sumFat = $sumFiber = $sumCa = $sumP = 0;

        foreach ($formula->formulaIngredients as $item) {
            $kg  = $item->quantity_sacks * self::KG_PER_SACK;
            $ing = $item->ingredient;
            $sumCP    += $ing->crude_protein          * $kg;
            $sumME    += $ing->metabolizable_energy   * $kg;
            $sumFat   += $ing->crude_fat              * $kg;
            $sumFiber += $ing->crude_fiber            * $kg;
            $sumCa    += $ing->calcium                * $kg;
            $sumP     += $ing->phosphorus             * $kg;
        }

        return [
            'cp'    => round($sumCP    / $totalKg, 2),
            'me'    => round($sumME    / $totalKg, 1),
            'fat'   => round($sumFat   / $totalKg, 2),
            'fiber' => round($sumFiber / $totalKg, 2),
            'ca'    => round($sumCa    / $totalKg, 3),
            'p'     => round($sumP     / $totalKg, 3),
        ];
    }

    private function checkRequirements(array $nutrients, array $req): array
    {
        if (empty($nutrients) || empty($req)) return [];

        return [
            'cp'    => $nutrients['cp']    >= $req['cp'],
            'me'    => $nutrients['me']    >= $req['me'],
            'fat'   => $nutrients['fat']   >= $req['fat_min'] && $nutrients['fat'] <= $req['fat_max'],
            'fiber' => $nutrients['fiber'] <= $req['fiber_max'],
            'ca'    => $nutrients['ca']    >= $req['ca'],
            'p'     => $nutrients['p']     >= $req['p'],
        ];
    }
}
