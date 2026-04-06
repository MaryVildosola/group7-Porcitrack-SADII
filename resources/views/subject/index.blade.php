@extends('layouts.master')
@section('title', 'Analytics & Reports')

@section('contents')
<style>
/* Custom Analytics Layout */
.analytics-container {
    padding: 16px 32px 32px 32px;
    max-width: 1400px;
    margin: 0 auto;
}
.page-header { margin-bottom: 32px; }
.page-title { font-size: 1.5rem; font-weight: 700; color: #111827; margin-bottom: 4px; }
.page-subtitle { color: #6b7280; font-size: 0.875rem; }

/* KPI Grid */
.kpi-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 24px;
    margin-bottom: 32px;
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
    font-size: 0.85rem;
    margin-bottom: 16px;
}
.kpi-value { font-size: 1.5rem; font-weight: 700; color: #111827; margin-bottom: 4px; }
.kpi-subtext { font-size: 0.75rem; color: #9ca3af; }
.trend-up { color: #22c55e; display: inline-flex; align-items: center; gap: 4px; }
.trend-down { color: #ef4444; display: inline-flex; align-items: center; gap: 4px; }

/* Tabbed Interface */
.analytics-tabs {
    display: flex;
    gap: 8px;
    margin-bottom: 24px;
    background: #f1f5f9;
    padding: 4px;
    border-radius: 10px;
    width: fit-content;
}
.tab-btn {
    padding: 8px 16px;
    font-size: 0.875rem;
    font-weight: 600;
    color: #64748b;
    border: none;
    background: transparent;
    border-radius: 8px;
    cursor: pointer;
}
.tab-btn.active {
    background: #ffffff;
    color: #111827;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

/* Charts Grid */
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
.chart-title { font-weight: 600; color: #374151; margin-bottom: 8px; }
.chart-subtitle { color: #9ca3af; font-size: 0.85rem; margin-bottom: 24px; }

/* CSS-based Bar Chart Placeholder */
.bar-chart-container {
    display: flex;
    align-items: flex-end;
    justify-content: space-around;
    height: 200px;
    padding-top: 20px;
}
.bar-wrapper { display: flex; flex-direction: column; align-items: center; gap: 8px; width: 40px; }
.bar { width: 100%; border-radius: 4px 4px 0 0; position: relative; background: #22c55e; }
.bar-label { font-size: 0.7rem; color: #6b7280; }
</style>

<div class="analytics-container">
    <div class="page-header">
        <h1 class="page-title">Analytics & Reports</h1>
        <p class="page-subtitle">Comprehensive insights and performance metrics</p>
    </div>

    <!-- KPIs -->
    <div class="kpi-grid">
        <div class="farm-card">
            <div class="kpi-header">
                <span>Total Costs (MTD)</span>
                <i class="bx bx-dollar text-green-500"></i>
            </div>
            <div class="kpi-value">₱1,100,000</div>
            <div class="kpi-subtext">Month to date expenses</div>
        </div>

        <div class="farm-card">
            <div class="kpi-header">
                <span>Avg Feed Cost/Day</span>
                <i class="bx bx-trending-up text-green-500"></i>
            </div>
            <div class="kpi-value">₱20,179</div>
            <div class="kpi-subtext trend-up">Within budget range</div>
        </div>

        <div class="farm-card">
            <div class="kpi-header">
                <span>Current Sick Pigs</span>
                <i class="bx bx-pulse text-red-500"></i>
            </div>
            <div class="kpi-value">10</div>
            <div class="kpi-subtext trend-down">
                <i class="bx bx-down-arrow-alt"></i> 44.4% vs last month
            </div>
        </div>

        <div class="farm-card">
            <div class="kpi-header">
                <span>Recovery Rate</span>
                <i class="bx bx-health text-green-500"></i>
            </div>
            <div class="kpi-value">83%</div>
            <div class="kpi-subtext">Last 30 days</div>
        </div>
    </div>

    <!-- Tabs -->
    <div class="analytics-tabs">
        <button class="tab-btn active">Cost Analysis</button>
        <button class="tab-btn">Health Metrics</button>
        <button class="tab-btn">Performance</button>
    </div>

    <!-- Charts -->
    <div class="charts-grid">
        <!-- Feed Cost Trends -->
        <div class="chart-card">
            <h3 class="chart-title">Feed Cost Trends</h3>
            <p class="chart-subtitle">Daily feed expenses vs budget (Last 30 days)</p>
            <!-- Simulated Line Chart with SVG -->
            <div style="height: 200px; width: 100%; display: flex; align-items: center; justify-content: center; position: relative;">
                <svg viewBox="0 0 500 200" width="100%" height="100%">
                    <!-- Grid Lines -->
                    <line x1="0" y1="0" x2="500" y2="0" stroke="#f3f4f6" stroke-width="1"/>
                    <line x1="0" y1="50" x2="500" y2="50" stroke="#f3f4f6" stroke-width="1"/>
                    <line x1="0" y1="100" x2="500" y2="100" stroke="#f3f4f6" stroke-width="1"/>
                    <line x1="0" y1="150" x2="500" y2="150" stroke="#f3f4f6" stroke-width="1"/>
                    <line x1="0" y1="200" x2="500" y2="200" stroke="#f3f4f6" stroke-width="1"/>
                    
                    <!-- Budget Line (Dashed) -->
                    <polyline fill="none" stroke="#94a3b8" stroke-width="2" stroke-dasharray="4,4" 
                        points="0,60 50,65 100,55 150,60 200,60 250,55 300,60 350,65 400,60 450,55 500,60" />
                    
                    <!-- Actual Line (Green with dots) -->
                    <polyline fill="none" stroke="#22c55e" stroke-width="3" 
                        points="0,80 50,75 100,85 150,80 200,70 250,75 300,82 350,78 400,65 450,70 500,65" />
                    
                    <!-- Nodes -->
                    <circle cx="200" cy="70" r="4" fill="#22c55e"/>
                    <circle cx="400" cy="65" r="4" fill="#22c55e"/>
                </svg>
            </div>
            <div class="flex justify-center gap-8 mt-4 text-[0.7rem] text-gray-500">
                <span class="flex items-center gap-2"><div style="width:12px; height:2px; background:#22c55e;"></div> Actual Cost</span>
                <span class="flex items-center gap-2"><div style="width:12px; height:2px; border-bottom:2px dashed #94a3b8;"></div> Budget</span>
            </div>
        </div>

        <!-- Cost Breakdown -->
        <div class="chart-card">
            <h3 class="chart-title">Cost Breakdown</h3>
            <p class="chart-subtitle">Monthly expense distribution</p>
            <div class="bar-chart-container">
                <div class="bar-wrapper">
                    <div class="bar" style="height: 85%;"></div>
                    <span class="bar-label">Feed</span>
                </div>
                <div class="bar-wrapper">
                    <div class="bar" style="height: 45%;"></div>
                    <span class="bar-label">Labor</span>
                </div>
                <div class="bar-wrapper">
                    <div class="bar" style="height: 35%;"></div>
                    <span class="bar-label">Veterinary</span>
                </div>
                <div class="bar-wrapper">
                    <div class="bar" style="height: 20%;"></div>
                    <span class="bar-label">Utilities</span>
                </div>
                <div class="bar-wrapper">
                    <div class="bar" style="height: 15%;"></div>
                    <span class="bar-label">Maint.</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
