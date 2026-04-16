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
    public function index()
    {
        $deliveries = FeedDelivery::orderByDesc('delivery_date')->get();
        $totalDelivered = FeedDelivery::sum('quantity');
        $totalConsumed = FeedConsumption::sum('quantity');
        $availableStock = max($totalDelivered - $totalConsumed, 0);
        $lowStock = $availableStock <= 10;

        if ($lowStock) {
            $admins = User::where('role', 'admin')->get();

            foreach ($admins as $admin) {
                $latest = $admin->notifications()->where('type', FeedStockLow::class)->latest()->first();

                if (! $latest || data_get($latest->data, 'available_stock') !== $availableStock) {
                    $admin->notify(new FeedStockLow($availableStock));
                }
            }
        }

        return view('admin.feed-stock.index', [
            'deliveries' => $deliveries,
            'totalDelivered' => $totalDelivered,
            'totalConsumed' => $totalConsumed,
            'availableStock' => $availableStock,
            'lowStock' => $lowStock,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'delivery_date' => 'required|date',
            'quantity' => 'required|integer|min:1',
        ]);

        FeedDelivery::create($validated);

        return redirect()->route('admin.feed-stock.index')->with('success', 'Feed delivery successfully recorded.');
    }

    public function qrGenerator()
    {
        $pens = Pen::orderBy('name')->get();

        return view('admin.qr.index', [
            'pens' => $pens,
        ]);
    }
}
