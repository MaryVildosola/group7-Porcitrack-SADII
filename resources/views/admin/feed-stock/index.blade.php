@extends('layouts.master')
@section('contents')
<style>
/* Integration of Original Inventory Aesthetic */
.farm-content { padding: 20px 32px 32px 32px; max-width: 1400px; margin: 0 auto; }
.farm-title { font-size: 1.5rem; font-weight: 800; color: #1e293b; margin-bottom: 4px; }
.farm-subtitle { color: #64748b; font-size: 0.875rem; }

.kpi-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 24px; margin: 24px 0; }
.farm-card { background: #ffffff; border-radius: 16px; border: 1px solid #e2e8f0; padding: 24px; transition: all 0.3s; }
.farm-card:hover { border-color: #22c55e; box-shadow: 0 10px 20px rgba(0,0,0,0.02); }
.kpi-header { display: flex; justify-content: space-between; align-items: flex-start; color: #64748b; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; margin-bottom: 16px; }
.kpi-value { font-size: 1.75rem; font-weight: 800; color: #1e293b; margin-bottom: 4px; }
.kpi-icon { width: 36px; height: 36px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; }

/* Hybrid Filter Tabs */
.filter-tabs { display: flex; background: #f1f5f9; padding: 4px; border-radius: 12px; gap: 4px; border: 1px solid #e2e8f0; }
.filter-btn { padding: 8px 16px; font-size: 0.75rem; font-weight: 700; border-radius: 10px; border: none; cursor: pointer; color: #64748b; background: transparent; text-decoration: none; transition: all 0.2s; }
.filter-btn.active { background: #22c55e; color: #fff; box-shadow: 0 4px 10px rgba(34,197,94,0.3); }

/* Table Section Integration */
.main-grid { display: grid; grid-template-columns: 1fr 360px; gap: 24px; }
.table-card { background: #ffffff; border-radius: 20px; border: 1px solid #e2e8f0; padding: 28px; }
.farm-table { width: 100%; border-collapse: collapse; }
.farm-table th { text-align: left; color: #94a3b8; font-weight: 700; font-size: 0.7rem; text-transform: uppercase; padding: 12px 16px; border-bottom: 2px solid #f8fafc; }
.farm-table td { padding: 16px; font-size: 0.85rem; color: #475569; border-bottom: 1px solid #f8fafc; }

.btn-record { background: #111827; color: #fff; border-radius: 12px; padding: 12px; width: 100%; font-weight: 700; border: none; cursor: pointer; transition: all 0.2s; }
.btn-record:hover { background: #1f2937; transform: translateY(-1px); }

/* Fix Input Fields Visibility & Consistency */
input, select, textarea {
    color: #1e293b !important;
    font-family: 'Inter', system-ui, -apple-system, sans-serif !important;
    font-size: 0.9rem !important;
    font-weight: 500 !important;
}

input::placeholder {
    color: #94a3b8 !important;
    opacity: 1;
}

select option, select optgroup {
    color: #1e293b !important;
    background-color: #ffffff !important;
    font-weight: 500 !important;
}

select optgroup {
    font-weight: 700 !important;
    color: #475569 !important;
    background: #f8fafc !important;
}

.farm-subtitle { color: #64748b; font-size: 0.875rem; font-weight: 400; }
.farm-label { display:block; font-size: 0.75rem; font-weight: 600; color: #475569; text-transform: uppercase; margin-bottom: 8px; letter-spacing: 0.025em; }
</style>

<div class="farm-content">
    <div style="display: flex; justify-content: space-between; align-items: flex-end;">
        <div>
            <h1 class="farm-title">Inventory Management</h1>
            <p class="farm-subtitle">Track and manage feed stock levels across the farm</p>
        </div>
        <div class="filter-tabs">
            <a href="?period=all" class="filter-btn {{ $period == 'all' ? 'active' : '' }}"><i class="bx bx-grid-alt"></i> ALL</a>
            <a href="?period=week" class="filter-btn {{ $period == 'week' ? 'active' : '' }}"><i class="bx bx-calendar-event"></i> LAST 7 DAYS</a>
            <a href="?period=month" class="filter-btn {{ $period == 'month' ? 'active' : '' }}"><i class="bx bx-calendar"></i> LAST 30 DAYS</a>
        </div>
    </div>

    <!-- KPI Dashboard Stats -->
    <div class="kpi-grid">
        <div class="farm-card">
            <div class="kpi-header"><span>Total Stock In</span><i class="bx bx-down-arrow-circle kpi-icon" style="color:#22c55e; background:#f0fdf4;"></i></div>
            <div class="kpi-value text-green-600">{{ number_format($totalDelivered) }}</div>
            <div style="font-size:0.7rem; color:#94a3b8;">Total sacks delivered</div>
        </div>
        <div class="farm-card">
            <div class="kpi-header"><span>@if($period == 'week') Last 7 Days @elseif($period == 'month') Last 30 Days @else All Time @endif Consumption</span><i class="bx bx-trending-up kpi-icon" style="color:#f59e0b; background:#fffbeb;"></i></div>
            <div class="kpi-value">{{ number_format($filteredConsumed) }}</div>
            <div style="font-size:0.7rem; color:#94a3b8;">Sacks registered</div>
        </div>
        <div class="farm-card" style="border-left: 5px solid {{ $availableStock <= 10 ? '#ef4444' : ($availableStock <= 25 ? '#f59e0b' : '#22c55e') }};">
            <div class="kpi-header">
                <span>Available Stock</span>
                <i class="bx bx-package kpi-icon" style="color:{{ $availableStock <= 10 ? '#ef4444' : ($availableStock <= 25 ? '#f59e0b' : '#22c55e') }}; background:{{ $availableStock <= 10 ? '#fef2f2' : ($availableStock <= 25 ? '#fffbeb' : '#f0fdf4') }};"></i>
            </div>
            <div class="kpi-value" style="color: {{ $availableStock <= 10 ? '#ef4444' : ($availableStock <= 25 ? '#f59e0b' : '#1e293b') }};">
                {{ number_format($availableStock) }}
            </div>
            <div style="font-size:0.7rem; font-weight: 700; color:{{ $availableStock <= 10 ? '#ef4444' : ($availableStock <= 25 ? '#f59e0b' : '#22c55e') }};">
                @if($availableStock <= 10) CRITICAL LOW @elseif($availableStock <= 25) MODERATE STOCK @else HEALTHY STOCK @endif
            </div>
        </div>
        <div class="farm-card">
            <div class="kpi-header"><span>Stock Health</span><i class="bx bx-tachometer kpi-icon" style="color:#6366f1; background:#eef2ff;"></i></div>
            <div style="margin-top: 10px;">
                <div style="display: flex; justify-content: space-between; font-size: 0.7rem; font-weight: 800; color: #64748b; margin-bottom: 8px;">
                    <span>USAGE</span>
                    <span>{{ $totalDelivered > 0 ? round(($availableStock / $totalDelivered) * 100) : 0 }}% LEFT</span>
                </div>
                <div style="width: 100%; height: 8px; background: #f1f5f9; border-radius: 999px; overflow: hidden;">
                    <div style="width: {{ $totalDelivered > 0 ? ($availableStock / $totalDelivered) * 100 : 0 }}%; height: 100%; background: {{ $availableStock <= 10 ? '#ef4444' : ($availableStock <= 25 ? '#f59e0b' : '#22c55e') }}; transition: width 0.5s ease;"></div>
                </div>
                <div style="margin-top: 8px; font-size: 0.65rem; color: #94a3b8;">{{ number_format($availableStock) }} / {{ number_format($totalDelivered) }} sacks total</div>
            </div>
        </div>
    </div>

    @if($lowStock)
    <div style="background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; padding: 12px 20px; border-radius: 12px; margin-bottom: 24px; font-size: 0.85rem; display: flex; align-items: center; gap: 10px;">
        <i class="bx bx-error-circle text-xl"></i>
        <span><b>Low Stock Alert:</b> Only {{ $availableStock }} sacks remaining. We recommend ordering more immediately.</span>
    </div>
    @endif

    <div class="main-grid">
        <!-- Main Stock Status Summary -->
        <div class="table-card">
            <div style="margin-bottom: 24px; display: flex; justify-content: space-between; align-items: flex-start;">
                <div>
                    <h3 style="font-size: 1.1rem; font-weight: 700; color: #1e293b;">Supply Inventory Overview</h3>
                    <p class="farm-subtitle">Monitor stock levels across all farm categories</p>
                </div>
                <!-- Category Tabs -->
                <div class="filter-tabs" style="background: #f8fafc; border: 1px solid #f1f5f9;">
                    <a href="?category=all" class="filter-btn {{ $selectedCategory == 'all' ? 'active' : '' }}">ALL</a>
                    <a href="?category=Feeds" class="filter-btn {{ $selectedCategory == 'Feeds' ? 'active' : '' }}">FEEDS</a>
                    <a href="?category=Medicine" class="filter-btn {{ $selectedCategory == 'Medicine' ? 'active' : '' }}">MEDICINE</a>
                    <a href="?category=Sanitation" class="filter-btn {{ $selectedCategory == 'Sanitation' ? 'active' : '' }}">SANITATION</a>
                </div>
            </div>
            
            <table class="farm-table">
                <thead>
                    <tr>
                        <th>Supply Name</th>
                        <th>Category</th>
                        <th>Original Intake</th>
                        <th>Current Quantity</th>
                        <th style="text-align: right;">Health Check</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($stockSummary as $item)
                        <tr>
                            <td style="font-weight: 700; color: #1e293b;">{{ $item->name }}</td>
                            <td><span style="font-size: 0.7rem; color: #94a3b8; font-weight: 700; text-transform: uppercase;">{{ $item->category }}</span></td>
                            <td>{{ number_format($item->total_in) }} Units</td>
                            <td style="font-weight: 800; color: {{ $item->color }};">{{ number_format($item->current) }} Units</td>
                            <td style="text-align: right;">
                                <span style="background: {{ $item->color }}20; color: {{ $item->color }}; padding: 4px 12px; border-radius: 999px; font-size: 0.65rem; font-weight: 800; border: 1px solid {{ $item->color }}40;">
                                    {{ $item->status }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            
            <div style="margin-top: 40px; margin-bottom: 24px; border-top: 1px solid #f1f5f9; padding-top: 32px;">
                <h3 style="font-size: 1.1rem; font-weight: 700; color: #1e293b;">Recent Delivery History</h3>
                <p class="farm-subtitle">Latest batch arrivals and logging</p>
            </div>
            
            <table class="farm-table">
                <thead>
                    <tr>
                        <th>Date Delivered</th>
                        <th>Stock Type</th>
                        <th>Quantity (Sacks)</th>
                        <th style="text-align: right;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($deliveries as $delivery)
                        <tr>
                            <td style="font-weight: 700; color: #1e293b;">{{ $delivery->delivery_date->format('M d, Y') }}</td>
                            <td><span style="background:#f1f5f9; padding:2px 8px; border-radius:6px; font-size:0.75rem;">{{ $delivery->feed_type }}</span></td>
                            <td>{{ $delivery->quantity }} Sacks</td>
                            <td style="text-align: right;"><span style="color:#22c55e; font-weight: 800; font-size: 0.7rem;">&#x2713; RECORDED</span></td>
                        </tr>
                    @empty
                        <tr><td colspan="4" style="text-align: center; padding: 60px; color: #94a3b8;">No records found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="display: flex; flex-direction: column; gap: 24px;">
            <div class="farm-card">
                <h3 style="font-size: 1rem; font-weight: 700; color: #1e293b; margin-bottom: 20px;">Add New Stocks</h3>
                <form method="POST" action="{{ route('admin.feed-stock.store') }}">
                    @csrf
                    <div style="margin-bottom: 16px;">
                        <label class="farm-label">Supply Category</label>
                        <select name="feed_type" style="width:100%; padding: 12px; border: 1px solid #e2e8f0; border-radius: 12px; font-family: inherit; background: #fff;" required>
                            <optgroup label="FEEDS">
                                <option value="Pre-Starter Feed">Pre-Starter Feed</option>
                                <option value="Starter Feed">Starter Feed</option>
                                <option value="Grower Mix">Grower Mix</option>
                                <option value="Finisher Feed">Finisher Feed</option>
                                <option value="Gestation Feed">Gestation Feed</option>
                                <option value="Lactation Feed">Lactation Feed</option>
                            </optgroup>
                            <optgroup label="MEDICINE & VACCINES">
                                <option value="Piglet Vaccines">Piglet Vaccines</option>
                                <option value="Dewormer">Dewormer</option>
                                <option value="Vitamins & Boosters">Vitamins & Boosters</option>
                                <option value="Antibiotics">Antibiotics</option>
                            </optgroup>
                            <optgroup label="SANITATION">
                                <option value="Farm Disinfectant">Farm Disinfectant</option>
                                <option value="Industrial Soap">Industrial Soap</option>
                                <option value="Rodent Control">Rodent Control</option>
                            </optgroup>
                        </select>
                    </div>
                    <div style="margin-bottom: 16px;">
                        <label class="farm-label">Delivery Date</label>
                        <input type="date" name="delivery_date" value="{{ now()->format('Y-m-d') }}" style="width:100%; padding: 12px; border: 1px solid #e2e8f0; border-radius: 12px; font-family: inherit;" required>
                    </div>
                    <div style="margin-bottom: 24px;">
                        <label class="farm-label">Number of Sacks</label>
                        <input type="number" name="quantity" placeholder="e.g. 25" style="width:100%; padding: 12px; border: 1px solid #e2e8f0; border-radius: 12px; font-family: inherit;" required>
                    </div>
                    <button type="submit" class="btn-record">Save Stock</button>
                </form>
            </div>

            <div class="farm-card" style="background: #f8fafc; border-style: dashed; border-width: 2px;">
                <h4 style="font-size: 0.8rem; font-weight: 700; color: #1e293b; margin-bottom: 12px;">Auto-Sync Enabled</h4>
                <p style="font-size: 0.75rem; color: #64748b; line-height: 1.6;">
                    Inventory stock is automatically subtracted whenever a worker completes a <b>"Feeding Task"</b> in the field.
                </p>
                <div style="margin-top: 16px; display: flex; align-items: center; gap: 8px;">
                    <div style="width: 8px; height: 8px; background: #22c55e; border-radius: 50%;"></div>
                    <span style="font-size: 0.7rem; font-weight: 700; color: #22c55e;">Live Database Link</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
