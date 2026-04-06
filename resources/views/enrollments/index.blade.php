@extends('layouts.master')
@section('title', 'Inventory Management')

@section('contents')
<style>
/* Custom Layout Styles for exact Farm Admin match */
.farm-content {
    padding: 32px;
    max-width: 1400px;
    margin: 0 auto;
}
.farm-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #111827;
    margin-bottom: 4px;
}
.farm-subtitle {
    color: #6b7280;
    font-size: 0.875rem;
}
.kpi-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 24px;
    margin-top: 24px;
    margin-bottom: 24px;
}
.farm-card {
    background: #ffffff;
    border-radius: 12px;
    border: 1px solid #e5e7eb;
    padding: 24px;
}
.kpi-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    color: #6b7280;
    font-size: 0.875rem;
    margin-bottom: 16px;
}
.kpi-icon-green { color: #22c55e; font-size: 1.1rem; }
.kpi-icon-red { color: #ef4444; font-size: 1.1rem; }
.kpi-value {
    font-size: 1.5rem;
    font-weight: 700;
    color: #111827;
    margin-bottom: 4px;
}
.kpi-desc {
    font-size: 0.75rem;
    color: #9ca3af;
}

/* Table Card */
.table-card {
    background: #ffffff;
    border-radius: 16px;
    border: 1px solid #e5e7eb;
    padding: 24px;
}
.table-card-header {
    margin-bottom: 24px;
}
.table-card-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: #374151;
    margin-bottom: 4px;
}

/* Data Table */
.farm-table {
    width: 100%;
    border-collapse: collapse;
}
.farm-table th {
    text-align: left;
    color: #6b7280;
    font-weight: 500;
    font-size: 0.875rem;
    padding: 12px 16px;
    border-bottom: 1px solid #f3f4f6;
}
.farm-table td {
    padding: 16px;
    font-size: 0.875rem;
    color: #374151;
    border-bottom: 1px solid #f3f4f6;
    vertical-align: middle;
}
.farm-table tr:last-child td {
    border-bottom: none;
}

/* Badges */
.badge-ok {
    background: #dcfce7;
    color: #16a34a;
    border: 1px solid #bbf7d0;
    padding: 2px 10px;
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 600;
}
.badge-low {
    background: #fee2e2;
    color: #dc2626;
    border: 1px solid #fecaca;
    padding: 2px 10px;
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 600;
}

/* Action Button */
.btn-restock {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: #22c55e;
    color: #ffffff;
    border: none;
    padding: 6px 14px;
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.2s;
}
.btn-restock:hover {
    background: #16a34a;
}
.btn-restock i {
    font-size: 0.8rem;
}
</style>

<div class="farm-content">
    <div class="mb-8">
        <h1 class="farm-title">Inventory Management</h1>
        <p class="farm-subtitle">Track and manage feed stock levels</p>
    </div>

    <!-- KPIs -->
    <div class="kpi-grid">
        <div class="farm-card">
            <div class="kpi-header">
                <span>Total Items</span>
                <i class="bx bx-cube kpi-icon-green"></i>
            </div>
            <div class="kpi-value">6</div>
            <div class="kpi-desc">Feed types tracked</div>
        </div>

        <div class="farm-card">
            <div class="kpi-header">
                <span>Low Stock Items</span>
                <i class="bx bx-error-circle kpi-icon-red"></i>
            </div>
            <div class="kpi-value">3</div>
            <div class="kpi-desc">Need immediate restocking</div>
        </div>

        <div class="farm-card">
            <div class="kpi-header">
                <span>Total Stock</span>
                <i class="bx bx-check-circle kpi-icon-green"></i>
            </div>
            <div class="kpi-value">5,975 kg</div>
            <div class="kpi-desc">Across all feed types</div>
        </div>
    </div>

    <!-- Table Section -->
    <div class="table-card">
        <div class="table-card-header">
            <div class="table-card-title">Stock Overview</div>
            <p class="farm-subtitle">Current inventory levels and restock management</p>
        </div>

        <table class="farm-table">
            <thead>
                <tr>
                    <th>Feed Type</th>
                    <th>Category</th>
                    <th>Stock Quantity</th>
                    <th>Min. Threshold</th>
                    <th>Status</th>
                    <th>Last Restocked</th>
                    <th>Supplier</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="font-weight: 500;">Starter Feed</td>
                    <td>Piglet</td>
                    <td style="font-weight: 500;">1,200 kg</td>
                    <td style="color:#6b7280;">500 kg</td>
                    <td><span class="badge-ok">OK</span></td>
                    <td style="color:#6b7280;">2026-02-01</td>
                    <td style="color:#6b7280;">AgriSupply Co.</td>
                    <td><button class="btn-restock"><i class="bx bx-refresh"></i> Restock</button></td>
                </tr>
                <tr>
                    <td style="font-weight: 500;">Grower Mix</td>
                    <td>Growing</td>
                    <td style="font-weight: 500;">350 kg</td>
                    <td style="color:#6b7280;">800 kg</td>
                    <td><span class="badge-low">LOW</span></td>
                    <td style="color:#6b7280;">2026-01-28</td>
                    <td style="color:#6b7280;">FarmFeed Ltd.</td>
                    <td><button class="btn-restock"><i class="bx bx-refresh"></i> Restock</button></td>
                </tr>
                <tr>
                    <td style="font-weight: 500;">Finisher Feed</td>
                    <td>Finishing</td>
                    <td style="font-weight: 500;">2,500 kg</td>
                    <td style="color:#6b7280;">1,000 kg</td>
                    <td><span class="badge-ok">OK</span></td>
                    <td style="color:#6b7280;">2026-02-03</td>
                    <td style="color:#6b7280;">AgriSupply Co.</td>
                    <td><button class="btn-restock"><i class="bx bx-refresh"></i> Restock</button></td>
                </tr>
                <tr>
                    <td style="font-weight: 500;">Protein Supplement</td>
                    <td>Supplement</td>
                    <td style="font-weight: 500;">80 kg</td>
                    <td style="color:#6b7280;">150 kg</td>
                    <td><span class="badge-low">LOW</span></td>
                    <td style="color:#6b7280;">2026-01-25</td>
                    <td style="color:#6b7280;">NutriPig Inc.</td>
                    <td><button class="btn-restock"><i class="bx bx-refresh"></i> Restock</button></td>
                </tr>
                <tr>
                    <td style="font-weight: 500;">Sow Lactation Feed</td>
                    <td>Breeding</td>
                    <td style="font-weight: 500;">1,800 kg</td>
                    <td style="color:#6b7280;">600 kg</td>
                    <td><span class="badge-ok">OK</span></td>
                    <td style="color:#6b7280;">2026-02-02</td>
                    <td style="color:#6b7280;">FarmFeed Ltd.</td>
                    <td><button class="btn-restock"><i class="bx bx-refresh"></i> Restock</button></td>
                </tr>
                <tr>
                    <td style="font-weight: 500;">Vitamin Mix</td>
                    <td>Supplement</td>
                    <td style="font-weight: 500;">45 kg</td>
                    <td style="color:#6b7280;">100 kg</td>
                    <td><span class="badge-low">LOW</span></td>
                    <td style="color:#6b7280;">2026-01-30</td>
                    <td style="color:#6b7280;">NutriPig Inc.</td>
                    <td><button class="btn-restock"><i class="bx bx-refresh"></i> Restock</button></td>
                </tr>
            </tbody>
        </table>
    </div>

</div>
@endsection
