@extends('layouts.master')
@section('title', 'Inventory Management')

@section('contents')
<style>
/* Custom Layout Styles for exact Farm Admin match */
.farm-content {
    padding: 16px 32px 32px 32px;
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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const restockBtns = document.querySelectorAll('.btn-restock');
        
        restockBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const tr = this.closest('tr');
                const nameTd = tr.querySelector('td:nth-child(1)');
                const quantityTd = tr.querySelector('td:nth-child(3)');
                const thresholdTd = tr.querySelector('td:nth-child(4)');
                const statusSpan = tr.querySelector('td:nth-child(5) span');
                const lastRestockTd = tr.querySelector('td:nth-child(6)');
                const supplierTd = tr.querySelector('td:nth-child(7)');

                const feedName = nameTd.innerText.trim();
                const supplierName = supplierTd.innerText.trim();
                const currentVal = parseInt(quantityTd.innerText.replace(/,/g, '').replace('kg', '').trim(), 10);
                const thresholdVal = parseInt(thresholdTd.innerText.replace(/,/g, '').replace('kg', '').trim(), 10);

                const pendingAmount = this.dataset.pendingAmount;

                if (pendingAmount) {
                    // STATE 2: RECEIVE DELIVERY
                    const amount = parseInt(pendingAmount, 10);

                    Swal.fire({
                        title: 'Receive Delivery',
                        html: `Did the supplier (<b>${supplierName}</b>) deliver the <b>${amount.toLocaleString()} kg</b> of ${feedName}?`,
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, Received',
                        cancelButtonText: 'Not Yet',
                        confirmButtonColor: '#22c55e',
                        cancelButtonColor: '#6b7280'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const newStock = currentVal + amount;
                            
                            // Update stock quantity
                            quantityTd.innerText = `${newStock.toLocaleString('en-US')} kg`;
                            
                            // Revert status badge based on new stock
                            statusSpan.removeAttribute('style'); // Clear inline styles from ORDERED state
                            if (newStock >= thresholdVal) {
                                statusSpan.className = 'badge-ok';
                                statusSpan.innerText = 'OK';
                            } else {
                                statusSpan.className = 'badge-low';
                                statusSpan.innerText = 'LOW';
                            }

                            // Update last restocked date
                            const today = new Date();
                            const year = today.getFullYear();
                            const month = String(today.getMonth() + 1).padStart(2, '0');
                            const day = String(today.getDate()).padStart(2, '0');
                            lastRestockTd.innerText = `${year}-${month}-${day}`;
                            
                            // Revert Button back to normal Restock state
                            delete this.dataset.pendingAmount;
                            this.innerHTML = '<i class="bx bx-refresh"></i> Restock';
                            this.style.backgroundColor = ''; // Revert to CSS default
                            
                            Swal.fire({
                                title: 'Inventory Updated!',
                                text: `Successfully received and added ${amount.toLocaleString()} kg of ${feedName}.`,
                                icon: 'success',
                                confirmButtonColor: '#22c55e'
                            });
                            
                            // Update KPI dashboard dynamically
                            updateTotalStock(amount);
                            updateLowStockCount();
                        }
                    });

                } else {
                    // STATE 1: SEND ORDER
                    Swal.fire({
                        title: 'Purchase Order',
                        html: `
                            <div style="text-align: left; margin-bottom: 15px; font-size: 0.95rem; color: #4b5563; background: #f3f4f6; padding: 12px; border-radius: 8px;">
                                <p style="margin: 0 0 4px 0;"><b>Feed Type:</b> ${feedName}</p>
                                <p style="margin: 0 0 4px 0;"><b>Supplier:</b> ${supplierName}</p>
                                <p style="margin: 0 0 4px 0;"><b>Current Stock:</b> ${currentVal.toLocaleString()} kg</p>
                                <p style="margin: 0;"><b>Min Threshold:</b> ${thresholdVal.toLocaleString()} kg</p>
                            </div>
                            <p style="text-align: left; margin-bottom: 8px; font-size: 0.95rem; font-weight: 500; color: #111827;">Enter order quantity (kg):</p>
                        `,
                        input: 'number',
                        inputAttributes: {
                            min: 1,
                            step: 1,
                            placeholder: 'e.g. 500'
                        },
                        showCancelButton: true,
                        confirmButtonText: '<i class="bx bx-paper-plane" style="vertical-align: middle; margin-right: 4px;"></i> Send Order',
                        cancelButtonText: 'Cancel',
                        confirmButtonColor: '#3b82f6', // Blue for sending
                        cancelButtonColor: '#ef4444',
                        inputValidator: (value) => {
                            if (!value || value <= 0) {
                                return 'Please enter a valid amount greater than 0!'
                            }
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const amount = parseInt(result.value, 10);
                            
                            // Change button to Receive Delivery state
                            this.dataset.pendingAmount = amount;
                            this.innerHTML = `<i class="bx bx-package"></i> Receive (${amount}kg)`;
                            this.style.backgroundColor = '#f59e0b'; // Orange/Warning color for pending
                            
                            // Update status badge to show Ordered
                            statusSpan.className = 'badge-low'; // Use same base padding
                            statusSpan.innerText = 'ORDERED';
                            statusSpan.style.background = '#dbeafe'; // Blueish background
                            statusSpan.style.color = '#2563eb';
                            statusSpan.style.borderColor = '#bfdbfe';

                            Swal.fire({
                                title: 'Order Sent!',
                                text: `Your order for ${amount.toLocaleString()} kg has been securely sent to ${supplierName}. Waiting for supplier delivery.`,
                                icon: 'success',
                                confirmButtonColor: '#3b82f6'
                            });
                        }
                    });
                }
            });
        });

        function updateTotalStock(addedAmount) {
            const kpiValues = document.querySelectorAll('.kpi-value');
            if (kpiValues.length >= 3) {
                const totalStockEl = kpiValues[2];
                let currentTotal = parseInt(totalStockEl.innerText.replace(/,/g, '').replace('kg', '').trim(), 10);
                if (!isNaN(currentTotal)) {
                    totalStockEl.innerText = `${(currentTotal + addedAmount).toLocaleString('en-US')} kg`;
                }
            }
        }

        function updateLowStockCount() {
            const kpiValues = document.querySelectorAll('.kpi-value');
            if (kpiValues.length >= 2) {
                let lowCount = 0;
                document.querySelectorAll('.farm-table tbody tr').forEach(tr => {
                    const statusSpan = tr.querySelector('td:nth-child(5) span');
                    if (statusSpan && statusSpan.innerText === 'LOW') {
                        lowCount++;
                    }
                });
                kpiValues[1].innerText = lowCount;
            }
        }

        // --- Alert Highlight Logic ---
        const urlParams = new URLSearchParams(window.location.search);
        const highlightParam = urlParams.get('highlight');
        
        if (highlightParam) {
            // Add a dynamic style for the flashing effect
            const style = document.createElement('style');
            style.innerHTML = `
                @keyframes flashRedRow {
                    0%, 100% { background-color: transparent; }
                    50% { background-color: #fee2e2; }
                }
                .highlight-flash-row {
                    animation: flashRedRow 1s ease-in-out 3;
                }
            `;
            document.head.appendChild(style);

            // Find the inventory row that matches the highlight parameter
            const rows = document.querySelectorAll('.farm-table tbody tr');
            rows.forEach(tr => {
                const feedName = tr.querySelector('td:nth-child(1)').innerText.trim();
                if (feedName === highlightParam) {
                    
                    // Scroll to it
                    tr.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    
                    // Apply flash class
                    tr.classList.add('highlight-flash-row');
                    
                    // Clean up URL without reloading to avoid flashing again on refresh
                    window.history.replaceState({}, document.title, window.location.pathname);
                    
                    // Remove class after animation finishes
                    setTimeout(() => {
                        tr.classList.remove('highlight-flash-row');
                    }, 3000);
                }
            });
        }
    });
</script>
@endsection
