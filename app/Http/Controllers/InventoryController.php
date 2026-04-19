<?php

namespace App\Http\Controllers;

use App\Models\FeedDelivery;
use App\Models\FeedConsumption;
use App\Models\Pen;
use App\Models\User;
use App\Notifications\FeedStockLow;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $period = $request->get('period', 'all');
        $selectedCategory = $request->get('category', 'all');
        
        // Comprehensive Supply List for a Large Piggery
        $inventoryGroups = [
            'Feeds' => ['Pre-Starter Feed', 'Starter Feed', 'Grower Mix', 'Finisher Feed', 'Gestation Feed', 'Lactation Feed'],
            'Medicine' => ['Piglet Vaccines', 'Dewormer', 'Vitamins & Boosters', 'Antibiotics'],
            'Sanitation' => ['Farm Disinfectant', 'Industrial Soap', 'Rodent Control']
        ];

        $stockSummary = [];
        $currentGroups = ($selectedCategory === 'all') ? $inventoryGroups : [$selectedCategory => $inventoryGroups[$selectedCategory] ?? []];

        foreach ($currentGroups as $catName => $items) {
            foreach ($items as $type) {
                $delivered = FeedDelivery::where('feed_type', $type)->sum('quantity');
                $consumed = FeedConsumption::where('feed_type', $type)->sum('quantity');
                $available = $delivered - $consumed;
                
                $stockSummary[] = (object) [
                    'name' => $type,
                    'category' => $catName,
                    'total_in' => $delivered,
                    'current' => $available,
                    'status' => $available <= 10 ? 'CRITICAL' : ($available <= 25 ? 'MODERATE' : 'HEALTHY'),
                    'color' => $available <= 10 ? '#ef4444' : ($available <= 25 ? '#f59e0b' : '#22c55e')
                ];
            }
        }

        $totalDelivered = FeedDelivery::sum('quantity');
        $totalConsumed = FeedConsumption::sum('quantity');
        $availableStock = $totalDelivered - $totalConsumed;
        
        // Priority Sorting: Critical at the top
        usort($stockSummary, function($a, $b) {
            $priority = ['CRITICAL' => 1, 'MODERATE' => 2, 'HEALTHY' => 3];
            return $priority[$a->status] <=> $priority[$b->status];
        });

        $query = FeedConsumption::query();
        if ($period === 'week') {
            $query->where('consumption_date', '>=', now()->subDays(7));
        } elseif ($period === 'month') {
            $query->where('consumption_date', '>=', now()->subDays(30));
        }
        $filteredConsumed = $query->sum('quantity');
        
        $deliveries = FeedDelivery::latest()->limit(5)->get();
        $lowStock = $availableStock <= 10;

        return view('admin.feed-stock.index', compact(
            'stockSummary', 'totalDelivered', 'totalConsumed', 'availableStock', 
            'filteredConsumed', 'deliveries', 'period', 'lowStock', 'selectedCategory'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'delivery_date' => 'required|date',
            'quantity' => 'required|integer|min:1',
            'feed_type' => 'required|string',
        ]);

        FeedDelivery::create($validated);

        return redirect()->route('admin.feed-stock.index')->with('success', 'Stock successfully recorded.');
    }

    public function qrGenerator()
    {
        $pens = Pen::orderBy('name')->get();

        return view('admin.qr.index', [
            'pens' => $pens,
        ]);
    }
}
