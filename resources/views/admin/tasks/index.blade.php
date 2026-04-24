@extends('layouts.master')
@section('contents')
<style>
.task-wrap { padding: 20px; max-width: 1300px; margin: 0 auto; }
.panel { background: #fff; border: 1px solid #e5e7eb; border-radius: 12px; padding: 18px; margin-bottom: 20px; }
.task-grid { display: grid; grid-template-columns: 1fr 380px; gap: 20px; }
.compact-table th { font-size: 0.7rem; font-weight: 700; color: #64748b; text-transform: uppercase; padding: 12px; border-bottom: 2px solid #f1f5f9; }
.compact-table td { font-size: 0.85rem; padding: 12px; border-bottom: 1px solid #f1f5f9; }
.badge { padding: 4px 8px; border-radius: 6px; font-size: 0.7rem; font-weight: 700; text-transform: uppercase; }
.badge-pending { background: #fff7ed; color: #c2410c; border: 1px solid #fdba74; }
.badge-completed { background: #f0fdf4; color: #15803d; border: 1px solid #86efac; }
.form-input { 
    width: 100%; 
    padding: 10px; 
    border: 1px solid #cbd5e1; 
    border-radius: 8px; 
    font-size: 0.85rem; 
    margin-bottom: 12px; 
    color: #0f172a; 
    font-weight: 500;
    background-color: #fff;
    outline: none;
    transition: border-color 0.2s;
}
.form-input:focus { border-color: #64748b; }
.form-input::placeholder { color: #94a3b8; font-weight: 400; }
.form-label { display: block; font-size: 0.75rem; font-weight: 700; color: #1e293b; margin-bottom: 4px; text-transform: uppercase; letter-spacing: 0.025em; }
.btn-save { width: 100%; padding: 12px; background: #22c55e; color: #fff; border: none; border-radius: 10px; font-weight: 700; cursor: pointer; }
.suggestion-box {
    position: absolute;
    width: 100%;
    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    z-index: 100;
    display: none;
    margin-top: -8px;
    max-height: 200px;
    overflow-y: auto;
}
.suggestion-item {
    padding: 10px 16px;
    font-size: 0.85rem;
    cursor: pointer;
    border-bottom: 1px solid #f1f5f9;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.suggestion-item:last-child { border-bottom: none; }
.suggestion-item:hover { background: #f8fafc; color: #22c55e; }
.suggestion-tag { font-size: 0.65rem; font-weight: 800; background: #f0fdf4; color: #16a34a; padding: 2px 8px; border-radius: 99px; }
</style>

<div class="task-wrap">
    <div style="margin-bottom: 24px;">
        <h1 style="font-size: 1.4rem; font-weight: 800; color: #1e293b; margin-bottom: 4px;">Task Assignment</h1>
        <p style="font-size: 0.85rem; color: #64748b;">Manage and monitor tasks assigned to your farm workers.</p>
    </div>

    @if(session('success'))
        <div style="background: #f0fdf4; border: 1px solid #22c55e; color: #166534; padding: 12px; border-radius: 8px; margin-bottom: 20px; font-size: 0.85rem;">
            {{ session('success') }}
        </div>
    @endif

    <div class="task-grid">
        <!-- Task List -->
        <div class="panel">
            <h2 style="font-size: 1rem; font-weight: 700; margin-bottom: 16px;">Active Task Board</h2>
            <div style="overflow-x: auto;">
                <table class="compact-table" style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr>
                            <th>Due Date</th>
                            <th>Task</th>
                            <th>Assigned To</th>
                            <th>Target</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tasks as $task)
                            <tr>
                                <td style="font-weight: 600;">{{ $task->due_date->format('M d') }}</td>
                                <td>
                                    <div style="font-weight: 700; color: #1e293b;">{{ $task->title }}</div>
                                    <div style="font-size: 0.75rem; color: #64748b;">{{ Str::limit($task->description, 30) }}</div>
                                </td>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 8px;">
                                        <div style="width: 24px; height: 24px; background: #e2e8f0; border-radius: 50%; font-size: 0.6rem; display: flex; align-items: center; justify-content: center; font-weight: 800;">{{ strtoupper(substr($task->assignee->name, 0, 1)) }}</div>
                                        <span>{{ $task->assignee->name }}</span>
                                    </div>
                                </td>
                                <td>
                                    @if($task->pig_id)
                                        <span style="color: #22c55e; font-weight: 700;">Pig: {{ $task->pig->tag }}</span>
                                    @elseif($task->pen_id)
                                        <span style="color: #3b82f6; font-weight: 700;">Pen: {{ $task->pen->name }}</span>
                                    @else
                                        <span style="color: #94a3b8;">General</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge badge-{{ $task->status }}">{{ $task->status }}</span>
                                </td>
                                <td>
                                    <form action="{{ route('admin.tasks.destroy', $task) }}" method="POST" onsubmit="return confirm('Delete this task?')">
                                        @csrf @method('DELETE')
                                        <button style="border: none; background: transparent; color: #ef4444; cursor: pointer;"><i class="bx bx-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" style="text-align: center; padding: 40px; color: #94a3b8;">No tasks assigned yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Assignment Form -->
        <div class="panel" style="position: sticky; top: 20px;">
            <h2 style="font-size: 1rem; font-weight: 700; margin-bottom: 16px;">Create New Task</h2>
            <form action="{{ route('admin.tasks.store') }}" method="POST">
                @csrf
                <div class="form-group" style="position: relative;">
                    <label class="form-label">Task Title</label>
                    <input type="text" name="title" id="task-title" class="form-input" placeholder="e.g. Vaccinate Pen 1" autocomplete="off" required>
                    <div id="suggestion-list" class="suggestion-box custom-scrollbar"></div>
                </div>
                <div class="form-group">
                    <label class="form-label">Description (Instruction)</label>
                    <textarea name="description" class="form-input" style="height: 80px;" placeholder="Optional details..."></textarea>
                </div>
                <div class="form-group">
                    <label class="form-label">Assign To Worker</label>
                    <select name="assigned_to" class="form-input" required>
                        <option value="">Select Worker</option>
                        @foreach($workers as $worker)
                            <option value="{{ $worker->id }}">{{ $worker->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group" style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                    <div>
                        <label class="form-label">Target Pen</label>
                        <select name="pen_id" class="form-input">
                            <option value="">N/A</option>
                            @foreach($pens as $pen)
                                <option value="{{ $pen->id }}">{{ $pen->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Due Date</label>
                        <input type="date" name="due_date" class="form-input" value="{{ now()->format('Y-m-d') }}" required>
                    </div>
                </div>
                <button type="submit" class="btn-save">Assign Task</button>
            </form>

            <div style="margin-top: 20px; padding: 12px; background: #f8fafc; border-radius: 8px; border: 1px dashed #cbd5e1;">
                <p style="font-size: 0.75rem; color: #475569; line-height: 1.5;">
                    <i class="bx bx-info-circle"></i> Assigned tasks will reflect instantly on the worker's dashboard. You can track their completion status in the active board.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const taskSuggestions = [
        { title: 'Vaccination Batch', desc: 'Perform scheduled vaccinations for all pigs in this pen. Ensure correct dosage.', tag: 'HEALTH' },
        { title: 'Deworming Session', desc: 'Administer dewormer as per the veterinarian schedule.', tag: 'HEALTH' },
        { title: 'Weight Monitoring', desc: 'Record the current weight of all pigs for growth analysis.', tag: 'GROWTH' },
        { title: 'Pen Sanitation', desc: 'Thoroughly clean and disinfect the pen floor and feeding troughs.', tag: 'CLEANING' },
        { title: 'Feed Inventory Check', desc: 'Check available feed stocks and report if low.', tag: 'STOCK' },
        { title: 'Iron Injection', desc: 'Administer iron supplements to the piglets.', tag: 'HEALTH' },
        { title: 'Withdrawal Check', desc: 'Check if pigs are ready for withdrawal based on their weight and age.', tag: 'LOGISTICS' },
        { title: 'Water System Audit', desc: 'Ensure all drinkers are clean and functioning correctly.', tag: 'MAINTENANCE' }
    ];

    const titleInput = document.getElementById('task-title');
    const suggestionBox = document.getElementById('suggestion-list');
    const descTextarea = document.querySelector('textarea[name="description"]');

    titleInput.addEventListener('input', function() {
        const value = this.value.toLowerCase();
        suggestionBox.innerHTML = '';
        
        if (!value) {
            suggestionBox.style.display = 'none';
            return;
        }

        const filtered = taskSuggestions.filter(s => 
            s.title.toLowerCase().includes(value) || s.tag.toLowerCase().includes(value)
        );

        if (filtered.length > 0) {
            filtered.forEach(s => {
                const item = document.createElement('div');
                item.className = 'suggestion-item';
                item.innerHTML = `
                    <span>${s.title}</span>
                    <span class="suggestion-tag">${s.tag}</span>
                `;
                item.addEventListener('click', () => {
                    titleInput.value = s.title;
                    descTextarea.value = s.desc;
                    suggestionBox.style.display = 'none';
                });
                suggestionBox.appendChild(item);
            });
            suggestionBox.style.display = 'block';
        } else {
            suggestionBox.style.display = 'none';
        }
    });

    document.addEventListener('click', function(e) {
        if (!suggestionBox.contains(e.target) && e.target !== titleInput) {
            suggestionBox.style.display = 'none';
        }
    });
</script>
@endpush

