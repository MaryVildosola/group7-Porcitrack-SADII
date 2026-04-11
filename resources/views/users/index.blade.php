@extends('layouts.master')
@section('title', 'Pens & Pigs Report')

@section('contents')
<style>
/* Custom Styles for Pens & Pigs Dashboard */
.pens-pigs-container {
    padding: 16px 32px 32px 32px;
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
                    </div>
                </div>
                <i class="bx bx-chevron-right pen-chevron"></i>
            </div>

            <!-- Pen B1 -->
            <div class="pen-card">
                <div class="pen-info">
                    <div class="pen-name-row">
                        <span class="pen-name">Pen B1</span>
                        <span class="badge-poor">Poor</span>
                    </div>
                    <div class="pen-stats-row">
                        <div class="stat-item">
                            <span class="stat-label">Total Pigs</span>
                            <span class="stat-value">47</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">Sick Pigs</span>
                            <span class="stat-value danger">5</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">Avg Weight</span>
                            <span class="stat-value">58 kg</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">Progress</span>
                            <span class="stat-value">53%</span>
                        </div>
                    </div>
                </div>
                <i class="bx bx-chevron-right pen-chevron"></i>
            </div>

            <!-- Pen B2 -->
            <div class="pen-card">
                <div class="pen-info">
                    <div class="pen-name-row">
                        <span class="pen-name">Pen B2</span>
                        <span class="badge-good">Good</span>
                    </div>
                    <div class="pen-stats-row">
                        <div class="stat-item">
                            <span class="stat-label">Total Pigs</span>
                            <span class="stat-value">52</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">Sick Pigs</span>
                            <span class="stat-value danger">2</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">Avg Weight</span>
                            <span class="stat-value">68 kg</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">Progress</span>
                            <span class="stat-value">62%</span>
                        </div>
                    </div>
                </div>
                <i class="bx bx-chevron-right pen-chevron"></i>
            </div>

            <!-- Pen C1 -->
            <div class="pen-card">
                <div class="pen-info">
                    <div class="pen-name-row">
                        <span class="pen-name">Pen C1</span>
                        <span class="badge-excellent">Excellent</span>
                    </div>
                    <div class="pen-stats-row">
                        <div class="stat-item">
                            <span class="stat-label">Total Pigs</span>
                            <span class="stat-value">45</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">Sick Pigs</span>
                            <span class="stat-value">0</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">Avg Weight</span>
                            <span class="stat-value">85 kg</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">Progress</span>
                            <span class="stat-value">77%</span>
                        </div>
                    </div>
                </div>
                <i class="bx bx-chevron-right pen-chevron"></i>
            </div>

            <!-- Pen C2 -->
            <div class="pen-card">
                <div class="pen-info">
                    <div class="pen-name-row">
                        <span class="pen-name">Pen C2</span>
                        <span class="badge-good">Good</span>
                    </div>
                    <div class="pen-stats-row">
                        <div class="stat-item">
                            <span class="stat-label">Total Pigs</span>
                            <span class="stat-value">50</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">Sick Pigs</span>
                            <span class="stat-value danger">1</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">Avg Weight</span>
                            <span class="stat-value">78 kg</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">Progress</span>
                            <span class="stat-value">71%</span>
                        </div>
                    </div>
                </div>
                <i class="bx bx-chevron-right pen-chevron"></i>
            </div>
        </div>

        <!-- Details Column -->
        <div class="details-column">
            <div class="details-panel">
                <div class="details-header">
                    <h2 class="details-title">Pen A1 Details</h2>
                    <p class="page-subtitle">Section A</p>
                </div>

                <!-- Health Status -->
                <div class="details-section">
                    <div class="section-label">
                        <i class="bx bx-error-alt"></i> Health Status
                    </div>
                    <div class="health-grid">
                        <div class="health-card healthy">
                            <div class="health-label">Healthy</div>
                            <div class="health-value">45</div>
                        </div>
                        <div class="health-card sick">
                            <div class="health-label">Sick</div>
                            <div class="health-value">3</div>
                        </div>
                    </div>
                </div>

                <!-- Weight Progress -->
                <div class="details-section">
                    <div class="section-label">
                        <i class="bx bx-line-chart"></i> Weight Progress
                    </div>
                    <div class="flex justify-between text-xs mb-2">
                        <span class="text-gray-500">Current Average</span>
                        <span class="font-bold">65 kg</span>
                    </div>
                    <div class="flex justify-between text-xs mb-4">
                        <span class="text-gray-500">Target Weight</span>
                        <span class="font-bold">110 kg</span>
                    </div>
                    <div class="progress-container">
                        <div class="progress-bar-bg">
                            <div class="progress-bar-fill" style="width: 59%;"></div>
                        </div>
                        <div class="progress-meta">59% to target</div>
                    </div>
                </div>

                <!-- Financial Overview -->
                <div class="details-section">
                    <div class="section-label">
                        <i class="bx bx-dollar"></i> Financial Overview
                    </div>
                    <div class="financial-row">
                        <span class="financial-label">Batch Cost</span>
                        <span class="financial-value">₱625,000</span>
                    </div>
                    <div class="financial-row">
                        <span class="financial-label">Feed Consumption/Day</span>
                        <span class="financial-value">145 kg</span>
                    </div>
                    <div class="financial-row">
                        <span class="financial-label">Profit Margin</span>
                        <span class="financial-value success">22%</span>
                    </div>
                </div>

                <!-- Batch Timeline -->
                <div class="details-section">
                    <div class="section-label">
                        <i class="bx bx-time-five"></i> Batch Timeline
                    </div>
                    <div class="financial-row">
                        <span class="financial-label">Start Date</span>
                        <span class="financial-value">2025-12-01</span>
                    </div>
                    <div class="financial-row">
                        <span class="financial-label">Est. Finish Date</span>
                        <span class="financial-value">2026-03-15</span>
                    </div>
                </div>

                <button class="btn-report">Generate Full Report</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // --- Report Generation Logic ---
        const reportBtn = document.querySelector('.btn-report');
        if (reportBtn) {
            reportBtn.addEventListener('click', () => {
                const penName = document.querySelector('.details-title').innerText.replace(' Details', '').trim();

                Swal.fire({
                    title: 'Generating Report...',
                    html: `Compiling health, weight, and financial data for <b>${penName}</b>. Please wait...`,
                    timer: 2000,
                    timerProgressBar: true,
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                }).then(() => {
                    Swal.fire({
                        title: 'Report Ready!',
                        text: `The comprehensive report for ${penName} has been successfully generated.`,
                        icon: 'success',
                        showCancelButton: true,
                        confirmButtonText: '<i class="bx bx-printer" style="vertical-align: middle; margin-right: 4px;"></i> Print Report',
                        cancelButtonText: '<i class="bx bx-download" style="vertical-align: middle; margin-right: 4px;"></i> Download PDF',
                        confirmButtonColor: '#22c55e',
                        cancelButtonColor: '#3b82f6',
                        customClass: {
                            confirmButton: 'shadow-sm',
                            cancelButton: 'shadow-sm'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.print();
                        } else if (result.dismiss === Swal.DismissReason.cancel) {
                            Swal.fire({
                                title: 'Downloaded',
                                text: `The PDF report for ${penName} has been securely saved to your device.`,
                                icon: 'success',
                                confirmButtonColor: '#22c55e'
                            });
                        }
                    });
                });
            });
        }

        // --- Interactive Pen Cards Logic ---
        const penDetails = {
            'Pen A1': {
                subtitle: 'Section A',
                healthy: 45, sick: 3,
                currentAvg: '65 kg', targetWeight: '110 kg', progress: 59,
                batchCost: '₱625,000', feedCons: '145 kg', profit: '22%',
                start: '2025-12-01', finish: '2026-03-15'
            },
            'Pen A2': {
                subtitle: 'Section A',
                healthy: 48, sick: 0,
                currentAvg: '72 kg', targetWeight: '110 kg', progress: 65,
                batchCost: '₱620,000', feedCons: '150 kg', profit: '25%',
                start: '2025-11-20', finish: '2026-03-05'
            },
            'Pen B1': {
                subtitle: 'Section B',
                healthy: 42, sick: 5,
                currentAvg: '58 kg', targetWeight: '110 kg', progress: 53,
                batchCost: '₱650,000', feedCons: '135 kg', profit: '15%',
                start: '2025-12-10', finish: '2026-03-25'
            },
            'Pen B2': {
                subtitle: 'Section B',
                healthy: 50, sick: 2,
                currentAvg: '68 kg', targetWeight: '110 kg', progress: 62,
                batchCost: '₱630,000', feedCons: '148 kg', profit: '20%',
                start: '2025-11-25', finish: '2026-03-10'
            },
            'Pen C1': {
                subtitle: 'Section C',
                healthy: 45, sick: 0,
                currentAvg: '85 kg', targetWeight: '110 kg', progress: 77,
                batchCost: '₱600,000', feedCons: '160 kg', profit: '28%',
                start: '2025-10-15', finish: '2026-02-01'
            },
            'Pen C2': {
                subtitle: 'Section C',
                healthy: 49, sick: 1,
                currentAvg: '78 kg', targetWeight: '110 kg', progress: 71,
                batchCost: '₱610,000', feedCons: '155 kg', profit: '24%',
                start: '2025-11-01', finish: '2026-02-15'
            }
        };

        const penCards = document.querySelectorAll('.pen-card');
        penCards.forEach(card => {
            card.addEventListener('click', () => {
                // Update active selection state visually
                penCards.forEach(c => c.classList.remove('active'));
                card.classList.add('active');

                // Retrieve clicked pen Name and Data
                const penName = card.querySelector('.pen-name').innerText.trim();
                const data = penDetails[penName];

                if (data) {
                    // 1. Update Headers
                    document.querySelector('.details-title').innerText = `${penName} Details`;
                    document.querySelector('.details-header .page-subtitle').innerText = data.subtitle;

                    // 2. Update Health Status
                    const healthValues = document.querySelectorAll('.health-grid .health-value');
                    healthValues[0].innerText = data.healthy;
                    healthValues[1].innerText = data.sick;

                    // 3. Update Weight Progress
                    const detailSections = document.querySelectorAll('.details-section');
                    const weightValues = detailSections[1].querySelectorAll('.font-bold');
                    weightValues[0].innerText = data.currentAvg;
                    weightValues[1].innerText = data.targetWeight;
                    document.querySelector('.progress-bar-fill').style.width = `${data.progress}%`;
                    document.querySelector('.progress-meta').innerText = `${data.progress}% to target`;

                    // 4. Update Financial Overview
                    const financialValues = detailSections[2].querySelectorAll('.financial-value');
                    financialValues[0].innerText = data.batchCost;
                    financialValues[1].innerText = data.feedCons;
                    financialValues[2].innerText = data.profit;

                    // 5. Update Timeline
                    const timelineValues = detailSections[3].querySelectorAll('.financial-value');
                    timelineValues[0].innerText = data.start;
                    timelineValues[1].innerText = data.finish;
                }
            });
        });
    });
</script>

@endsection
