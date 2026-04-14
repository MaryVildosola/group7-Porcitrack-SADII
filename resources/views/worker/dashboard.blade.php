@extends('layouts.worker')

@section('content')
    <div class="p-6 md:p-12 max-w-full">

        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4 mb-8 md:mb-10">
            <div>
                <p class="text-sm md:text-base font-medium text-white/70 mb-1 md:mb-2">Welcome Back,</p>
                <h1 class="text-3xl md:text-5xl font-bold text-white tracking-tight">{{ Auth::user()->name }}</h1>
            </div>
            
            <!-- Sync Status Button -->
            <div id="syncStatus" class="flex items-center gap-3 bg-white/10 backdrop-blur-md px-4 py-2 rounded-2xl border border-white/10 self-start md:self-center cursor-pointer hover:bg-white/20 transition" onclick="syncData()">
                <div class="w-2 h-2 rounded-full bg-green-500 shadow-[0_0_10px_rgba(34,197,94,0.6)] animate-pulse"></div>
                <span class="text-white text-xs md:text-sm font-bold uppercase tracking-widest">Online / Synced</span>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-10">
            <!-- Active Tasks -->
            <div class="glass-panel p-6 rounded-3xl relative overflow-hidden group hover:bg-white/15 transition cursor-pointer" onclick="window.location='{{ route('worker.tasks') }}'">
                <div class="flex flex-col relative z-20">
                    <span class="text-white/40 text-xs font-bold uppercase tracking-widest mb-2">Active Tasks</span>
                    <span class="text-4xl font-bold text-white">08</span>
                </div>
                <i class='bx bx-list-check absolute bottom-[-10px] right-[-10px] md:bottom-[-20px] md:right-[-20px] text-6xl md:text-8xl text-white/10 group-hover:scale-110 transition duration-500'></i>
            </div>

            <!-- Animals to Monitor -->
            <div class="glass-panel p-6 rounded-3xl relative overflow-hidden group hover:bg-white/15 transition cursor-pointer">
                <div class="flex flex-col relative z-20">
                    <span class="text-white/40 text-xs font-bold uppercase tracking-widest mb-2">Animals</span>
                    <span class="text-4xl font-bold text-white">452</span>
                </div>
                <i class='bx bxs-dog absolute bottom-[-10px] right-[-10px] md:bottom-[-20px] md:right-[-20px] text-6xl md:text-8xl text-white/10 group-hover:scale-110 transition duration-500'></i>
            </div>

            <!-- Alerts -->
            <div class="glass-panel p-6 rounded-3xl relative overflow-hidden group hover:bg-white/15 transition cursor-pointer border-l-4 border-red-500/50" onclick="window.location='{{ route('worker.alerts') }}'">
                <div class="flex flex-col relative z-20">
                    <span class="text-white/40 text-xs font-bold uppercase tracking-widest mb-2">Alerts</span>
                    <span class="text-4xl font-bold text-red-400">03</span>
                </div>
                <i class='bx bxs-bell absolute bottom-[-10px] right-[-10px] md:bottom-[-20px] md:right-[-20px] text-6xl md:text-8xl text-red-500/10 group-hover:scale-110 transition duration-500'></i>
            </div>

            <!-- Feed Status -->
            <div class="glass-panel p-6 rounded-3xl relative overflow-hidden group hover:bg-white/15 transition cursor-pointer">
                <div class="flex flex-col relative z-20">
                    <span class="text-white/40 text-xs font-bold uppercase tracking-widest mb-2">Feed Stock</span>
                    <span class="text-4xl font-bold text-green-400">78%</span>
                </div>
                <i class='bx bxs-bowl-rice absolute bottom-[-10px] right-[-10px] md:bottom-[-20px] md:right-[-20px] text-6xl md:text-8xl text-green-500/10 group-hover:scale-110 transition duration-500'></i>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="flex flex-col md:flex-row gap-4 mb-10">
            <button onclick="startQRScanner()" class="flex-1 glass-panel p-6 rounded-3xl flex items-center justify-center gap-4 hover:bg-green-500/20 transition group border border-green-500/20 shadow-lg shadow-green-500/5">
                <div class="w-12 h-12 rounded-2xl bg-green-500/20 flex items-center justify-center group-hover:scale-110 transition">
                    <i class='bx bx-qr-scan text-2xl text-green-400'></i>
                </div>
                <div class="text-left">
                    <p class="text-white font-bold text-lg">Scan QR Code</p>
                    <p class="text-white/40 text-xs uppercase tracking-wider font-semibold">Immediate Monitoring</p>
                </div>
            </button>
            <button onclick="showTaskModal()" class="flex-1 glass-panel p-6 rounded-3xl flex items-center justify-center gap-4 hover:bg-blue-500/20 transition group border border-blue-500/20 shadow-lg shadow-blue-500/5">
                <div class="w-12 h-12 rounded-2xl bg-blue-500/20 flex items-center justify-center group-hover:scale-110 transition">
                    <i class='bx bx-plus text-2xl text-blue-400'></i>
                </div>
                <div class="text-left">
                    <p class="text-white font-bold text-lg">Create Task</p>
                    <p class="text-white/40 text-xs uppercase tracking-wider font-semibold">Log Activity</p>
                </div>
            </button>
        </div>

        <!-- Activity Timeline -->
        <div class="space-y-6">
            <div class="flex items-center justify-between mb-2">
                <h2 class="text-xl md:text-2xl font-bold text-white">Recent Activity</h2>
                <a href="{{ route('worker.activity-log') }}" class="text-xs text-white/40 hover:text-white transition uppercase font-bold tracking-widest">View All</a>
            </div>
            
            <div class="glass-panel rounded-3xl p-5 md:p-6 hover:bg-white/10 transition cursor-pointer group">
                <div class="flex gap-4">
                    <div class="w-10 h-10 md:w-12 md:h-12 rounded-2xl bg-green-500/20 flex items-center justify-center border border-green-500/30">
                        <i class='bx bxs-bowl-rice text-green-400 text-lg md:text-xl'></i>
                    </div>
                    <div class="flex-1">
                        <div class="flex justify-between items-start mb-1">
                            <h3 class="text-base md:text-lg font-bold text-white">Pen 5 Feeding</h3>
                            <span class="text-[10px] md:text-xs text-white/40 font-medium">2:30 PM</span>
                        </div>
                        <p class="text-white/60 text-xs md:text-sm mb-3">5kg of grower mix distributed. All pigs active.</p>
                        <div class="flex gap-2">
                            <span class="px-2 py-0.5 bg-green-500/20 text-green-300 rounded-md text-[9px] md:text-[10px] font-bold border border-green-500/20 uppercase tracking-widest">Success</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- QR Scanner Modal -->
    <div id="qrModal" class="fixed inset-0 z-[200] hidden bg-black/90 backdrop-blur-xl flex flex-col items-center justify-center p-6">
        <div class="w-full max-w-sm">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-white">Scan QR</h2>
                <button onclick="stopQRScanner()" class="w-10 h-10 rounded-full bg-white/10 text-white flex items-center justify-center hover:bg-white/20">
                    <i class='bx bx-x text-2xl'></i>
                </button>
            </div>
            <div id="qr-reader" class="rounded-3xl overflow-hidden border-2 border-green-500/50 shadow-2xl shadow-green-500/20 bg-black"></div>
            <p class="text-white/40 text-center mt-6 text-sm">Align the QR code within the frame to scan</p>
        </div>
    </div>

    <!-- Create Task Modal (Valex Style for Workers) -->
    <div id="taskModal" class="fixed inset-0 z-[200] hidden bg-[#0a180e]/80 backdrop-blur-xl flex items-center justify-center p-4">
        <div class="glass-panel w-full max-w-lg rounded-[2.5rem] overflow-hidden shadow-2xl border border-white/10 animate-fade-in">
            <div class="p-8 pb-4">
                <div class="flex justify-between items-center">
                    <div>
                        <h2 class="text-2xl font-bold text-white">Create New Task</h2>
                        <p class="text-white/40 text-xs uppercase tracking-widest font-bold mt-1">Worker Log Entry</p>
                    </div>
                    <button onclick="hideTaskModal()" class="w-10 h-10 rounded-full bg-white/5 text-white/60 flex items-center justify-center hover:bg-white/10 transition">
                        <i class='bx bx-x text-2xl'></i>
                    </button>
                </div>
            </div>

            <div class="p-8 pt-4 space-y-6">
                <!-- Task Title -->
                <div>
                    <label class="block text-xs font-bold text-white/40 uppercase tracking-widest mb-3">Task Name</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-white/40">
                            <i class='bx bx-task text-xl'></i>
                        </span>
                        <input type="text" id="taskTitle" placeholder="e.g. Pen 5 Feeding" 
                               class="w-full bg-white/5 border border-white/10 rounded-2xl py-4 pl-12 pr-4 text-white focus:outline-none focus:border-green-500/50 transition font-medium">
                    </div>
                </div>

                <!-- Pen Selection -->
                <div>
                    <label class="block text-xs font-bold text-white/40 uppercase tracking-widest mb-3">Target Pen</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-white/40">
                            <i class='bx bx-grid-alt text-xl'></i>
                        </span>
                        <select id="taskPen" class="w-full bg-white/5 border border-white/10 rounded-2xl py-4 pl-12 pr-10 text-white focus:outline-none focus:border-green-500/50 transition font-medium appearance-none">
                            <option value="Pen 1">Pen 1 (Piglets)</option>
                            <option value="Pen 5">Pen 5 (Fattening)</option>
                            <option value="Pen 12">Pen 12 (Breeding)</option>
                        </select>
                        <span class="absolute right-4 top-1/2 -translate-y-1/2 text-white/40 pointer-events-none">
                            <i class='bx bx-chevron-down text-xl'></i>
                        </span>
                    </div>
                </div>

                <!-- Action Button -->
                <div class="pt-4">
                    <button onclick="submitTask()" 
                            class="w-full bg-gradient-to-r from-green-500 to-green-600 text-white py-5 rounded-[1.5rem] font-bold text-lg hover:shadow-[0_10px_30px_rgba(34,197,94,0.3)] transition active:scale-[0.98]">
                        Confirm & Create Task
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://unpkg.com/html5-qrcode"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // --- Task Modal ---
        function showTaskModal() {
            document.getElementById('taskModal').classList.remove('hidden');
            document.getElementById('taskModal').classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        function hideTaskModal() {
            document.getElementById('taskModal').classList.add('hidden');
            document.getElementById('taskModal').classList.remove('flex');
            document.body.style.overflow = 'auto';
        }

        function submitTask() {
            const title = document.getElementById('taskTitle').value;
            const pen = document.getElementById('taskPen').value;
            
            if(!title) {
                Swal.fire({
                    title: 'Missing Info',
                    text: 'Please enter a task name.',
                    icon: 'error',
                    background: '#0a180e',
                    color: '#fff',
                    confirmButtonColor: '#22c55e'
                });
                return;
            }

            Swal.fire({
                title: 'Task Created!',
                text: `${title} for ${pen} has been logged.`,
                icon: 'success',
                background: '#0a180e',
                color: '#fff',
                confirmButtonColor: '#22c55e'
            }).then(() => {
                hideTaskModal();
                document.getElementById('taskTitle').value = '';
            });
        }

        // --- QR Scanner ---
        let html5QrcodeScanner = null;

        function startQRScanner() {
            document.getElementById('qrModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            
            const config = { 
                fps: 10, 
                qrbox: { width: 250, height: 250 },
                aspectRatio: 1.0
            };

            html5QrcodeScanner = new Html5Qrcode("qr-reader");
            html5QrcodeScanner.start(
                { facingMode: "environment" }, 
                config,
                onScanSuccess
            ).catch(err => {
                console.error("Camera access failed", err);
                Swal.fire({
                    title: 'Camera Error',
                    text: 'Unable to access your camera. Please check permissions.',
                    icon: 'error',
                    background: '#0a180e',
                    color: '#fff'
                });
                stopQRScanner();
            });
        }

        function stopQRScanner() {
            if (html5QrcodeScanner) {
                html5QrcodeScanner.stop().then(() => {
                    document.getElementById('qrModal').classList.add('hidden');
                    document.body.style.overflow = 'auto';
                }).catch(err => console.error(err));
            } else {
                document.getElementById('qrModal').classList.add('hidden');
                document.body.style.overflow = 'auto';
            }
        }

        function onScanSuccess(decodedText, decodedResult) {
            stopQRScanner();
            Swal.fire({
                title: 'Code Scanned!',
                text: `Identification: ${decodedText}`,
                icon: 'success',
                background: '#0a180e',
                color: '#fff',
                confirmButtonColor: '#22c55e'
            });
        }

        // --- Sync Mock ---
        function syncData() {
            const statusBtn = document.getElementById('syncStatus');
            statusBtn.innerHTML = `
                <i class='bx bx-loader-alt animate-spin text-white'></i>
                <span class="text-white text-xs md:text-sm font-bold uppercase tracking-widest">Syncing...</span>
            `;
            
            setTimeout(() => {
                statusBtn.innerHTML = `
                    <div class="w-2 h-2 rounded-full bg-green-500 shadow-[0_0_10px_rgba(34,197,94,0.6)] animate-pulse"></div>
                    <span class="text-white text-xs md:text-sm font-bold uppercase tracking-widest">Online / Synced</span>
                `;
            }, 2000);
        }
    </script>
@endsection
