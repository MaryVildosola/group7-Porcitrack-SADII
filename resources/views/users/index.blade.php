@extends('layouts.master')
@section('title', 'Pens & Pigs Report')

@section('contents')
<style>
/* Custom Styles for Pens & Pigs Dashboard */
.pens-pigs-container {
    padding: 32px;
    max-width: 1400px;
    margin: 0 auto;
}
.page-header {
    margin-bottom: 24px;
}
.page-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #111827;
    margin-bottom: 4px;
}
.page-subtitle {
    color: #6b7280;
    font-size: 0.875rem;
}

/* Grid Layout */
.pens-grid {
    display: grid;
    grid-template-columns: 1.2fr 0.8fr;
    gap: 32px;
}

/* Pen Card List */
.pens-list {
    display: flex;
    flex-direction: column;
    gap: 16px;
}
.pen-card {
    background: #ffffff;
    border: 1px solid #e5e7eb;
    border-radius: 16px;
    padding: 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    cursor: pointer;
    transition: all 0.2s;
}
.pen-card:hover {
    border-color: #22c55e;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
}
.pen-card.active {
    border-color: #22c55e;
    box-shadow: 0 0 0 1px #22c55e;
}

/* Badges */
.badge-fair { background: #fef9c3; color: #a16207; padding: 2px 8px; border-radius: 9999px; font-size: 0.7rem; font-weight: 600; }
.badge-excellent { background: #dcfce7; color: #15803d; padding: 2px 8px; border-radius: 9999px; font-size: 0.7rem; font-weight: 600; }
.badge-poor { background: #fee2e2; color: #dc2626; padding: 2px 8px; border-radius: 9999px; font-size: 0.7rem; font-weight: 600; }
.badge-good { background: #f0fdf4; color: #16a34a; padding: 2px 8px; border-radius: 9999px; font-size: 0.7rem; font-weight: 600; }

.pen-info { display: flex; flex-direction: column; gap: 4px; }
.pen-name-row { display: flex; align-items: center; gap: 8px; }
.pen-name { font-weight: 700; color: #111827; }

.pen-stats-row {
    display: flex;
    gap: 24px;
    margin-top: 12px;
}
.stat-item { display: flex; flex-direction: column; }
.stat-label { color: #9ca3af; font-size: 0.75rem; }
.stat-value { font-weight: 600; color: #4b5563; font-size: 0.85rem; }
.stat-value.danger { color: #ef4444; }

.pen-chevron { color: #d1d5db; }

/* Details Panel */
.details-panel {
    background: #ffffff;
    border: 1px solid #e5e7eb;
    border-radius: 20px;
    padding: 32px;
    height: fit-content;
    position: sticky;
    top: 32px;
}
.details-header { margin-bottom: 24px; }
.details-title { font-size: 1.25rem; font-weight: 700; color: #111827; mb-1; }
.details-section { margin-top: 24px; }
.section-label { font-size: 0.85rem; font-weight: 600; color: #374151; display: flex; align-items: center; gap: 8px; margin-bottom: 12px; }

/* Health Blocks */
.health-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
.health-card { border-radius: 12px; padding: 16px; }
.health-card.healthy { background: #f0fdf4; }
.health-card.sick { background: #fef2f2; }
.health-label { font-size: 0.75rem; color: #6b7280; margin-bottom: 4px; }
.health-value { font-size: 1.25rem; font-weight: 700; }
.health-card.healthy .health-value { color: #16a34a; }
.health-card.sick .health-value { color: #dc2626; }

/* Progress Bar */
.progress-container { margin-top: 8px; }
.progress-bar-bg { background: #f3f4f6; height: 8px; border-radius: 4px; width: 100%; overflow: hidden; }
.progress-bar-fill { background: #22c55e; height: 100%; border-radius: 4px; }
.progress-meta { display: flex; justify-content: center; font-size: 0.75rem; color: #6b7280; margin-top: 8px; }

/* Financial Table */
.financial-row { display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #f3f4f6; font-size: 0.875rem; }
.financial-row:last-child { border-bottom: none; }
.financial-label { color: #6b7280; }
.financial-value { font-weight: 600; color: #111827; }
.financial-value.success { color: #16a34a; }

.btn-report {
    width: 100%;
    background: #22c55e;
    color: white;
    border: none;
    padding: 14px;
    border-radius: 12px;
    font-weight: 600;
    margin-top: 32px;
    cursor: pointer;
    transition: background 0.2s;
}
.btn-report:hover { background: #16a34a; }
</style>

<div class="pens-pigs-container">
    <div class="page-header">
        <h1 class="page-title">Pens & Pigs Report</h1>
        <p class="page-subtitle">Track batch performance and profitability</p>
    </div>

    <div class="pens-grid">
        <!-- List side -->
        <div class="pens-list">
            <!-- Pen A1 -->
            <div class="pen-card active">
                <div class="pen-info">
                    <div class="pen-name-row">
                        <span class="pen-name">Pen A1</span>
                        <span class="badge-fair">Fair</span>
                    </div>
                    <div class="pen-stats-row">
                        <div class="stat-item">
                            <span class="stat-label">Total Pigs</span>
                            <span class="stat-value">48</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">Sick Pigs</span>
                            <span class="stat-value danger">3</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">Avg Weight</span>
                            <span class="stat-value">65 kg</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">Progress</span>
                            <span class="stat-value">59%</span>
                        </div>
                    </div>
                </div>
                <i class="bx bx-chevron-right pen-chevron"></i>
            </div>

            <!-- Pen A2 -->
            <div class="pen-card">
                <div class="pen-info">
                    <div class="pen-name-row">
                        <span class="pen-name">Pen A2</span>
                        <span class="badge-excellent">Excellent</span>
                    </div>
                    <div class="pen-stats-row">
                        <div class="stat-item">
                            <span class="stat-label">Total Pigs</span>
                            <span class="stat-value">48</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">Sick Pigs</span>
                            <span class="stat-value">0</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">Avg Weight</span>
                            <span class="stat-value">72 kg</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">Progress</span>
                            <span class="stat-value">65%</span>
                        </div>
      