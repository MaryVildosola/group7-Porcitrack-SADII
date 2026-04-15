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
.btn-action-edit:hover { border-color: #22c55e !important; color: #16a34a !important; background: #f0fdf4 !important; }
.btn-action-delete:hover { border-color: #ef4444 !important; background: #fee2e2 !important; box-shadow: 0 2px 8px rgba(239, 68, 68, 0.1); }
</style>

<div class="pens-pigs-container">
    <div class="page-header" style="display: flex; justify-content: space-between; align-items: flex-end;">
        <div>
            <h1 class="page-title">Pens & Pigs Report</h1>
            <p class="page-subtitle">Track batch performance and profitability</p>
        </div>
        <button class="btn-add-pen" style="background: #111827; color: white; border: none; padding: 10px 20px; border-radius: 8px; font-weight: 600; cursor: pointer; transition: background 0.2s;">
            <i class='bx bx-plus'></i> Add Pen
        </button>
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
                <div class="details-header" style="display: flex; justify-content: space-between; align-items: flex-start;">
                    <div>
                        <h2 class="details-title">Pen A1 Details</h2>
                        <p class="page-subtitle">Section A</p>
                    </div>
                    <div style="display: flex; gap: 8px;">
                        <button onclick="editPen('Pen A1')" class="btn-action-edit" style="width: 36px; h-height: 36px; border-radius: 10px; border: 1px solid #e5e7eb; background: #fff; color: #4b5563; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s;">
                            <i class='bx bx-edit-alt' style="font-size: 1.25rem;"></i>
                        </button>
                        <button onclick="deletePen('Pen A1')" class="btn-action-delete" style="width: 36px; h-height: 36px; border-radius: 10px; border: 1px solid #fee2e2; background: #fef2f2; color: #dc2626; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s;">
                            <i class='bx bx-trash' style="font-size: 1.25rem;"></i>
                        </button>
                    </div>
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

        // --- Add Pen Logic ---
        const addPenBtn = document.querySelector('.btn-add-pen');
        if (addPenBtn) {
            addPenBtn.addEventListener('click', () => {
                Swal.fire({
                    title: 'Add New Pen',
                    width: 600,
                    html: `
                        <style>
                            .custom-input { width: 100%; padding: 10px; margin-bottom: 12px; border: 1px solid #d1d5db; border-radius: 6px; box-sizing: border-box; font-family: inherit; }
                            .custom-input:focus { border-color: #22c55e; outline: none; }
                            .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; text-align: left; }
                            .form-group { margin-bottom: 4px; }
                            .form-label { display: block; font-size: 0.8rem; font-weight: 600; color: #4b5563; margin-bottom: 4px; text-transform: uppercase; }
                        </style>
                        <div class="form-grid">
                            <div class="form-group" style="grid-column: span 2;">
                                <label class="form-label">Pen Name</label>
                                <input id="pen-name" class="custom-input" placeholder="e.g. Pen D1">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Section</label>
                                <input id="pen-section" class="custom-input" placeholder="e.g. Section D">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Status</label>
                                <select id="pen-status" class="custom-input">
                                    <option value="Excellent">Excellent</option>
                                    <option value="Good">Good</option>
                                    <option value="Fair">Fair</option>
                                    <option value="Poor">Poor</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Healthy Pigs</label>
                                <input id="pen-healthy" type="number" class="custom-input" placeholder="0">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Sick Pigs</label>
                                <input id="pen-sick" type="number" class="custom-input" placeholder="0">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Current Avg Weight</label>
                                <input id="pen-avg-weight" class="custom-input" placeholder="e.g. 50 kg">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Target Weight</label>
                                <input id="pen-target-weight" class="custom-input" placeholder="e.g. 110 kg">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Batch Cost</label>
                                <input id="pen-batch-cost" class="custom-input" placeholder="e.g. ₱500,000">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Feed Cons/Day</label>
                                <input id="pen-feed-cons" class="custom-input" placeholder="e.g. 100 kg">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Profit Margin</label>
                                <input id="pen-profit" class="custom-input" placeholder="e.g. 20%">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Progress</label>
                                <input id="pen-progress" type="number" class="custom-input" placeholder="e.g. 45">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Start Date</label>
                                <input id="pen-start" type="date" class="custom-input">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Est. Finish Date</label>
                                <input id="pen-finish" type="date" class="custom-input">
                            </div>
                        </div>
                    `,
                    showCancelButton: true,
                    confirmButtonText: 'Save Pen',
                    confirmButtonColor: '#22c55e',
                    preConfirm: () => {
                        const name = document.getElementById('pen-name').value;
                        const section = document.getElementById('pen-section').value;
                        const status = document.getElementById('pen-status').value;
                        const healthy = document.getElementById('pen-healthy').value;
                        const sick = document.getElementById('pen-sick').value;
                        const currentAvg = document.getElementById('pen-avg-weight').value;
                        const targetWeight = document.getElementById('pen-target-weight').value;
                        const batchCost = document.getElementById('pen-batch-cost').value;
                        const feedCons = document.getElementById('pen-feed-cons').value;
                        const profit = document.getElementById('pen-profit').value;
                        const progress = document.getElementById('pen-progress').value;
                        const start = document.getElementById('pen-start').value;
                        const finish = document.getElementById('pen-finish').value;

                        if (!name || !section || !healthy || !sick || !currentAvg || !targetWeight || !batchCost || !feedCons || !profit || !progress || !start || !finish) {
                            Swal.showValidationMessage('Please completely fill up all fields to ensure data is properly structured!');
                        }

                        return {
                            name, section, status,
                            healthy: parseInt(healthy), sick: parseInt(sick),
                            currentAvg, targetWeight, batchCost, feedCons, profit,
                            progress: parseInt(progress), start, finish
                        };
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        const data = result.value;
                        
                        // Add to details object
                        penDetails[data.name] = {
                            subtitle: data.section,
                            healthy: data.healthy,
                            sick: data.sick,
                            currentAvg: data.currentAvg,
                            targetWeight: data.targetWeight,
                            progress: data.progress,
                            batchCost: data.batchCost,
                            feedCons: data.feedCons,
                            profit: data.profit,
                            start: data.start,
                            finish: data.finish
                        };

                        // Calculate total pigs
                        const totalPigs = data.healthy + data.sick;
                        
                        // Create DOM element
                        const newCard = document.createElement('div');
                        newCard.className = 'pen-card';
                        
                        // Determine badge class
                        const statusLower = data.status.toLowerCase();
                        
                        newCard.innerHTML = `
                            <div class="pen-info">
                                <div class="pen-name-row">
                                    <span class="pen-name">${data.name}</span>
                                    <span class="badge-${statusLower}">${data.status}</span>
                                </div>
                                <div class="pen-stats-row">
                                    <div class="stat-item">
                                        <span class="stat-label">Total Pigs</span>
                                        <span class="stat-value">${totalPigs}</span>
                                    </div>
                                    <div class="stat-item">
                                        <span class="stat-label">Sick Pigs</span>
                                        <span class="stat-value ${data.sick > 0 ? 'danger' : ''}">${data.sick}</span>
                                    </div>
                                    <div class="stat-item">
                                        <span class="stat-label">Avg Weight</span>
                                        <span class="stat-value">${data.currentAvg}</span>
                                    </div>
                                    <div class="stat-item">
                                        <span class="stat-label">Progress</span>
                                        <span class="stat-value">${data.progress}%</span>
                                    </div>
                                </div>
                            </div>
                            <i class="bx bx-chevron-right pen-chevron"></i>
                        `;
                        
                        document.querySelector('.pens-list').appendChild(newCard);
                        newCard.scrollIntoView({ behavior: 'smooth', block: 'end' });
                        newCard.click();
                        
                        Swal.fire({
                            icon: 'success',
                            title: 'Pen Added!',
                            text: `${data.name} has been successfully added to the report.`,
                            confirmButtonColor: '#22c55e'
                        });
                    }
                });
            });
        }

        // --- Interactive Pen Cards Logic ---
        let penDetails = {
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

        const pensList = document.querySelector('.pens-list');
        pensList.addEventListener('click', (e) => {
            const card = e.target.closest('.pen-card');
            if (!card) return;

            // Update active selection state visually
            document.querySelectorAll('.pen-card').forEach(c => c.classList.remove('active'));
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

                // 6. Update Action Buttons
                const editBtn = document.querySelector('.btn-action-edit');
                const deleteBtn = document.querySelector('.btn-action-delete');
                if (editBtn) editBtn.setAttribute('onclick', `editPen('${penName}')`);
                if (deleteBtn) deleteBtn.setAttribute('onclick', `deletePen('${penName}')`);
            }
        });

        // --- Management Logic ---
        window.editPen = function(penName) {
            Swal.fire({
                title: `Edit ${penName}`,
                html: `
                    <div style="text-align: left; padding: 10px;">
                        <label style="display: block; font-size: 0.8rem; font-weight: bold; color: #6b7280; margin-bottom: 4px;">Pen Name</label>
                        <input id="swal-pen-name" class="swal2-input" value="${penName}" style="width: 100%; margin: 0 0 16px 0;">
                        
                        <label style="display: block; font-size: 0.8rem; font-weight: bold; color: #6b7280; margin-bottom: 4px;">Section/Area</label>
                        <input id="swal-pen-section" class="swal2-input" value="Section ${penName.charAt(4)}" style="width: 100%; margin: 0 0 16px 0;">
                        
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                            <div>
                                <label style="display: block; font-size: 0.8rem; font-weight: bold; color: #6b7280; margin-bottom: 4px;">Weight Goal</label>
                                <input id="swal-pen-weight" class="swal2-input" value="110" style="width: 100%; margin: 0;">
                            </div>
                            <div>
                                <label style="display: block; font-size: 0.8rem; font-weight: bold; color: #6b7280; margin-bottom: 4px;">Batch Cost</label>
                                <input id="swal-pen-cost" class="swal2-input" value="625000" style="width: 100%; margin: 0;">
                            </div>
                        </div>
                    </div>
                `,
                showCancelButton: true,
                confirmButtonText: 'Save Changes',
                confirmButtonColor: '#22c55e',
                cancelButtonColor: '#4b5563',
                background: '#fff',
                color: '#111827',
                preConfirm: () => {
                    return {
                        name: document.getElementById('swal-pen-name').value,
                        section: document.getElementById('swal-pen-section').value
                    }
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Updated!',
                        text: `${penName} settings have been updated successfully.`,
                        icon: 'success',
                        confirmButtonColor: '#22c55e'
                    });
                }
            });
        };

        window.deletePen = function(penName) {
            Swal.fire({
                title: `Delete ${penName}?`,
                text: "This will permanently remove the pen and all its associated pig data. This action cannot be undone.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#4b5563',
                confirmButtonText: 'Yes, Delete Pen'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Deleted!',
                        text: `${penName} has been removed from the system.`,
                        icon: 'success',
                        confirmButtonColor: '#22c55e'
                    });
                }
            });
        };

        // --- Alert Highlight Logic ---
        const urlParams = new URLSearchParams(window.location.search);
        const highlightParam = urlParams.get('highlight');
        
        if (highlightParam) {
            // Add a dynamic style for the flashing effect
            const style = document.createElement('style');
            style.innerHTML = `
                @keyframes flashRed {
                    0%, 100% { background-color: #ffffff; border-color: #e5e7eb; box-shadow: none; }
                    50% { background-color: #fee2e2; border-color: #ef4444; box-shadow: 0 0 15px rgba(239, 68, 68, 0.4); }
                }
                .highlight-flash {
                    animation: flashRed 1s ease-in-out 3;
                }
            `;
            document.head.appendChild(style);

            // Find the pen card that matches the highlight parameter
            const allPenCards = document.querySelectorAll('.pen-card');
            allPenCards.forEach(card => {
                const penName = card.querySelector('.pen-name').innerText.trim();
                if (penName === highlightParam) {
                    // Simulate a click to load its data into the details panel
                    card.click();
                    
                    // Scroll to it
                    card.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    
                    // Apply flash class
                    card.classList.add('highlight-flash');
                    
                    // Clean up URL without reloading to avoid flashing again on refresh
                    window.history.replaceState({}, document.title, window.location.pathname);
                    
                    // Remove class after animation finishes
                    setTimeout(() => {
                        card.classList.remove('highlight-flash');
                    }, 3000);
                }
            });
        }

    });
</script>

@endsection
