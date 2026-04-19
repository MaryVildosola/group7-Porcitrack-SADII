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
            @forelse($pens as $pen)
            <div class="pen-card {{ $loop->first ? 'active' : '' }}" data-id="{{ $pen->id }}">
                <div class="pen-info">
                    <div class="pen-name-row">
                        <span class="pen-name">{{ $pen->name }}</span>
                        <span class="badge-{{ strtolower($pen->status) }}">{{ $pen->status }}</span>
                    </div>
                    <div class="pen-stats-row">
                        <div class="stat-item">
                            <span class="stat-label">Total Pigs</span>
                            <span class="stat-value">{{ $pen->healthy_pigs + $pen->sick_pigs }}</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">Sick Pigs</span>
                            <span class="stat-value {{ $pen->sick_pigs > 0 ? 'danger' : '' }}">{{ $pen->sick_pigs }}</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">Avg Weight</span>
                            <span class="stat-value">{{ $pen->avg_weight }}</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">Progress</span>
                            <span class="stat-value">{{ $pen->progress }}%</span>
                        </div>
                    </div>
                </div>
                <i class="bx bx-chevron-right pen-chevron"></i>
            </div>
            @empty
            <div class="p-8 text-center text-gray-500">
                No pens found. Click "Add Pen" to create one.
            </div>
            @endforelse
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
        // --- CSRF Setup for AJAX ---
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // --- Interactive Pen Cards Logic ---
        let penDetails = @json($pens->keyBy('name'));

        const pensList = document.querySelector('.pens-list');
        pensList.addEventListener('click', (e) => {
            const card = e.target.closest('.pen-card');
            if (!card) return;

            // Update active selection state visually
            document.querySelectorAll('.pen-card').forEach(c => c.classList.remove('active'));
            card.classList.add('active');

            // Retrieve clicked pen Name and Data
            const penId = card.getAttribute('data-id');
            const penName = card.querySelector('.pen-name').innerText.trim();
            
            // Find in details
            const data = Object.values(penDetails).find(p => p.id == penId);

            if (data) {
                // 1. Update Headers
                document.querySelector('.details-title').innerText = `${data.name} Details`;
                document.querySelector('.details-header .page-subtitle').innerText = data.section || 'Unassigned';

                // 2. Update Health Status
                const healthValues = document.querySelectorAll('.health-grid .health-value');
                healthValues[0].innerText = data.healthy_pigs || 0;
                healthValues[1].innerText = data.sick_pigs || 0;

                // 3. Update Weight Progress
                const detailSections = document.querySelectorAll('.details-section');
                const weightValues = detailSections[1].querySelectorAll('.font-bold');
                weightValues[0].innerText = data.avg_weight || '0 kg';
                weightValues[1].innerText = data.target_weight || '0 kg';
                document.querySelector('.progress-bar-fill').style.width = `${data.progress || 0}%`;
                document.querySelector('.progress-meta').innerText = `${data.progress || 0}% to target`;

                // 4. Update Financial Overview
                const financialValues = detailSections[2].querySelectorAll('.financial-value');
                financialValues[0].innerText = data.batch_cost || '₱0';
                financialValues[1].innerText = data.feed_cons || '0 kg';
                financialValues[2].innerText = data.profit_margin || '0%';

                // 5. Update Timeline
                const timelineValues = detailSections[3].querySelectorAll('.financial-value');
                timelineValues[0].innerText = data.start_date || 'N/A';
                timelineValues[1].innerText = data.end_date || 'N/A';

                // 6. Update Action Buttons
                const editBtn = document.querySelector('.btn-action-edit');
                const deleteBtn = document.querySelector('.btn-action-delete');
                if (editBtn) editBtn.setAttribute('onclick', `editPen(${data.id})`);
                if (deleteBtn) deleteBtn.setAttribute('onclick', `deletePen(${data.id})`);
            }
        });

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
                                <label class="form-label">Progress (%)</label>
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
                    showLoaderOnConfirm: true,
                    preConfirm: () => {
                        const payload = {
                            name: document.getElementById('pen-name').value,
                            section: document.getElementById('pen-section').value,
                            status: document.getElementById('pen-status').value,
                            healthy_pigs: document.getElementById('pen-healthy').value,
                            sick_pigs: document.getElementById('pen-sick').value,
                            avg_weight: document.getElementById('pen-avg-weight').value,
                            target_weight: document.getElementById('pen-target-weight').value,
                            batch_cost: document.getElementById('pen-batch-cost').value,
                            feed_cons: document.getElementById('pen-feed-cons').value,
                            profit_margin: document.getElementById('pen-profit').value,
                            progress: document.getElementById('pen-progress').value,
                            start_date: document.getElementById('pen-start').value,
                            end_date: document.getElementById('pen-finish').value,
                        };

                        if (!payload.name) {
                            Swal.showValidationMessage('Pen Name is required!');
                            return false;
                        }

                        return fetch('{{ route("pens.store") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify(payload)
                        })
                        .then(response => {
                            if (!response.ok) throw new Error(response.statusText);
                            return response.json();
                        })
                        .catch(error => {
                            Swal.showValidationMessage(`Request failed: ${error}`);
                        });
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Pen Added!',
                            text: result.value.message,
                            confirmButtonColor: '#22c55e'
                        }).then(() => window.location.reload());
                    }
                });
            });
        }

        // --- Edit Pen Logic ---
        window.editPen = function(id) {
            const data = Object.values(penDetails).find(p => p.id == id);
            if (!data) return;

            Swal.fire({
                title: `Edit ${data.name}`,
                width: 600,
                html: `
                    <style>
                        .custom-input { width: 100%; padding: 10px; margin-bottom: 12px; border: 1px solid #d1d5db; border-radius: 6px; box-sizing: border-box; font-family: inherit; }
                        .custom-input:focus { border-color: #22c55e; outline: none; }
                        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; text-align: left; }
                        .form-label { display: block; font-size: 0.8rem; font-weight: 600; color: #4b5563; margin-bottom: 4px; text-transform: uppercase; }
                    </style>
                    <div class="form-grid">
                        <div class="form-group" style="grid-column: span 2;">
                            <label class="form-label">Pen Name</label>
                            <input id="edit-name" class="custom-input" value="${data.name}">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Section</label>
                            <input id="edit-section" class="custom-input" value="${data.section || ''}">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Status</label>
                            <select id="edit-status" class="custom-input">
                                <option value="Excellent" ${data.status == 'Excellent' ? 'selected' : ''}>Excellent</option>
                                <option value="Good" ${data.status == 'Good' ? 'selected' : ''}>Good</option>
                                <option value="Fair" ${data.status == 'Fair' ? 'selected' : ''}>Fair</option>
                                <option value="Poor" ${data.status == 'Poor' ? 'selected' : ''}>Poor</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Healthy Pigs</label>
                            <input id="edit-healthy" type="number" class="custom-input" value="${data.healthy_pigs || 0}">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Sick Pigs</label>
                            <input id="edit-sick" type="number" class="custom-input" value="${data.sick_pigs || 0}">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Current Avg Weight</label>
                            <input id="edit-avg-weight" class="custom-input" value="${data.avg_weight || ''}">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Target Weight</label>
                            <input id="edit-target-weight" class="custom-input" value="${data.target_weight || ''}">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Batch Cost</label>
                            <input id="edit-batch-cost" class="custom-input" value="${data.batch_cost || ''}">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Feed Cons/Day</label>
                            <input id="edit-feed-cons" class="custom-input" value="${data.feed_cons || ''}">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Profit Margin</label>
                            <input id="edit-profit" class="custom-input" value="${data.profit_margin || ''}">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Progress (%)</label>
                            <input id="edit-progress" type="number" class="custom-input" value="${data.progress || 0}">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Start Date</label>
                            <input id="edit-start" type="date" class="custom-input" value="${data.start_date || ''}">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Est. Finish Date</label>
                            <input id="edit-finish" type="date" class="custom-input" value="${data.end_date || ''}">
                        </div>
                    </div>
                `,
                showCancelButton: true,
                confirmButtonText: 'Update Pen',
                confirmButtonColor: '#22c55e',
                showLoaderOnConfirm: true,
                preConfirm: () => {
                    const payload = {
                        name: document.getElementById('edit-name').value,
                        section: document.getElementById('edit-section').value,
                        status: document.getElementById('edit-status').value,
                        healthy_pigs: document.getElementById('edit-healthy').value,
                        sick_pigs: document.getElementById('edit-sick').value,
                        avg_weight: document.getElementById('edit-avg-weight').value,
                        target_weight: document.getElementById('edit-target-weight').value,
                        batch_cost: document.getElementById('edit-batch-cost').value,
                        feed_cons: document.getElementById('edit-feed-cons').value,
                        profit_margin: document.getElementById('edit-profit').value,
                        progress: document.getElementById('edit-progress').value,
                        start_date: document.getElementById('edit-start').value,
                        end_date: document.getElementById('edit-finish').value,
                    };

                    return fetch(`/pens/${id}`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify(payload)
                    })
                    .then(response => {
                        if (!response.ok) throw new Error(response.statusText);
                        return response.json();
                    })
                    .catch(error => {
                        Swal.showValidationMessage(`Update failed: ${error}`);
                    });
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Updated!',
                        text: result.value.message,
                        confirmButtonColor: '#22c55e'
                    }).then(() => window.location.reload());
                }
            });
        };

        // --- Delete Pen Logic ---
        window.deletePen = function(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "All associated pig data will be lost!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#9ca3af',
                confirmButtonText: 'Yes, delete it!',
                showLoaderOnConfirm: true,
                preConfirm: () => {
                    return fetch(`/pens/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => {
                        if (!response.ok) throw new Error(response.statusText);
                        return response.json();
                    })
                    .catch(error => {
                        Swal.showValidationMessage(`Delete failed: ${error}`);
                    });
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Deleted!',
                        text: result.value.message,
                        confirmButtonColor: '#22c55e'
                    }).then(() => window.location.reload());
                }
            });
        };

        // --- Alert Highlight Logic ---
        const urlParams = new URLSearchParams(window.location.search);
        const highlightParam = urlParams.get('highlight');
        
        if (highlightParam) {
            const style = document.createElement('style');
            style.innerHTML = `
                @keyframes flashRed {
                    0%, 100% { background-color: #ffffff; border-color: #e5e7eb; box-shadow: none; }
                    50% { background-color: #fee2e2; border-color: #ef4444; box-shadow: 0 0 15px rgba(239, 68, 68, 0.4); }
                }
                .highlight-flash { animation: flashRed 1s ease-in-out 3; }
            `;
            document.head.appendChild(style);

            const allPenCards = document.querySelectorAll('.pen-card');
            allPenCards.forEach(card => {
                const penName = card.querySelector('.pen-name').innerText.trim();
                if (penName === highlightParam) {
                    card.click();
                    card.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    card.classList.add('highlight-flash');
                    window.history.replaceState({}, document.title, window.location.pathname);
                }
            });
        }

        // --- Report Generation Logic ---
        const reportBtn = document.querySelector('.btn-report');
        if (reportBtn) {
            reportBtn.addEventListener('click', () => {
                const penName = document.querySelector('.details-title').innerText.replace(' Details', '').trim();
                Swal.fire({
                    title: 'Generating Report...',
                    html: `Compiling data for <b>${penName}</b>...`,
                    timer: 1500,
                    didOpen: () => Swal.showLoading()
                }).then(() => {
                    Swal.fire({
                        title: 'Report Ready!',
                        icon: 'success',
                        showCancelButton: true,
                        confirmButtonText: 'Print',
                        cancelButtonText: 'Download',
                        confirmButtonColor: '#22c55e'
                    }).then((result) => {
                        if (result.isConfirmed) window.print();
                    });
                });
            });
        }
    });
</script>

    });
</script>

@endsection
