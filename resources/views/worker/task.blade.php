@extends('layouts.worker')

@section('content')
    <div class="p-6 md:p-12 max-w-full">

        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4 mb-8 md:mb-10">
            <div>
                <p class="text-sm md:text-base font-medium text-white/70 mb-1 md:mb-2">Manage Your</p>
                <div class="flex items-center gap-3">
                    <h1 class="text-3xl md:text-5xl font-bold text-white">Tasks</h1>
                    <div id="syncStatus" class="text-[10px] md:text-xs transition-all p-1 px-3 rounded-full inline-flex items-center bg-green-500/20 text-green-300 border border-green-500/30">
                        <i class='bx bx-check-double mr-1'></i> Synchronized
                    </div>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <button
                    class="relative w-12 h-12 rounded-full flex items-center justify-center glass-button hover:bg-white/20 transition shadow-lg">
                    <i class='bx bx-bell text-xl text-white'></i>
                    <span
                        class="absolute top-2.5 right-2.5 w-3 h-3 bg-red-500 rounded-full border border-[#428246] animate-pulse"></span>
                </button>
                <button
                    class="w-12 h-12 rounded-full flex items-center justify-center glass-button hover:bg-white/20 transition shadow-lg">
                    <i class='bx bx-search text-xl text-white'></i>
                </button>
            </div>
        </div>

        <!-- Filters and Add Task -->
        <div class="flex flex-wrap gap-2 md:gap-4 mb-8">
            <button
                class="px-4 md:px-6 py-2 md:py-3 bg-green-500/30 text-green-300 border border-green-400/40 rounded-xl font-medium hover:bg-green-500/40 transition text-xs md:text-sm shadow-md">
                All
            </button>
            <button
                class="px-4 md:px-6 py-2 md:py-3 bg-white/10 text-white/70 border border-white/20 rounded-xl font-medium hover:bg-white/20 transition text-xs md:text-sm">
                Pending
            </button>
            <button onclick="showTaskModal()"
                class="ml-auto px-4 md:px-6 py-2 md:py-3 bg-gradient-to-r from-green-500 to-green-600 text-white rounded-xl font-medium hover:from-green-600 hover:to-green-700 transition flex items-center gap-2 text-xs md:text-sm shadow-lg active:scale-95">
                <i class='bx bx-plus text-lg md:text-xl'></i>
                Add Task
            </button>
        </div>

        <!-- Task Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6 mb-8">

            <!-- Task Card 1 -->
            <div class="glass-panel rounded-2xl p-5 md:p-6 hover:bg-white/20 transition cursor-pointer group shadow-lg hover:shadow-xl">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h3 class="text-lg md:text-xl font-semibold text-white mb-1 md:mb-2">Feed Pen 1</h3>
                        <p class="text-xs md:text-sm text-white/60">Morning feeding routine</p>
                    </div>
                    <div class="px-3 py-1 bg-green-500/20 text-green-300 rounded-full text-[10px] md:text-xs font-medium border border-green-500/30">Pending</div>
                </div>

                <div class="space-y-2 md:space-y-3">
                    <div class="flex items-center gap-2 text-white/70 text-xs md:text-sm">
                        <i class='bx bx-time text-base md:text-lg'></i>
                        <span>Today 8:00 AM</span>
                    </div>
                    <div class="flex items-center gap-2 text-white/70 text-xs md:text-sm">
                        <i class='bx bx-user text-base md:text-lg'></i>
                        <span>Assigned to: You</span>
                    </div>
                </div>

                <div class="mt-5 flex gap-2">
                    <button
                        class="flex-1 px-4 py-2.5 bg-green-500/30 text-green-300 border border-green-400/40 rounded-xl font-bold hover:bg-green-500/40 transition text-xs uppercase tracking-wider">
                        Start Task
                    </button>
                    <button
                        class="px-4 py-2.5 bg-white/10 text-white border border-white/20 rounded-xl font-medium hover:bg-white/20 transition text-xs">
                        <i class='bx bx-dots-vertical-rounded'></i>
                    </button>
                </div>
            </div>

            <!-- Task Card 2 (In Progress) -->
            <div class="glass-panel rounded-2xl p-5 md:p-6 hover:bg-white/20 transition cursor-pointer group shadow-lg border-l-4 border-l-blue-400">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h3 class="text-lg md:text-xl font-semibold text-white mb-1 md:mb-2">Water Check - Pen 5</h3>
                        <p class="text-xs md:text-sm text-white/60">Check water levels and refill</p>
                    </div>
                    <div class="px-3 py-1 bg-blue-500/20 text-blue-300 rounded-full text-[10px] md:text-xs font-medium border border-blue-500/30">Working</div>
                </div>

                <div class="mt-5 flex gap-2">
                    <button
                        class="flex-1 px-4 py-2.5 bg-blue-500/30 text-blue-300 border border-blue-400/40 rounded-xl font-bold hover:bg-blue-500/40 transition text-xs uppercase tracking-wider">
                        Continue
                    </button>
                    <button
                        class="px-4 py-2.5 bg-white/10 text-white border border-white/20 rounded-xl font-medium hover:bg-white/20 transition text-xs">
                        <i class='bx bx-dots-vertical-rounded'></i>
                    </button>
                </div>
            </div>

        </div>

        <!-- Task Summary -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6">
            <div class="glass-panel rounded-2xl p-5 md:p-6 shadow-md">
                <p class="text-[10px] md:text-sm font-medium text-white/70 mb-2 uppercase tracking-tight">Total Tasks</p>
                <h3 class="text-2xl md:text-4xl font-bold text-white">8</h3>
            </div>
            <div class="glass-panel rounded-2xl p-5 md:p-6 shadow-md">
                <p class="text-[10px] md:text-sm font-medium text-white/70 mb-2 uppercase tracking-tight">Completed</p>
                <h3 class="text-2xl md:text-4xl font-bold text-emerald-400">3</h3>
            </div>
        </div>
    </div>

    <!-- Create Task Modal -->
    <div id="taskModal" class="fixed inset-0 z-[200] hidden bg-[#0a180e]/80 backdrop-blur-xl flex items-center justify-center p-4">
        <div class="glass-panel w-full max-w-lg rounded-[2.5rem] overflow-hidden shadow-2xl border border-white/10">
            <div class="p-8 pb-4 flex justify-between items-center">
                <div>
                    <h2 class="text-2xl font-bold text-white">Create New Task</h2>
                    <p class="text-white/40 text-[10px] uppercase font-bold tracking-widest mt-1">Manual Activity Log</p>
                </div>
                <button onclick="hideTaskModal()" class="w-10 h-10 rounded-full bg-white/5 text-white/60 flex items-center justify-center hover:bg-white/10">
                    <i class='bx bx-x text-2xl'></i>
                </button>
            </div>
            <div class="p-8 pt-4 space-y-6">
                <div>
                    <label class="block text-[10px] font-bold text-white/40 uppercase tracking-widest mb-3">Task Name</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-white/40"><i class='bx bx-task text-xl'></i></span>
                        <input type="text" id="taskTitle" placeholder="e.g. Health Checkup" 
                               class="w-full bg-white/5 border border-white/10 rounded-2xl py-4 pl-12 pr-4 text-white focus:outline-none focus:border-green-500/50 transition">
                    </div>
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-white/40 uppercase tracking-widest mb-3">Pen Location</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-white/40"><i class='bx bx-map-pin text-xl'></i></span>
                        <select id="taskPen" class="w-full bg-white/5 border border-white/10 rounded-2xl py-4 pl-12 pr-4 text-white focus:outline-none focus:border-green-500/50 transition appearance-none">
                            <option value="Pen 1">Pen 1</option>
                            <option value="Pen 5">Pen 5</option>
                            <option value="Pen A1">Pen A1</option>
                        </select>
                    </div>
                </div>
                <button onclick="submitTask()" class="w-full bg-green-500 text-white py-5 rounded-3xl font-bold text-lg hover:bg-green-600 transition shadow-lg">Create Task Now</button>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function showTaskModal() {
            document.getElementById('taskModal').classList.remove('hidden');
            document.getElementById('taskModal').classList.add('flex');
        }
        function hideTaskModal() {
            document.getElementById('taskModal').classList.add('hidden');
            document.getElementById('taskModal').classList.remove('flex');
        }
        function submitTask() {
            const title = document.getElementById('taskTitle').value;
            if(!title) return;
            Swal.fire({ title: 'Task Added!', text: title + ' created.', icon: 'success', background: '#1a3a1a', color: '#fff' });
            hideTaskModal();
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
@endsection
