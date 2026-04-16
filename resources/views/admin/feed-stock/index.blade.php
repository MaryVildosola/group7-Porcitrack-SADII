@extends('layouts.master')
@section('contents')
<style>
.feed-stock-wrap {
    padding: 32px;
    max-width: 1280px;
    margin: 0 auto;
}
.page-title { font-size: 1.6rem; font-weight: 700; color: #111827; margin-bottom: 8px; }
.page-subtitle { color: #6b7280; font-size: 0.95rem; margin-bottom: 24px; }
.grid-two { display: grid; grid-template-columns: 1.2fr 0.8fr; gap: 28px; }
.panel { background: #ffffff; border: 1px solid #e5e7eb; border-radius: 20px; padding: 28px; }
.panel-header { display: flex; justify-content: space-between; flex-wrap: wrap; gap: 16px; align-items: center; margin-bottom: 16px; }
.panel-title { font-size: 1.1rem; font-weight: 700; color: #111827; }
.stat-group { display: flex; gap: 16px; flex-wrap: wrap; margin-bottom: 24px; }
.stat-card { flex: 1; min-width: 180px; background: #f8fafc; border: 1px solid #e5e7eb; border-radius: 16px; padding: 18px; }
.stat-label { color: #6b7280; font-size: 0.8rem; margin-bottom: 8px; }
.stat-value { font-size: 1.6rem; font-weight: 700; color: #111827; }
.stat-value.danger { color: #dc2626; }
.alert-box { border-radius: 14px; padding: 18px 22px; margin-bottom: 24px; display: flex; gap: 14px; border: 1px solid transparent; }
.alert-box.warning { background: #fef3c7; border-color: #fde68a; color: #92400e; }
.alert-box.success { background: #dcfce7; border-color: #bbf7d0; color: #166534; }
.alert-box strong { display: block; margin-bottom: 4px; }
.delivery-form .form-row { margin-bottom: 18px; }
.form-row label { display: block; font-size: 0.9rem; color: #374151; margin-bottom: 8px; }
.form-row input { width: 100%; border: 1px solid #d1d5db; border-radius: 12px; padding: 12px 14px; font-size: 0.95rem; }
.btn-primary { display: inline-flex; align-items: center; justify-content: center; gap: 10px; padding: 14px 20px; border-radius: 14px; background: #22c55e; color: #ffffff; font-weight: 600; border: none; cursor: pointer; transition: background 0.2s ease; }
.btn-primary:hover { background: #16a34a; }
.table-wrapper { overflow-x: auto; }
.table { width: 100%; border-collapse: collapse; }
.table th, .table td { text-align: left; padding: 14px 12px; border-bottom: 1px solid #f3f4f6; }
.table th { color: #6b7280; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.04em; }
.table td { color: #374151; font-size: 0.95rem; }
.empty-state { padding: 24px; text-align: center; color: #6b7280; }
.note-box { background: #f8fafc; border: 1px dashed #cbd5e1; border-radius: 16px; padding: 18px; color: #334155; font-size: 0.92rem; }
</style>

<div class="feed-stock-wrap">
    <div class="page-header">
        <h1 class="page-title">Feed Deliveries & Warehouse Stock</h1>
        <p class="page-subtitle">Record incoming feed sacks and monitor available stock automatically from worker consumption logs.</p>
    </div>

    @if(session('success'))
        <div class="alert-box success">
            <strong>Success</strong>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if($lowStock)
        <div class="alert-box warning">
            <strong>Low Feed Warning</strong>
            <span>Available stock is {{ $availableStock }} sack(s). Notify your team and schedule the next delivery.</span>
        </div>
    @endif

    <div class="stat-group">
        <div class="stat-card">
            <div class="stat-label">Total Delivered</div>
            <div class="stat-value">{{ $totalDelivered }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Total Consumed</div>
            <div class="stat-value">{{ $totalConsumed }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Available Stock</div>
            <div class="stat-value {{ $availableStock <= 10 ? 'danger' : '' }}">{{ $availableStock }}</div>
        </div>
    </div>

    <div class="grid-two">
        <section class="panel delivery-form">
            <div class="panel-header">
                <div>
                    <h2 class="panel-title">Add Feed Delivery</h2>
                    <p class="page-subtitle">Enter the delivery date and sack count.</p>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.feed-stock.store') }}">
                @csrf
                <div class="form-row">
                    <label for="delivery_date">Delivery Date</label>
                    <input id="delivery_date" type="date" name="delivery_date" value="{{ old('delivery_date') }}" required>
                    @error('delivery_date')<span style="color:#dc2626; font-size:0.85rem;">{{ $message }}</span>@enderror
                </div>
                <div class="form-row">
                    <label for="quantity">Quantity (sacks)</label>
                    <input id="quantity" type="number" name="quantity" min="1" value="{{ old('quantity', 1) }}" required>
                    @error('quantity')<span style="color:#dc2626; font-size:0.85rem;">{{ $message }}</span>@enderror
                </div>
                <button class="btn-primary" type="submit">Record Delivery</button>
            </form>

            <div class="note-box" style="margin-top: 24px;">
                Feed availability is calculated from total delivered sacks minus worker feed consumption. When stock drops to 10 sacks or less, admins are alerted automatically.
            </div>
        </section>

        <section class="panel">
            <div class="panel-header">
                <div>
                    <h2 class="panel-title">Recent Deliveries</h2>
                    <p class="page-subtitle">Latest feed deliveries recorded in the warehouse.</p>
                </div>
            </div>

            <div class="table-wrapper">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Quantity</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($deliveries as $delivery)
                            <tr>
                                <td>{{ $delivery->delivery_date->format('F j, Y') }}</td>
                                <td>{{ $delivery->quantity }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="empty-state">No feed deliveries have been logged yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</div>
@endsection
