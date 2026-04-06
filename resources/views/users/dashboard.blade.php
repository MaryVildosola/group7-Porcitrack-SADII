@extends('layouts.master')
@section('contents')
<div class="main-content app-content">
    <div class="container-fluid">

        <!-- Page Header -->
        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <div>
                <h1 class="page-title fw-semibold fs-18 mb-0">Dashboard</h1>
                <p class="fs-13 text-muted mb-0 mt-1">Real-time farm monitoring and insights</p>
            </div>
        </div>

        <!-- KPI Stats Row -->
        <div class="row g-3 mb-4">

            <!-- Total Feed Cost Today -->
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12">
                <div class="card porci-stat-card" style="border-radius: 16px; border: 1px solid #e5e7eb;">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-start justify-content-between mb-2">
                            <p class="text-muted mb-0" style="font-size: 0.78rem; line-height: 1.3;">Total Feed<br>Cost Today</p>
                            <div class="porci-stat-icon" style="background: #e8f5e9; border-radius: 10px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center;">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="#2e7d32"><path d="M11.8 10.9c-2.27-.59-3-1.2-3-2.15 0-1.09 1.01-1.85 2.7-1.85 1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-1.94.42-3.5 1.68-3.5 3.61 0 2.31 1.91 3.46 4.7 4.13 2.5.6 3 1.48 3 2.41 0 .69-.49 1.79-2.7 1.79-2.06 0-2.87-.92-2.98-2.1h-2.2c.12 2.19 1.76 3.42 3.68 3.83V21h3v-2.15c1.95-.37 3.5-1.5 3.5-3.55 0-2.84-2.43-3.81-4.7-4.4z"/></svg>
                            </div>
                        </div>
                        <h3 class="fw-bold mb-0" style="font-size: 1.5rem; color: #111827;">₱21,000</h3>
                        <p class="text-success mb-0 mt-1" style="font-size: 0.75rem;">
                            <span>↑ +12% from yesterday</span>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Number of Sick Pigs -->
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12">
                <div class="card porci-stat-card" style="border-radius: 16px; border: 1px solid #e5e7eb;">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-start justify-content-between mb-2">
                            <p class="text-muted mb-0" style="font-size: 0.78rem; line-height: 1.3;">Number of Sick<br>Pigs</p>
                            <div class="porci-stat-icon" style="background: #fce4ec; border-radius: 10px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center;">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="#c62828"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 17h-2v-2h2v2zm0-4h-2V7h2v8z"/></svg>
                            </div>
                        </div>
                        <h3 class="fw-bold mb-0" style="font-size: 1.5rem; color: #111827;">10</h3>
                        <p class="text-muted mb-0 mt-1" style="font-size: 0.75rem;">5% of total population</p>
                    </div>
                </div>
            </div>

            <!-- Inventory Status -->
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12">
                <div class="card porci-stat-card" style="border-radius: 16px; border: 1px solid #e5e7eb;">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-start justify-content-between mb-2">
                            <p class="text-muted mb-0" style="font-size: 0.78rem; line-height: 1.3;">Inventory<br>Status</p>
                            <div class="porci-stat-icon" style="background: #fff8e1; border-radius: 10px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center;">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="#f57f17"><path d="M20 6h-2.18c.07-.44.18-.88.18-1.34C18 2.1 15.9 0 13.32 0c-1.41 0-2.77.62-3.66 1.68L8 3.5 6.34 1.68C5.45.62 4.09 0 2.68 0 .1 0-2 2.1-2 4.66c0 .46.11.9.18 1.34H-2v2h24V6zM2.68 2a2.66 2.66 0 012.19 2.13L8 6H2.68C1.45 6 .48 5.04.48 3.87.48 2.74 1.44 2 2.68 2zm8.66 2.13A2.66 2.66 0 0113.53 2l.01-.13a2.19 2.19 0 012.2 2.18C15.73 5.23 14.77 6 13.53 6H11.5zM4 8v12h2v-9h2v9h2V8H4zm10 0v3h-2v9h2v-9h2V8h-4z"/></svg>
                            </div>
                        </div>
                        <h3 class="fw-bold mb-0" style="font-size: 1.5rem; color: #ef6c00;">3 Low</h3>
                        <p class="text-muted mb-0 mt-1" style="font-size: 0.75rem;">2 items need restocking</p>
                    </div>
                </div>
            </div>

            <!-- Average Weight Gain -->
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12">
                <div class="card porci-stat-card" style="border-radius: 16px; border: 1px solid #e5e7eb;">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-start justify-content-between mb-2">
                            <p class="text-muted mb-0" style="font-size: 0.78rem; line-height: 1.3;">Average Weight<br>Gain</p>
                            <div class="porci-stat-icon" style="background: #e8f5e9; border-radius: 10px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center;">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="#2e7d32"><path d="M16 6l2.29 2.29-4.88 4.88-4-4L2 16.59 3.41 18l6-6 4 4 6.3-6.29L22 12V6z"/></svg>
                            </div>
                        </div>
                        <h3 class="fw-bold mb-0" style="font-size: 1.5rem; color: #111827;">0.8 kg</h3>
                        <p class="text-muted mb-0 mt-1" style="font-size: 0.75rem;">Per pig today</p>
                    </div>
                </div>
            </div>

        </div>
        <!-- End KPI Row -->

        <!-- High Priority Alerts -->
        <div class="mb-4">
            <h5 class="fw-semibold mb-3" style="font-size: 1rem; color: #111827;">High Priority Alerts</h5>

            <!-- Critical alert -->
            <div class="porci-alert porci-alert-danger mb-2 p-3" style="background: #fff5f5; border-radius: 12px; border-left: 4px solid #e53935;">
                <div class="d-flex align-items-start gap-2">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="#e53935" style="flex-shrink:0; margin-top: 2px;"><path d="M1 21h22L12 2 1 21zm12-3h-2v-2h2v2zm0-4h-2v-4h2v4z"/></svg>
                    <div>
                        <p class="fw-semibold mb-0" style="font-size: 0.85rem; color: #c62828;">Critical: Pen B1 Health Alert</p>
                        <p class="mb-0 text-muted" style="font-size: 0.8rem;">5 pigs showing symptoms. Veterinary consultation recommended.</p>
                        <p class="mb-0 text-success" style="font-size: 0.72rem; margin-top: 4px;">10 minutes ago</p>
                    </div>
                </div>
            </div>

            <!-- Warning alert -->
            <div class="porci-alert porci-alert-warning mb-2 p-3" style="background: #f9fafb; border-radius: 12px; border-left: 4px solid #9e9e9e;">
                <div class="d-flex align-items-start gap-2">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="#616161" style="flex-shrink:0; margin-top: 2px;"><path d="M1 21h22L12 2 1 21zm12-3h-2v-2h2v2zm0-4h-2v-4h2v4z"/></svg>
                    <div>
                        <p class="fw-semibold mb-0" style="font-size: 0.85rem; color: #37474f;">Feed Stock Low: Grower Mix</p>
                        <p class="mb-0 text-muted" style="font-size: 0.8rem;">Only 2 days of supply remaining. Restock immediately.</p>
                        <p class="mb-0 text-muted" style="font-size: 0.72rem; margin-top: 4px;">2 hours ago</p>
                    </div>
                </div>
            </div>

            <!-- Info alert -->
            <div class="porci-alert porci-alert-info p-3" style="background: #f9fafb; border-radius: 12px; border-left: 4px solid #9e9e9e;">
                <div class="d-flex align-items-start gap-2">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="#616161" style="flex-shrink:0; margin-top: 2px;"><path d="M1 21h22L12 2 1 21zm12-3h-2v-2h2v2zm0-4h-2v-4h2v4z"/></svg>
                    <div>
                        <p class="fw-semibold mb-0" style="font-size: 0.85rem; color: #37474f;">Temperature Alert: Pen A2</p>
                        <p class="mb-0 text-muted" style="font-size: 0.8rem;">Temperature dropped below optimal range (18°C).</p>
                        <p class="mb-0 text-muted" style="font-size: 0.72rem; margin-top: 4px;">3 hours ago</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Alerts -->

        <!-- Charts Row -->
        <div class="row g-3">

            <!-- Feed Cost Line Chart -->
            <div class="col-xl-6 col-lg-12 col-12">
                <div class="card" style="border-radius: 16px; border: 1px solid #e5e7eb;">
                    <div class="card-body p-4">
                        <h6 class="fw-semibold mb-1" style="font-size: 0.9rem; color: #111827;">Feed Cost Today</h6>
                        <p class="text-muted mb-3" style="font-size: 0.78rem;">Cumulative feed expenses throughout the day</p>
                        <canvas id="feedCostChart" height="180"></canvas>
                    </div>
                </div>
            </div>

            <!-- Pen Health Bar Chart -->
            <div class="col-xl-6 col-lg-12 col-12">
                <div class="card" style="border-radius: 16px; border: 1px solid #e5e7eb;">
                    <div class="card-body p-4">
                        <h6 class="fw-semibold mb-1" style="font-size: 0.9rem; color: #111827;">Pen Health Overview</h6>
                        <p class="text-muted mb-3" style="font-size: 0.78rem;">Healthy vs sick pigs by pen</p>
                        <canvas id="penHealthChart" height="180"></canvas>
                    </div>
                </div>
            </div>

        </div>
        <!-- End Charts -->

    </div>
</div>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
// Feed Cost Line Chart
const feedCtx = document.getElementById('feedCostChart').getContext('2d');
new Chart(feedCtx, {
    type: 'line',
    data: {
        labels: ['6 AM', '9 AM', '12 PM', '3 PM', '6 PM', 'Now'],
        datasets: [{
            label: 'Feed Cost (₱)',
            data: [5500, 8500, 11000, 13500, 17000, 21000],
            borderColor: '#4caf50',
            backgroundColor: 'rgba(76,175,80,0.08)',
            tension: 0.4,
            fill: true,
            pointBackgroundColor: '#4caf50',
            pointRadius: 5,
            pointHoverRadius: 7,
            borderWidth: 2,
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: false },
            tooltip: {
                callbacks: {
                    label: ctx => '₱' + ctx.parsed.y.toLocaleString()
                }
            }
        },
        scales: {
            x: {
                grid: { display: false },
                ticks: { font: { size: 11 }, color: '#9ca3af' }
            },
            y: {
                grid: { color: '#f3f4f6' },
                ticks: { font: { size: 11 }, color: '#9ca3af' },
                beginAtZero: true
            }
        }
    }
});

// Pen Health Bar Chart
const penCtx = document.getElementById('penHealthChart').getContext('2d');
new Chart(penCtx, {
    type: 'bar',
    data: {
        labels: ['A1', 'A2', 'B1', 'B2'],
        datasets: [
            {
                label: 'Healthy',
                data: [44, 47, 42, 48],
                backgroundColor: '#4caf50',
                borderRadius: 4,
                barThickness: 22,
            },
            {
                label: 'Sick',
                data: [3, 4, 5, 2],
                backgroundColor: '#ef5350',
                borderRadius: 4,
                barThickness: 22,
            }
        ]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'top',
                labels: { font: { size: 11 }, color: '#374151', boxWidth: 12 }
            }
        },
        scales: {
            x: {
                grid: { display: false },
                ticks: { font: { size: 11 }, color: '#9ca3af' }
            },
            y: {
                grid: { color: '#f3f4f6' },
                ticks: { font: { size: 11 }, color: '#9ca3af' },
                beginAtZero: true
            }
        }
    }
});
</script>

<style>
.porci-stat-card {
    box-shadow: 0 1px 6px rgba(0,0,0,0.05);
    transition: transform 0.15s, box-shadow 0.15s;
}
.porci-stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 16px rgba(0,0,0,0.1);
}
</style>
@endsection
