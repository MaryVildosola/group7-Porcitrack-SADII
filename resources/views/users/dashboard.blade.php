@extends('layouts.master')
@section('contents')
<style>
.dashboard-wrap { padding: 32px; max-width: 1400px; margin: 0 auto; }
.page-title { font-size: 1.5rem; font-weight: 800; color: #1e293b; margin-bottom: 4px; }
.page-subtitle { color: #64748b; font-size: 0.875rem; margin-bottom: 32px; }

/* KPI Grid */
.kpi-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 24px; margin-bottom: 32px; }
.kpi-card { background: #fff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 24px; transition: all 0.3s; }
.kpi-card:hover { border-color: #22c55e; box-shadow: 0 10px 20px rgba(0,0,0,0.02); }
.kpi-header { display: flex; justify-content: space-between; align-items: flex-start; color: #64748b; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; margin-bottom: 16px; }
.kpi-value { font-size: 1.75rem; font-weight: 800; color: #1e293b; margin-bottom: 4px; }
.kpi-icon { width: 40px; height: 40px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.4rem; }

/* Main Grid Layout */
.main-grid { display: grid; grid-template-columns: 1fr 380px; gap: 24px; }
.panel { background: #fff; border: 1px solid #e2e8f0; border-radius: 20px; padding: 28px; }
.panel-title { font-size: 1.1rem; font-weight: 700; color: #1e293b; margin-bottom: 24px; display: flex; justify-content: space-between; align-items: center; }

/* Task List Styling */
.task-item { border-bottom: 1px solid #f8fafc; padding: 16px 0; display: flex; gap: 16px; align-items: center; }
.task-item:last-child { border-bottom: none; }
.task-icon { width: 44px; height: 44px; background: #f1f5f9; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #64748b; flex-shrink: 0; }
.task-details { flex: 1; }
.task-name { font-size: 0.95rem; font-weight: 700; color: #1e293b; margin-bottom: 2px; }
.task-meta { font-size: 0.75rem; color: #94a3b8; }
.status-pill { padding: 4px 10px; border-radius: 8px; font-size: 0.65rem; font-weight: 800; text-transform: uppercase; }
.pill-pending { background: #fff7ed; color: #c2410c; border: 1px solid #fdba74; }

/* Quick Actions Card */
.action-card { background: linear-gradient(135deg, #1e293b, #0f172a); border-radius: 20px; padding: 28px; color: #fff; position: sticky; top: 24px; }
.action-btn { display: flex; align-items: center; gap: 12px; padding: 14px; background: rgba(255,255,255,0.05); border-radius: 12px; margin-bottom: 12px; text-decoration: none; color: #cbd5e1; transition: all 0.2s; font-size: 0.9rem; font-weight: 600; border: 1px solid rgba(255,255,255,0.05); }
.action-btn:hover { background: rgba(255,255,255,0.1); color: #fff; border-color: rgba(255,255,255,0.2); transform: translateX(4px); }
.action-btn i { font-size: 1.25rem; }
</style>

<div class="dashboard-wrap">
    <div class="header-block">
        <h1 class="page-title">Farm Dashboard</h1>
        <p class="page-subtitle">Real-time overview of your piggery operations</p>
    </div>

    <!-- KPI Summary Row -->
    <div class="kpi-grid">
        <div class="kpi-card">
            <div class="kpi-header"><span>Total Pigs</span><i class="bx bxs-group kpi-icon" style="color:#6366f1; background:#eef2ff;"></i></div>
            <div class="kpi-value">{{ $totalPigs }}</div>
            <div style="font-size:0.7rem; color:#94a3b8;">Active livestock counted</div>
        </div>
        <div class="kpi-card">
            <div class="kpi-header"><span>Pending Tasks</span><i class="bx bx-list-check kpi-icon" style="color:#f59e0b; background:#fffbeb;"></i></div>
            <div class="kpi-value">{{ $pendingTasks }}</div>
            <div style="font-size:0.7rem; color:#94a3b8;">Needs attention today</div>
        </div>
        <div class="kpi-card">
            <div class="kpi-header"><span>Sick Pigs</span><i class="bx bx-plus-medical kpi-icon" style="color:#ef4444; background:#fef2f2;"></i></div>
            <div class="kpi-value">{{ $sickPigs }}</div>
            <div style="font-size:0.7rem; color:#94a3b8;">Reported from pens</div>
        </div>
        <div class="kpi-card" style="border-left: 4px solid {{ $availableStock <= 10 ? '#ef4444' : '#22c55e' }};">
            <div class="kpi-header"><span>Stock Levels</span><i class="bx bx-package kpi-icon" style="color:#22c55e; background:#f0fdf4;"></i></div>
            <div class="kpi-value">{{ $availableStock }}</div>
            <div style="font-size:0.7rem; font-weight: 700; color:{{ $availableStock <= 10 ? '#ef4444' : '#22c55e' }}; text-transform: uppercase;">{{ $availableStock <= 10 ? 'Critical Low' : 'Healthy Stock' }}</div>
        </div>
    </div>

    <div class="main-grid">
        <!-- Recent Activity Panel -->
        <div class="panel">
            <div class="panel-title">
                <span>Recent Farm Activity</span>
                <a href="{{ route('admin.tasks.index') }}" style="font-size: 0.75rem; color: #22c55e; text-decoration: none; font-weight: 700;">VIEW ALL</a>
            </div>
            
            <div class="task-list">
                @forelse($recentTasks as $task)
                    <div class="task-item">
                        <div class="task-icon"><i class="bx bx-task"></i></div>
                        <div class="task-details">
                            <div class="task-name">{{ $task->title }}</div>
                            <div class="task-meta">Assigned to {{ $task->assignee->name }} • {{ $task->due_date->format('M d') }}</div>
                        </div>
                        <span class="status-pill pill-{{ $task->status }}">{{ $task->status }}</span>
                    </div>
                @empty
                    <div style="text-align: center; padding: 40px; color: #94a3b8;">
                        <i class="bx bx-calendar-x" style="font-size: 2rem; margin-bottom: 8px;"></i>
                        <p style="font-size: 0.85rem;">No tasks logged recently</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Right Side Actions -->
        <div>
            <div class="action-card">
                <h3 style="font-size: 1rem; font-weight: 700; margin-bottom: 24px;">Quick Actions</h3>
                
                <a href="{{ route('admin.tasks.store') }}" class="action-btn">
                    <i class="bx bx-plus-circle"></i>
                    <span>Create New Task</span>
                </a>
                <a href="{{ route('pens.index') }}" class="action-btn">
                    <i class="bx bx-door-open"></i>
                    <span>Manage Farm Pens</span>
                </a>
                <a href="{{ route('admin.feed-stock.index') }}" class="action-btn">
                    <i class="bx bx-box"></i>
                    <span>Check Inventory</span>
                </a>
                <a href="{{ route('users.index') }}" class="action-btn">
                    <i class="bx bx-user-plus"></i>
                    <span>Add Farm Worker</span>
                </a>

                <div style="margin-top: 32px; padding-top: 32px; border-top: 1px solid rgba(255,255,255,0.1);">
                    <p style="font-size: 0.75rem; color: #64748b; line-height: 1.6;">
                        Current Shift: <b>Morning Operations</b><br>
                        System Status: <span style="color: #22c55e;">● Operational</span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
