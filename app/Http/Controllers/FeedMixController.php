<?php

namespace App\Http\Controllers;

use App\Models\FeedFormula;
use App\Models\FeedFormulaIngredient;
use App\Models\FeedIngredient;
use Illuminate\Http\Request;

class FeedMixController extends Controller
{
    // NRC-based nutrient requirements per life stage (per kg of feed)
    private const REQUIREMENTS = [
        'starter'  => ['cp' => 20.0, 'me' => 3265, 'fat_min' => 3.0, 'fat_max' => 5.0, 'fiber_max' => 4.0, 'ca' => 0.80, 'p' => 0.65],
        'grower'   => ['cp' => 16.0, 'me' => 3265, 'fat_min' => 3.0, 'fat_max' => 5.0, 'fiber_max' => 5.0, 'ca' => 0.60, 'p' => 0.55],
        'finisher' => ['cp' => 14.0, 'me' => 3265, 'fat_min' => 3.0, 'fat_max' => 5.0, 'fiber_max' => 6.0, 'ca' => 0.50, 'p' => 0.45],
        'breeder'  => ['cp' => 15.0, 'me' => 3000, 'fat_min' => 3.0, 'fat_max' => 5.0, 'fiber_max' => 8.0, 'ca' => 0.85, 'p' => 0.70],
    ];

    private const KG_PER_SACK = 50;

    public function index()
    {
        $formulas = FeedFormula::with('creator')
            ->orderByDesc('created_at')
            ->get()
            ->map(function ($formula) {
                $nutrients = $this->computeNutrients($formula);
                $req       = self::REQUIREMENTS[$formula->life_stage] ?? null;
                $formula->nutrient_summary = $nutrients;
                $formula->meets_requirements = $req ? $this->checkRequirements($nutrients, $req) : null;
                return $formula;
            });

        return view('admin.feed-mix.index', compact('formulas'));
    }

    public function create()
    {
        $ingredients = FeedIngredient::orderBy('name')->get();
        $requirements = self::REQUIREMENTS;
        return view('admin.feed-mix.create', compact('ingredients', 'requirements'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'                    => 'required|string|max:255',
            'life_stage'              => 'required|in:starter,grower,finisher,breeder',
            'notes'                   => 'nullable|string|max:2000',
            'ingredients'             => 'required|array|min:1',
            'ingredients.*.id'        => 'required|exists:feed_ingredients,id',
            'ingredients.*.sacks'     => 'required|numeric|min:0.01',
        ]);

        $totalSacks = collect($validated['ingredients'])->sum('sacks');

        $formula = FeedFormula::create([
            'name'              => $validated['name'],
            'life_stage'        => $validated['life_stage'],
            'total_batch_sacks' => $totalSacks,
            'notes'             => $validated['notes'] ?? null,
            'created_by'        => auth()->id(),
        ]);

        foreach ($validated['ingredients'] as $row) {
            FeedFormulaIngredient::create([
                'feed_formula_id'    => $formula->id,
                'feed_ingredient_id' => $row['id'],
                'quantity_sacks'     => $row['sacks'],
            ]);
        }

        return redirect()->route('admin.feed-mix.show', $formula->id)
            ->with('success', 'Feed formula saved successfully!');
    }

    public function show(FeedFormula $feed_mix)
    {
        $formula = $feed_mix;
        $formula->load('formulaIngredients.ingredient', 'creator');
        $nutrients    = $this->computeNutrients($formula);
        $requirements = self::REQUIREMENTS[$formula->life_stage] ?? [];
        $checks       = $this->checkRequirements($nutrients, $requirements);
        $allRequirements = self::REQUIREMENTS;

        return view('admin.feed-mix.show', compact('formula', 'nutrients', 'requirements', 'checks', 'allRequirements'));
    }

    public function destroy(FeedFormula $feed_mix)
    {
        $feed_mix->formulaIngredients()->delete();
        $feed_mix->delete();

        return redirect()->route('admin.feed-mix.index')
            ->with('success', 'Formula deleted.');
    }

    // ---------------------------------------------------------------
    // Private helpers
    // ---------------------------------------------------------------

    private function computeNutrients(FeedFormula $formula): array
    {
        $formula->loadMissing('formulaIngredients.ingredient');

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
