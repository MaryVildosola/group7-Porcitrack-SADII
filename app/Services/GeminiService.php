<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiService
{
    protected $apiKey;
    protected $apiUrl = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-flash-latest:generateContent';

    public function __construct()
    {
        $this->apiKey = config('services.gemini.key');
    }

    public function getRegionalSwineStatus($region = 'Philippines')
    {
        if (!$this->apiKey) {
            return ['error' => 'Gemini API Key not configured.'];
        }

        $date = now()->format('F j, Y');
        $prompt = "You are an advanced Biosecurity Intelligence AI connected to the internet. As of {$date}, provide a highly specific, real-time localized swine disease threat assessment for the region of {$region}. 
        Do NOT just return generic diseases. You MUST search your internet training data and tailor the diseases, distances, and descriptions specifically for {$region}. If the location changes, your data must completely change to reflect the new area.
        
        Return ONLY a JSON array of 2 to 4 objects representing current local threats. Each object must have these exact keys:
        - name: (The name of the disease, e.g., 'ASF', 'PED', 'PRRS', 'Classical Swine Fever')
        - level: (High, Medium, or Low)
        - distance: (Be very specific to {$region}. e.g., 'Spotted in neighboring barangay', 'Reported in a commercial farm 5km away', 'Isolated case in the province border')
        - trend: (spreading, stable, or decreasing)
        - symptoms: (Key clinical signs to watch for, e.g., 'High fever, hemorrhagic lesions')
        - vector: (Primary transmission route locally, e.g., 'Contaminated feed transport', 'Wild boars', 'Human fomites')
        - action_required: (One specific, actionable biosecurity step, e.g., 'Suspend all pig movements and enforce tire baths')
        
        Example format:
        [
            {
                \"name\": \"African Swine Fever (ASF)\", 
                \"level\": \"High\", 
                \"distance\": \"Reported in a backyard farm 3km east of the city center\", 
                \"trend\": \"spreading\",
                \"symptoms\": \"High fever, blueing of ears and snout\",
                \"vector\": \"Contaminated meat smuggling / Human fomites\",
                \"action_required\": \"Enforce strict 24-hour lockdown on incoming vehicles\"
            }
        ]
        
        Do not include any other text, markdown formatting, or explanation. Just the raw JSON array.";

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post($this->apiUrl . '?key=' . $this->apiKey, [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt]
                        ]
                    ]
                ]
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $text = $data['candidates'][0]['content']['parts'][0]['text'] ?? '[]';
                
                // Clean the response in case Gemini adds markdown backticks
                $cleanJson = trim(str_replace(['```json', '```'], '', $text));
                
                return json_decode($cleanJson, true) ?: [];
            }

            Log::error('Gemini API Error: ' . $response->body());
            return ['error' => 'Failed to reach Gemini API.'];
        } catch (\Exception $e) {
            Log::error('Gemini Service Exception: ' . $e->getMessage());
            return ['error' => 'An error occurred while syncing with AI.'];
        }
    }
}
