@extends('layouts.worker')

@section('content')
    <div class="p-6 md:p-12 max-w-full">

        <!-- Header Section -->
        <div class="mb-8 md:mb-10 w-full md:w-2/3 lg:w-1/2">
            <p class="text-sm md:text-base font-medium text-white/70 mb-1 md:mb-2">Your Daily Goals</p>
            <h1 class="text-3xl md:text-5xl font-bold text-white tracking-tight">Farm Tasks</h1>
        </div>

        <!-- Task Summary -->
        <div class="flex flex-row gap-4 mb-8 overflow-x-auto pb-2 no-scrollbar">
            <div class="glass-panel min-w-[140px] rounded-2xl p-4 shadow-sm border border-white/10 bg-white/5">
                <p class="text-[9px] font-bold text-white/40 mb-1 uppercase tracking-[0.2em]">Pending</p>
                <div class="flex items-end gap-2">
                    <h3 class="text-3xl font-black text-white leading-none">{{ $tasks->count() }}</h3>
                    <span class="text-[9px] text-white/40 mb-1 font-bold">Tasks</span>
                </div>
            </div>
            <div class="glass-panel min-w-[140px] rounded-2xl p-4 shadow-sm border border-white/10 bg-white/5">
                <p class="text-[9px] font-bold text-white/40 mb-1 uppercase tracking-[0.2em]">Recently</p>
                <div class="flex items-end gap-2">
                    <h3 class="text-3xl font-black text-emerald-400 leading-none">{{ $completedTasks->count() }}</h3>
                    <span class="text-[9px] text-emerald-400/60 mb-1 font-bold">Done</span>
                </div>
            </div>
        </div>

        <div class="flex flex-wrap gap-2 md:gap-4 mb-8 h-full">
            <button onclick="filterTasks('All')"
                class="px-4 md:px-6 py-2 md:py-3 bg-green-500/20 text-green-300 border border-green-500/30 rounded-xl font-medium hover:bg-green-500/30 transition text-xs md:text-sm shadow-md">
                All Tasks
            </button>
            <button onclick="filterTasks('Today')"
                class="px-4 md:px-6 py-2 md:py-3 bg-white/10 text-white/70 border border-white/20 rounded-xl font-medium hover:bg-white/20 transition text-xs md:text-sm">
                Today
            </button>
            <button onclick="filterTasks('Overdue')"
                class="px-4 md:px-6 py-2 md:py-3 bg-white/10 text-white/70 border border-white/20 rounded-xl font-medium hover:bg-white/20 transition text-xs md:text-sm">
                Overdue
            </button>
            <button onclick="filterTasks('Completed')"
                class="px-4 md:px-6 py-2 md:py-3 bg-white/10 text-white/70 border border-white/20 rounded-xl font-medium hover:bg-white/20 transition text-xs md:text-sm">
                Completed
            </button>
        </div>

        <!-- Task Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
            @forelse($tasks as $task)
                <div onclick="openTaskDetail('{{ $task->title }}', '{{ $task->description }}', '{{ route('worker.tasks.complete', $task) }}')" 
                     class="glass-panel rounded-2xl p-5 hover:bg-white/10 transition cursor-pointer group shadow-sm border border-white/10 active:scale-[0.98]">
                    <div class="flex justify-between items-start mb-3">
                        <div>
                            <h3 class="text-lg font-bold text-white mb-1">{{ $task->title }}</h3>
                            <p class="text-[10px] text-white/50 leading-relaxed">{{ Str::limit($task->description, 50) }}</p>
                        </div>
                        <div class="px-2 py-1 bg-amber-500/20 text-amber-300 rounded-lg text-[8px] font-bold border border-amber-500/30 uppercase tracking-widest">Pending</div>
                    </div>

                    <div class="flex items-center gap-4 mb-5">
                        <div class="flex items-center gap-2 text-white/50 text-[10px] font-medium">
                            <i class='bx bx-calendar text-emerald-400'></i>
                            <span>{{ $task->due_date->format('M d') }}</span>
                        </div>
                        @if($task->pen_id)
                        <div class="flex items-center gap-2 text-white/50 text-[10px] font-medium">
                            <i class='bx bx-map-pin text-emerald-400'></i>
                            <span>{{ $task->pen->name }}</span>
                        </div>
                        @endif
                    </div>

                    <button class="w-full py-3 bg-white/5 text-white/70 rounded-xl font-bold text-[10px] uppercase tracking-widest hover:bg-white/10 transition border border-white/10">
                        Start Task
                    </button>
                </div>
            @empty
                <div class="col-span-2 py-12 text-center">
                    <i class='bx bx-check-double text-5xl text-white/10 mb-4'></i>
                    <p class="text-white/40 text-sm">All caught up! No tasks assigned.</p>
                </div>
            @endforelse
        </div>

        @if($completedTasks->count() > 0)
        <h2 class="text-xs font-black text-white/40 uppercase tracking-[0.2em] mb-4">Recently Completed</h2>
        <div class="space-y-3 mb-8">
            @foreach($completedTasks as $completed)
            <div class="glass-panel rounded-3xl p-5 md:p-6 border-l-4 border-green-500 hover:bg-white/10 transition cursor-pointer shadow-lg group">
                <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-4">
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-10 h-10 rounded-2xl bg-white/5 flex items-center justify-center border border-white/10">
                                <i class='bx bxs-bowl-rice text-green-400 text-lg'></i>
                            </div>
                            <div>
                                <h4 class="text-base md:text-lg font-bold text-white">{{ $completed->title }}</h4>
                                <p class="text-[10px] md:text-sm text-white/40 uppercase tracking-widest">Done {{ $completed->completed_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif

    <!-- Create Task Modal -->
    <div id="taskModal" class="fixed inset-0 z-[200] hidden bg-[#0a180e]/90 backdrop-blur-2xl flex items-center justify-center p-4 overflow-y-auto">
        <div class="glass-panel w-full max-w-lg rounded-[3rem] overflow-hidden shadow-2xl border border-white/10 animate-fade-in my-auto">
            <div class="p-8 pb-4 flex justify-between items-center border-b border-white/5">
                <div>
                    <h2 class="text-2xl font-black text-white">Create New Task</h2>
                    <p class="text-white/40 text-[10px] uppercase font-bold tracking-[0.2em] mt-1">Worker Log Entry</p>
                </div>
                <button onclick="hideTaskModal()" class="w-12 h-12 rounded-2xl bg-white/5 text-white/60 flex items-center justify-center hover:bg-white/10 transition">
                    <i class='bx bx-x text-3xl'></i>
                </button>
            </div>
            <div class="p-8 pt-6 space-y-6">
                <div>
                    <label class="block text-[10px] font-black text-white/40 uppercase tracking-[0.2em] mb-3">Task Description</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-white/40"><i class='bx bx-task text-xl'></i></span>
                        <input type="text" id="taskTitle" placeholder="e.g. Regular Health Check" 
                               class="w-full bg-white/5 border border-white/10 rounded-2xl py-4 pl-12 pr-4 text-white focus:outline-none focus:border-green-500/50 transition font-medium">
                    </div>
                </div>
                <div>
                    <label class="block text-[10px] font-black text-white/40 uppercase tracking-[0.2em] mb-3">Location / Pen</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-white/40"><i class='bx bx-map-pin text-xl'></i></span>
                        <select id="taskPen" class="w-full bg-white/5 border border-white/10 rounded-2xl py-4 pl-12 pr-4 text-white focus:outline-none focus:border-green-500/50 transition appearance-none font-medium">
                            <option value="Pen 1" class="bg-[#0a180e]">Pen 1 (Piglets)</option>
                            <option value="Pen 5" class="bg-[#0a180e]">Pen 5 (Fattening)</option>
                            <option value="Pen 12" class="bg-[#0a180e]">Pen 12 (Breeding)</option>
                        </select>
                        <i class='bx bx-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-white/40'></i>
                    </div>
                </div>
                <button onclick="submitTask()" class="w-full bg-gradient-to-r from-green-500 to-green-600 text-white py-5 rounded-[2rem] font-black text-lg hover:shadow-[0_10px_30px_rgba(34,197,94,0.3)] transition active:scale-[0.98]">Confirm & Create</button>
            </div>
        </div>
    </div>

    <!-- Task Detail & Checklist Modal -->
    <div id="taskDetailModal" class="fixed inset-0 z-[210] hidden bg-[#0a180e]/95 backdrop-blur-3xl flex items-center justify-center p-4 overflow-y-auto">
        <div class="glass-panel w-full max-w-lg rounded-[3rem] overflow-hidden shadow-2xl border border-white/10 animate-fade-in my-auto">
            <!-- Modal Header -->
            <div class="p-8 pb-6 border-b border-white/5 relative">
                <div class="flex justify-between items-start mb-4">
                    <div id="taskStatusBadge" class="px-3 py-1 bg-green-500/20 text-green-300 rounded-full text-[10px] font-bold border border-green-500/30 uppercase tracking-widest">Pending</div>
                    <button onclick="hideTaskDetail()" class="w-12 h-12 rounded-2xl bg-white/5 text-white/60 flex items-center justify-center hover:bg-white/10 transition">
                        <i class='bx bx-x text-3xl'></i>
                    </button>
                </div>
                <h2 id="detailTaskTitle" class="text-3xl font-black text-white tracking-tight">Feed Pen 1</h2>
                <p id="detailTaskDesc" class="text-white/50 text-sm mt-2 leading-relaxed font-medium">Morning feeding routine for the piglets in Pen 1. Ensure they get the starter mix.</p>
            </div>

            <!-- Modal Content -->
            <div class="p-8 pt-6 space-y-8">
                <!-- Progress Section -->
                <div>
                    <div class="flex justify-between items-end mb-3">
                        <label class="text-[10px] font-black text-white/40 uppercase tracking-[0.2em]">Completion Progress</label>
                        <span id="progressPercent" class="text-xl font-black text-green-400">0%</span>
                    </div>
                    <div class="w-full h-3 bg-white/5 rounded-full overflow-hidden border border-white/10">
                        <div id="progressBar" class="h-full bg-gradient-to-r from-green-500 to-emerald-400 transition-all duration-500 shadow-[0_0_15px_rgba(34,197,94,0.5)]" style="width: 0%"></div>
                    </div>
                </div>

                <!-- Checklist Section -->
                <div>
                    <label class="block text-[10px] font-black text-white/40 uppercase tracking-[0.2em] mb-5">Required Steps</label>
                    <div id="checklistItems" class="space-y-3">
                        <!-- Dynamic items here -->
                    </div>
                </div>

                <!-- Complete Button -->
                <div class="pt-4">
                    <button id="completeTaskBtn" onclick="markTaskComplete()" disabled
                            class="w-full bg-white/5 text-white/20 py-5 rounded-[2rem] font-black text-lg border border-white/5 transition-all duration-300 cursor-not-allowed">
                        <i class='bx bx-check-circle text-2xl'></i> Complete Task
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // --- Task Detail Logic ---
        let currentCompletionUrl = '';

        function openTaskDetail(title, desc, completionUrl) {
            document.getElementById('detailTaskTitle').innerText = title;
            document.getElementById('detailTaskDesc').innerText = desc;
            currentCompletionUrl = completionUrl;
            
            document.getElementById('taskDetailModal').classList.remove('hidden');
            document.getElementById('taskDetailModal').classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        function hideTaskDetail() {
            document.getElementById('taskDetailModal').classList.add('hidden');
            document.getElementById('taskDetailModal').classList.remove('flex');
            document.body.style.overflow = 'auto';
        }

        function markTaskComplete() {
            if(!currentCompletionUrl) return;

            // Create a temporary form to submit the completion
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = currentCompletionUrl;
            
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            
            form.appendChild(csrfToken);
            document.body.appendChild(form);
            
            Swal.fire({
                title: 'Mark as Done?',
                text: 'This will record your work in the farm logs.',
                icon: 'question',
                showCancelButton: true,
                background: '#0a180e',
                color: '#fff',
                confirmButtonColor: '#22c55e',
                confirmButtonText: 'Yes, Complete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }

        function showNotifications() {
            Swal.fire({
                title: 'Notifications',
                html: '<div class="text-left space-y-4"><div class="p-3 bg-white/5 rounded-xl"><p class="text-xs font-bold text-green-400">BATCH UPDATE</p><p class="text-sm">Batch #22 has been moved to Pen 5.</p></div><div class="p-3 bg-white/5 rounded-xl"><p class="text-xs font-bold text-red-400">ALERT</p><p class="text-sm">Temperature spike in Pen 3.</p></div></div>',
                icon: 'info',
                background: '#0a180e',
                color: '#fff',
                confirmButtonColor: '#22c55e'
            });
        }

        function showSearch() {
            Swal.fire({
                title: 'Search Focus',
                input: 'text',
                inputPlaceholder: 'Search tasks, pens, or animals...',
                background: '#0a180e',
                color: '#fff',
                confirmButtonColor: '#22c55e',
                customClass: {
                    input: 'bg-white/5 border-white/10 text-white border rounded-xl'
                }
            });
        }

        function filterTasks(type) {
             Swal.fire({ title: 'Filter Applied', text: 'Showing ' + type + ' tasks.', icon: 'info', timer: 1000, showConfirmButton: false, background: '#0a180e', color: '#fff' });
        }

        function actionTask(name, action) {
            Swal.fire({ title: 'Task Update', text: 'Task "' + name + '" ' + action + '.', icon: 'success', background: '#0a180e', color: '#fff', confirmButtonColor: '#22c55e' });
        }

        // Sync Logic
        function updateSyncStatus() {
            const statusEl = document.getElementById('syncStatus');
            if (navigator.onLine) {
                statusEl.innerHTML = "<i class='bx bx-check-double mr-1'></i> Synchronized";
                statusEl.className = "text-[10px] md:text-xs transition-all p-1 px-3 rounded-full inline-flex items-center bg-green-500/20 text-green-300 border border-green-500/30";
            } else {
                statusEl.innerHTML = "<i class='bx bx-cloud-off mr-1'></i> Offline Mode";
                statusEl.className = "text-[10px] md:text-xs transition-all p-1 px-3 rounded-full inline-flex items-center bg-yellow-500/20 text-yellow-300 border border-yellow-500/30";
            }
        }
        window.addEventListener('online', updateSyncStatus);
        window.addEventListener('offline', updateSyncStatus);
        updateSyncStatus();
    </script>

    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: scale(0.95); }
            to { opacity: 1; transform: scale(1); }
        }
        .animate-fade-in {
            animation: fadeIn 0.3s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
        .animate-spin-slow {
            animation: spin 3s linear infinite;
        }
        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
@endsection
