<?php

namespace App\Http\Controllers;

use App\Models\RegionalDisease;
use App\Services\GeminiService;
use Illuminate\Http\Request;

class DiseaseSyncController extends Controller
{
    protected $gemini;

    public function __construct(GeminiService $gemini)
    {
        $this->gemini = $gemini;
    }

    public function sync(Request $request)
    {
        // Get user region first
        $region = auth()->user()->region;

        // If no user region, build from system settings
        if (!$region) {
            $adm      = \App\Models\SystemSetting::get('farm_region');
            $province = \App\Models\SystemSetting::get('farm_province');
            $city     = \App\Models\SystemSetting::get('farm_city');

            if ($adm && $province) {
                // City is optional
                $region = ($city ? "{$city}, " : "") . "{$province}, {$adm}, Philippines";
            } else {
                $region = $request->get('region', 'Philippines');
            }
        }
        
        $results = $this->gemini->getRegionalSwineStatus($region);

        if (isset($results['error'])) {
            return redirect()->back()->with('error', $results['error']);
        }

        // Deactivate old threats (or we can just keep them, but let's clear them for a fresh sync)
        RegionalDisease::where('is_active', true)->update(['is_active' => false]);

        foreach ($results as $result) {
            RegionalDisease::create([
                'name' => $result['name'] ?? 'Unknown Disease',
                'level' => $result['level'] ?? 'Low',
                'distance' => $result['distance'] ?? 'Unknown',
                'trend' => $result['trend'] ?? 'stable',
                'symptoms' => $result['symptoms'] ?? 'No data',
                'vector' => $result['vector'] ?? 'Unknown',
                'action_required' => $result['action_required'] ?? 'Monitor closely',
                'is_active' => true,
            ]);
        }

        return redirect()->back()->with('success', 'Smart Engine successfully synced with real-time regional data from Gemini AI.');
    }
}
