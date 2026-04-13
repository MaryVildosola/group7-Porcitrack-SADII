@extends('layouts.master')
@section('contents')
<style>
/* Specific Overrides for Dashboard Layout */
.dashboard-wrap {
    padding: 32px;
    max-width: 1400px;
    margin: 0 auto;
}
.page-title { font-size: 1.5rem; font-weight: 700; color: #111827; margin-bottom: 4px; }
.page-subtitle { color: #6b7280; font-size: 0.875rem; margin-bottom: 32px; }

/* KPI Grid */
.kpi-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 24px;
    margin-bottom: 32px;
}
.kpi-card {
    background: #ffffff;
    border: 1px solid #e5e7eb;
    border-radius: 16px;
    padding: 24px;
}
.kpi-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 16px;
    color: #6b7280;
    font-size: 0.8rem;
}
.kpi-icon {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
}
.kpi-value { font-size: 1.5rem; font-weight: 700; color: #111827; margin-bottom: 4px; }
.kpi-meta { font-size: 0.75rem; color: #9ca3af; }
.text-success { color: #22c55e !important; }
.text-danger { color: #ef4444 !important; }
.text-warning { color: #f59e0b !important; }

/* Alerts section */
.alerts-section { margin-bottom: 32px; }
.section-title { font-size: 1.1rem; font-weight: 600; color: #111827; margin-bottom: 16px; }
.farm-alert {
    display: flex;
    gap: 12px;
    padding: 16px;
    border-radius: 12px;
    margin-bottom: 12px;
    border: 1px solid transparent;
    cursor: pointer;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.farm-alert:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
}
.farm-alert-danger { background: #fee2e2; border-color: #fecaca; color: #991b1b; }
.farm-alert-warning { background: #f1f5f9; border-color: #e2e8f0; color: #334155; }
.alert-icon { font-size: 1.2rem; margin-top: 2px; }
.alert-content h4 { font-size: 0.875rem; font-weight: 700; margin: 0 0 4px 0; }
.alert-content p { font-size: 0.8rem; margin: 0 0 6px 0; opacity: 0.8; }
.alert-time { font-size: 0.72rem; opacity: 0.6; }

/* Charts section */
.charts-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 32px;
}
.chart-card {
    background: #ffffff;
    border: 1px solid #e5e7eb;
    border-radius: 16px;
    padding: 24px;
}
.chart-header { margin-bottom: 24px; }
.chart-title { font-size: 1rem; font-weight: 600; color: #374151; margin-bottom: 4px; }
.chart-subtitle { font-size: 0.85rem; color: #9ca3af; }

/* Simulated Charts using SVGs from previous logic */
</style>

<div class="dashboard-wrap">
    <div class="header-block">
        <h1 class="page-title">Dashboard</h1>
        <p class="page-subtitle">Real-time farm monitoring and insights</p>
    </div>

    <!-- KPI cards -->
    <div class="kpi-grid">
        <div class="kpi-card">
            <div class="kpi-header">
                <span>Total Feed<br>Cost Today</span>
                <div class="kpi-icon" style="background:#f0fdf4; color:#16a34a;"><i class="bx bx-dollar-circle"></i></div>
            </div>
            <div class="kpi-value">₱21,000</div>
            <div class="kpi-meta text-success">↑ +12% from yesterday</div>
        </div>

        <div class="kpi-card">
            <div class="kpi-header">
                <span>Number of Sick<br>Pigs</span>
                <div class="kpi-icon" style="background:#fef2f2; color:#dc2626;"><i class="bx bx-pulse"></i></div>
            </div>
            <div class="kpi-value">10</div>
            <div class="kpi-meta">5% of total population</div>
        </div>

        <div class="kpi-card">
            <div class="kpi-header">
                <span>Inventory<br>Status</span>
                <div class="kpi-icon" style="background:#fffbeb; color:#d97706;"><i class="bx bx-package"></i></div>
            </div>
            <div class="kpi-value">3 Low</div>
            <div class="kpi-meta text-warning">2 items need restocking</div>
        </div>

        <div class="kpi-card">
            <div class="kpi-header">
                <span>Average Weight<br>Gain</span>
                <div class="kpi-icon" style="background:#f0fdf4; color:#16a34a;"><i class="bx bx-trending-up"></i></div>
            </div>
            <div class="kpi-value">0.8 kg</div>
            <div class="kpi-meta">Per pig today</div>
        </div>
    </div>

    <!-- Alerts Section -->
    <div class="alerts-section">
        <h3 class="section-title">High Priority Alerts</h3>
        
        <div class="farm-alert farm-alert-danger" onclick="window.location.href='{{ route('pens.index') }}?highlight=Pen B1'">
            <i class="bx bx-error-alt alert-icon"></i>
            <div class="alert-content">
                <h4>Critical: Pen B1 Health Alert</h4>
                <p>5 pigs showing symptoms. Veterinary consultation recommended.</p>
                <div class="alert-time">10 minutes ago</div>
            </div>
        </div>

        <div class="farm-alert farm-alert-warning" onclick="window.location.href='{{ route('enrollments.index') }}?highlight=Grower Mix'">
            <i class="bx bx-info-circle alert-icon text-slate-400"></i>
            <div class="alert-content">
                <h4>Feed Stock Low: Grower Mix</h4>
                <p>Only 2 days of supply remaining. Restock immediately.</p>
                <div class="alert-time">2 hours ago</div>
            </div>
        </div>

        <div class="farm-alert farm-alert-warning" onclick="window.location.href='{{ route('pens.index') }}?highlight=Pen A2'">
            <i class="bx bx-thermometer alert-icon text-slate-400"></i>
            <div class="alert-content">
                <h4>Temperature Alert: Pen A2</h4>
                <p>Temperature dropped below optimal range (18°C).</p>
                <div class="alert-time">3 hours ago</div>
            </div>
        </div>
    </div>

    <!-- Charts Grid -->
    <div class="charts-grid">
        <div class="chart-card">
            <div class="chart-header">
                <h3 class="chart-title">Feed Cost Today</h3>
                <p class="chart-subtitle">Cumulative feed expenses throughout the day</p>
            </div>
            <!-- Simulated Line Chart -->
            <div style="height: 200px; width: 100%; position: relative;">
                <svg viewBox="0 0 500 200" width="100%" height="100%">
                    <line x1="0" y1="200" x2="500" y2="200" stroke="#f3f4f6" stroke-width="1"/>
                    <line x1="0" y1="150" x2="500" y2="150" stroke="#f3f4f6" stroke-width="2" stroke-dasharray="2,2"/>
                    <line x1="0" y1="100" x2="500" y2="100" stroke="#f3f4f6" stroke-width="2" stroke-dasharray="2,2"/>
                    <line x1="0" y1="50" x2="500" y2="50" stroke="#f3f4f6" stroke-width="2" stroke-dasharray="2,2"/>
                    <polyline fill="none" stroke="#22c55e" stroke-width="3" 
                        points="0,150 70,130 140,110 210,85 280,65 350,45 420,35" />
                    <circle cx="420" cy="35" r="4" fill="#22c55e"/>
                </svg>
                <div class="flex justify-between mt-2 text-[0.65rem] text-gray-400">
                    <span>6 AM</span><span>9 AM</span><span>12 PM</span><span>3 PM</span><span>6 PM</span><span>Now</span>
                </div>
            </div>
        </div>

        <div class="chart-card">
            <div class="chart-header">
                <h3 class="chart-title">Pen Health Overview</h3>
                <p class="chart-subtitle">Healthy vs sick pigs by pen</p>
            </div>
            <!-- Simulated Bar Chart -->
            <div style="height: 200px; width: 100%; display: flex; align-items: flex-end; justify-content: space-around; padding-bottom: 20px; border-bottom: 1px solid #f3f4f6;">
                <div class="flex flex-col items-center gap-1 w-12">
                    <div class="flex gap-1 items-end h-[150px]">
                        <div class="bg-green-500 rounded-sm w-4 h-[80%]"></div>
                        <div class="bg-red-500 rounded-sm w-4 h-[10%]"></div>
                    </div>
                    <span class="text-[0.7rem] text-gray-500">A1</span>
                </div>
                <div class="flex flex-col items-center gap-1 w-12">
                    <div class="flex gap-1 items-end h-[150px]">
                        <div class="bg-green-500 rounded-sm w-4 h-[85%]"></div>
                        <div class="bg-red-500 rounded-sm w-4 h-[0%]"></div>
                    </div>
                    <span class="text-[0.7rem] text-gray-500">A2</span>
                </div>
                <div class="flex flex-col items-center gap-1 w-12">
                    <div class="flex gap-1 items-end h-[150px]">
                        <div class="bg-green-500 rounded-sm w-4 h-[75%]"></div>
                        <div class="bg-red-500 rounded-sm w-4 h-[15%]"></div>
                    </div>
                    <span class="text-[0.7rem] text-gray-500">B1</span>
                </div>
                <div class="flex flex-col items-center gap-1 w-12">
                    <div class="flex gap-1 items-end h-[150px]">
                        <div class="bg-green-500 rounded-sm w-4 h-[90%]"></div>
                        <div class="bg-red-500 rounded-sm w-4 h-[5%]"></div>
                    </div>
                    <span class="text-[0.7rem] text-gray-500">B2</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
