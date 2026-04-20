<?php

namespace App\Http\Controllers;

use App\Models\FeedIngredient;
use App\Http\Controllers\PigController;
use Illuminate\Http\Request;

class FeedIngredientController extends Controller
{
    public function index()
    {
        $ingredients = FeedIngredient::orderBy('name')->get();
        return view('admin.feed-mix.ingredients', compact('ingredients'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'                 => 'required|string|max:255|unique:feed_ingredients,name',
            'crude_protein'        => 'required|numeric|min:0|max:100',
            'metabolizable_energy' => 'required|numeric|min:0',
            'crude_fat'            => 'required|numeric|min:0|max:100',
            'crude_fiber'          => 'required|numeric|min:0|max:100',
            'calcium'              => 'required|numeric|min:0|max:100',
            'phosphorus'           => 'required|numeric|min:0|max:100',
            'cost_per_sack'        => 'nullable|numeric|min:0',
        ]);

        FeedIngredient::create($validated);

        return redirect()->route('admin.feed-ingredients.index')
            ->with('success', 'Ingredient "' . $validated['name'] . '" added successfully.');
    }

    public function update(Request $request, FeedIngredient $ingredient)
    {
        $validated = $request->validate([
            'name'                 => 'required|string|max:255|unique:feed_ingredients,name,' . $ingredient->id,
            'crude_protein'        => 'required|numeric|min:0|max:100',
            'metabolizable_energy' => 'required|numeric|min:0',
            'crude_fat'            => 'required|numeric|min:0|max:100',
            'crude_fiber'          => 'required|numeric|min:0|max:100',
            'calcium'              => 'required|numeric|min:0|max:100',
            'phosphorus'           => 'required|numeric|min:0|max:100',
            'cost_per_sack'        => 'nullable|numeric|min:0',
        ]);

        $ingredient->update($validated);

        return redirect()->route('admin.feed-ingredients.index')
            ->with('success', 'Ingredient updated successfully.');
    }

    public function destroy(FeedIngredient $ingredient)
    {
        $ingredient->delete();
        return redirect()->route('admin.feed-ingredients.index')
            ->with('success', 'Ingredient deleted.');
    }
}
