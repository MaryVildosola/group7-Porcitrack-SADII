@extends('layouts.worker')

@section('content')
    <div class="p-6 md:p-12 max-w-full">

        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4 mb-8 md:mb-10">
            <div class="flex-1">
                <p class="text-sm md:text-base font-medium text-white/70 mb-1 md:mb-2">Welcome Back,</p>
                <div class="flex items-center gap-4">
                    <h1 class="text-3xl md:text-5xl font-bold text-white tracking-tight">{{ Auth::user()->name }}</h1>
                    <div id="syncStatus" class="hidden md:flex items-center gap-3 bg-white/10 backdrop-blur-md px-4 py-2 rounded-2xl border border-white/10 cursor-pointer hover:bg-white/20 transition" onclick="syncData()">
                        <div class="w-2 h-2 rounded-full bg-green-500 shadow-[0_0_10px_rgba(34,197,94,0.6)] animate-pulse"></div>
                        <span class="text-white text-[10px] font-bold uppercase tracking-widest leading-none">Synced</span>
                    </div>
                </div>
            </div>
            
            <div class="flex items-center gap-3">
                 <!-- Mobile Sync (only shows on mobile) -->
                <div class="md:hidden flex items-center gap-3 bg-white/10 backdrop-blur-md px-4 py-2 rounded-2xl border border-white/10 cursor-pointer" onclick="syncData()">
                    <div class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></div>
                    <span class="text-white text-[10px] font-bold uppercase tracking-widest">Synced</span>
                </div>

                <button onclick="showNotifications()" class="relative w-12 h-12 rounded-full flex items-center justify-center glass-button hover:bg-white/20 transition shadow-lg">
                    <i class='bx bx-bell text-xl text-white'></i>
                    <span class="absolute top-2.5 right-2.5 w-3 h-3 bg-red-500 rounded-full border border-[#428246] animate-pulse"></span>
                </button>
                <button onclick="showSearch()" class="w-12 h-12 rounded-full flex items-center justify-center glass-button hover:bg-white/20 transition shadow-lg">
                    <i class='bx bx-search text-xl text-white'></i>
                </button>
            </div>
        </div>

        <!-- Quick Actions (Shows first on mobile) -->
        <div class="flex flex-col md:flex-row gap-4 mb-8 order-first">
            <button onclick="startQRScanner()" class="flex-1 glass-panel p-6 rounded-3xl flex items-center justify-center gap-4 hover:bg-green-500/20 transition group border border-green-500/20 shadow-lg shadow-green-500/5 active:scale-95">
                <div class="w-12 h-12 rounded-2xl bg-green-500/20 flex items-center justify-center group-hover:scale-110 transition">
                    <i class='bx bx-qr-scan text-2xl text-green-400'></i>
                </div>
                <div class="text-left">
                    <p class="text-white font-bold text-lg">Scan QR Code</p>
                    <p class="text-white/40 text-xs uppercase tracking-wider font-semibold">Immediate Monitoring</p>
                </div>
            </button>
            <button onclick="showTaskModal()" class="flex-1 glass-panel p-6 rounded-3xl flex items-center justify-center gap-4 hover:bg-blue-500/20 transition group border border-blue-500/20 shadow-lg shadow-blue-500/5 active:scale-95">
                <div class="w-12 h-12 rounded-2xl bg-blue-500/20 flex items-center justify-center group-hover:scale-110 transition">
                    <i class='bx bx-plus text-2xl text-blue-400'></i>
                </div>
                <div class="text-left">
                    <p class="text-white font-bold text-lg">Create Task</p>
                    <p class="text-white/40 text-xs uppercase tracking-wider font-semibold">Log Activity</p>
                </div>
            </button>
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
            <div class="glass-panel p-6 rounded-3xl relative overflow-hidden group hover:bg-white/15 transition cursor-pointer" onclick="showAnimalSummary()">
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
            <div class="glass-panel p-6 rounded-3xl relative overflow-hidden group hover:bg-white/15 transition cursor-pointer" onclick="showFeedSummary()">
                <div class="flex flex-col relative z-20">
                    <span class="text-white/40 text-xs font-bold uppercase tracking-widest mb-2">Feed Stock</span>
                    <span class="text-4xl font-bold text-green-400">78%</span>
                </div>
                <i class='bx bxs-bowl-rice absolute bottom-[-10px] right-[-10px] md:bottom-[-20px] md:right-[-20px] text-6xl md:text-8xl text-green-500/10 group-hover:scale-110 transition duration-500'></i>
            </div>
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
    <div id="qrModal" class="fixed inset-0 z-[200] hidden bg-black/95 backdrop-blur-2xl flex flex-col items-center justify-center p-6">
        <div class="w-full max-w-sm">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h2 class="text-3xl font-black text-white tracking-tight">Scanner</h2>
                    <p class="text-green-400 text-[10px] uppercase font-bold tracking-[0.2em] mt-1">Operational ID Check</p>
                </div>
                <button onclick="stopQRScanner()" class="w-14 h-14 rounded-2xl bg-white/10 text-white flex items-center justify-center hover:bg-white/20 transition-all active:scale-90">
                    <i class='bx bx-x text-3xl'></i>
                </button>
            </div>
            <div class="relative group">
                <div class="absolute -inset-1 bg-gradient-to-r from-green-500 to-emerald-500 rounded-[2.5rem] blur opacity-25 group-hover:opacity-50 transition duration-1000 group-hover:duration-200"></div>
                <div id="qr-reader" class="relative rounded-[2.5rem] overflow-hidden border-2 border-white/10 bg-black aspect-square"></div>
                
                <!-- Scanner Overlay -->
                <div class="absolute inset-0 border-[40px] border-black/40 pointer-events-none"></div>
                <div class="absolute inset-x-0 top-1/2 -translate-y-1/2 h-0.5 bg-green-500/50 shadow-[0_0_15px_rgba(34,197,94,0.8)] animate-pulse"></div>
            </div>
            <div class="mt-8 text-center space-y-2">
                <p class="text-white font-bold">Waiting for ID...</p>
                <p class="text-white/40 text-xs px-6 leading-relaxed">Position a Pen QR or Ear Tag within the frame to automatically trigger the log entry.</p>
            </div>
        </div>
    </div>

    <!-- Routine Feeding Form Modal (Batch) -->
    <div id="feedingModal" class="fixed inset-0 z-[210] hidden bg-[#0a180e]/95 backdrop-blur-3xl flex items-center justify-center p-4">
        <div class="glass-panel w-full max-w-lg rounded-[3rem] overflow-hidden shadow-2xl border border-white/10 animate-fade-in my-auto">
            <div class="p-8 pb-6 border-b border-white/5 relative">
                <div class="flex justify-between items-start mb-4">
                    <div id="feedingBadge" class="px-3 py-1 bg-green-500/20 text-green-300 rounded-full text-[10px] font-bold border border-green-500/30 uppercase tracking-widest">Pen ID: <span id="targetPenId">--</span></div>
                    <button onclick="closeFeedingModal()" class="w-12 h-12 rounded-2xl bg-white/5 text-white/60 flex items-center justify-center hover:bg-white/10 transition">
                        <i class='bx bx-x text-3xl'></i>
                    </button>
                </div>
                <h2 class="text-3xl font-black text-white tracking-tight">Routine Feeding</h2>
                <p class="text-white/50 text-sm mt-2 leading-relaxed font-medium">Batch log for fattening pigs in current growth stage.</p>
            </div>
            
            <div class="p-8 pt-6 space-y-6">
                <!-- Feed Type (Auto-validated) -->
                <div class="p-4 bg-green-500/10 border border-green-500/20 rounded-2xl">
                    <div class="flex items-center gap-3">
                        <i class='bx bxs-check-circle text-green-400 text-xl'></i>
                        <div>
                            <p class="text-white font-bold text-sm">Suggested: <span class="text-green-300">Grower Mix B</span></p>
                            <p class="text-[10px] text-white/40 uppercase font-black">Growth Stage: Fattening (90-120 Days)</p>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-black text-white/40 uppercase tracking-[0.2em] mb-3">Quantity (kg)</label>
                    <input type="number" id="feedQty" placeholder="0.0" 
                           class="w-full bg-white/5 border border-white/10 rounded-2xl py-5 px-6 text-2xl font-black text-white focus:outline-none focus:border-green-500 transition shadow-inner">
                </div>

                <button onclick="submitFeedingLog()" 
                        class="w-full bg-gradient-to-r from-green-500 to-green-600 text-white py-5 rounded-[2rem] font-black text-lg hover:shadow-[0_10px_30px_rgba(34,197,94,0.3)] transition active:scale-[0.98]">
                    Confirm Log
                </button>
            </div>
        </div>
    </div>

    <!-- Health & Sickness Form Modal (Individual) -->
    <div id="healthModal" class="fixed inset-0 z-[210] hidden bg-[#0a180e]/95 backdrop-blur-3xl flex items-center justify-center p-4">
        <div class="glass-panel w-full max-w-lg rounded-[3rem] overflow-hidden shadow-2xl border border-white/10 animate-fade-in my-auto">
            <div class="p-8 pb-6 border-b border-white/5 relative">
                <div class="flex justify-between items-start mb-4">
                    <div class="px-3 py-1 bg-red-500/20 text-red-300 rounded-full text-[10px] font-bold border border-red-500/30 uppercase tracking-widest">Tag ID: <span id="targetPigId">--</span></div>
                    <button onclick="closeHealthModal()" class="w-12 h-12 rounded-2xl bg-white/5 text-white/60 flex items-center justify-center hover:bg-white/10 transition">
                        <i class='bx bx-x text-3xl'></i>
                    </button>
                </div>
                <h2 class="text-3xl font-black text-white tracking-tight">Health Status</h2>
                <p class="text-white/50 text-sm mt-2 leading-relaxed font-medium">Monitoring protocol for individual animal history.</p>
            </div>

            <div class="p-8 pt-6 space-y-6">
                <!-- History Preview -->
                <div class="space-y-3">
                    <label class="block text-[10px] font-black text-white/40 uppercase tracking-[0.2em]">Medical History</label>
                    <div class="grid grid-cols-2 gap-3">
                        <div class="p-3 bg-white/5 rounded-xl border border-white/5">
                            <p class="text-[9px] text-white/30 uppercase font-black">Last Vax</p>
                            <p class="text-xs text-white font-bold">12 Apr (Swine Flu)</p>
                        </div>
                        <div class="p-3 bg-white/5 rounded-xl border border-white/5">
                            <p class="text-[9px] text-white/30 uppercase font-black">Status</p>
                            <p class="text-xs text-emerald-400 font-bold font-black">CLEARED</p>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-black text-white/40 uppercase tracking-[0.2em] mb-3">Symptom Observation</label>
                    <select id="symptom" class="w-full bg-white/5 border border-white/10 rounded-2xl py-5 px-6 text-white focus:outline-none focus:border-red-500 transition appearance-none font-bold">
                        <option value="Healthy">Healthy / Normal</option>
                        <option value="Coughing">Coughing / Respiratory</option>
                        <option value="Lethargic">Lethargic / No Appetite</option>
                        <option value="Diarrhea">Diarrhea / Digestive</option>
                        <option value="Other">Other Issues</option>
                    </select>
                </div>

                <div class="pt-2">
                    <button onclick="submitHealthLog()" 
                            class="w-full bg-gradient-to-r from-red-500 to-red-600 text-white py-5 rounded-[2rem] font-black text-lg hover:shadow-[0_10px_30px_rgba(239,68,68,0.3)] transition active:scale-[0.98]">
                        Log Symptom
                    </button>
                    <p class="text-center text-white/30 text-[9px] mt-4 uppercase font-bold tracking-widest">Immediate Alert will be sent to Site Lead</p>
                </div>
            </div>
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
            document.getElementById('qrModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
            
            if (html5QrcodeScanner && html5QrcodeScanner.getState() !== 1) { // 1 is Html5QrcodeScannerState.NOT_STARTED
                html5QrcodeScanner.stop().catch(err => console.warn("Scanner stop error:", err));
            }
        }

        function showAnimalSummary() {
            Swal.fire({
                title: 'Animal Population',
                html: '<div class="text-left space-y-2"><p><b>Total:</b> 452</p><p><b>Healthy:</b> 449</p><p><b>Quarantined:</b> 3</p></div>',
                icon: 'info',
                background: '#0a180e',
                color: '#fff',
                confirmButtonColor: '#22c55e'
            });
        }

        function showFeedSummary() {
            Swal.fire({
                title: 'Inventory Status',
                html: '<div class="text-left space-y-2"><p><b>Type:</b> 452</p><p><b>Grower Mix:</b> 1,200kg</p><p><b>Starter Mix:</b> 400kg</p></div>',
                icon: 'info',
                background: '#0a180e',
                color: '#fff',
                confirmButtonColor: '#22c55e'
            });
        }

        function onScanSuccess(decodedText, decodedResult) {
            stopQRScanner();
            
            // Operational Logic: Differentiate Pen vs Pig
            if (decodedText.startsWith('PEN-')) {
                const penId = decodedText.split('-')[1];
                openFeedingModal(penId);
            } else if (decodedText.startsWith('PIG-')) {
                const pigId = decodedText.split('-')[1];
                openHealthModal(pigId);
            } else {
                Swal.fire({
                    title: 'Unknown Code',
                    text: `ID "${decodedText}" not recognized in farm database.`,
                    icon: 'warning',
                    background: '#0a180e',
                    color: '#fff'
                });
            }
        }

        // --- Feeding Hub ---
        function openFeedingModal(penId) {
            document.getElementById('targetPenId').innerText = penId;
            document.getElementById('feedingModal').classList.remove('hidden');
            document.getElementById('feedingModal').classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        function closeFeedingModal() {
            document.getElementById('feedingModal').classList.add('hidden');
            document.getElementById('feedingModal').classList.remove('flex');
            document.body.style.overflow = 'auto';
        }

        function submitFeedingLog() {
            const qty = document.getElementById('feedQty').value;
            const penId = document.getElementById('targetPenId').innerText;
            
            if(!qty) {
                Swal.fire({ title: 'Quantity Required', icon: 'error', background: '#0a180e', color: '#fff' });
                return;
            }

            const logData = { type: 'feeding', penId, qty, timestamp: new Date().toISOString() };
            queueAction(logData);
            
            Swal.fire({
                title: 'Feeding Logged',
                text: `${qty}kg for Pen ${penId} recorded.`,
                icon: 'success',
                background: '#0a180e',
                color: '#fff',
                confirmButtonColor: '#22c55e'
            }).then(() => {
                closeFeedingModal();
                document.getElementById('feedQty').value = '';
                processQueue(); // Try sync
            });
        }

        // --- Health Hub ---
        function openHealthModal(pigId) {
            document.getElementById('targetPigId').innerText = pigId;
            document.getElementById('healthModal').classList.remove('hidden');
            document.getElementById('healthModal').classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        function closeHealthModal() {
            document.getElementById('healthModal').classList.add('hidden');
            document.getElementById('healthModal').classList.remove('flex');
            document.body.style.overflow = 'auto';
        }

        function submitHealthLog() {
            const symptom = document.getElementById('symptom').value;
            const pigId = document.getElementById('targetPigId').innerText;

            const logData = { type: 'health', pigId, symptom, timestamp: new Date().toISOString() };
            queueAction(logData);

            Swal.fire({
                title: 'Condition Reported',
                text: `Pig #${pigId} health log saved.`,
                icon: 'success',
                background: '#0a180e',
                color: '#fff',
                confirmButtonColor: '#ef4444'
            }).then(() => {
                closeHealthModal();
                processQueue(); // Try sync
            });
        }

        // --- Local Storage Manager (Offline Reliability) ---
        function queueAction(data) {
            let queue = JSON.parse(localStorage.getItem('farm_pending_sync')) || [];
            queue.push(data);
            localStorage.setItem('farm_pending_sync', JSON.stringify(queue));
            updateSyncBadge();
        }

        function processQueue() {
            if (!navigator.onLine) return;
            
            let queue = JSON.parse(localStorage.getItem('farm_pending_sync')) || [];
            if (queue.length === 0) return;

            // Send to Laravel Backend
            fetch("{{ route('worker.sync') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ logs: queue })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    localStorage.removeItem('farm_pending_sync');
                    updateSyncBadge();
                    console.log("Sync Complete:", data.message);
                }
            })
            .catch(err => {
                console.error("Sync Failed:", err);
            });
        }

        function updateSyncBadge() {
            const queue = JSON.parse(localStorage.getItem('farm_pending_sync')) || [];
            const count = queue.length;
            const syncStatus = document.getElementById('syncStatus');
            
            if (count > 0) {
                syncStatus.innerHTML = `
                    <div class="w-2 h-2 rounded-full bg-yellow-500 animate-pulse"></div>
                    <span class="text-white text-[10px] font-bold uppercase tracking-widest">${count} Pending Sync</span>
                `;
            } else {
                syncStatus.innerHTML = `
                    <div class="w-2 h-2 rounded-full bg-green-500 shadow-[0_0_10px_rgba(34,197,94,0.6)] animate-pulse"></div>
                    <span class="text-white text-[10px] font-bold uppercase tracking-widest">Synced</span>
                `;
            }
        }

        window.addEventListener('online', processQueue);
        document.addEventListener('DOMContentLoaded', updateSyncBadge);

        // --- Sync Mock ---
        function syncData() {
            if(!navigator.onLine) {
                 Swal.fire({ title: 'Offline', text: 'Waiting for signal to sync...', icon: 'warning', background: '#0a180e', color: '#fff' });
                 return;
            }
            
            const statusBtn = document.getElementById('syncStatus');
            statusBtn.innerHTML = `
                <i class='bx bx-loader-alt animate-spin text-white'></i>
                <span class="text-white text-[10px] font-bold uppercase tracking-widest leading-none">Syncing...</span>
            `;
            
            processQueue();
        }
    </script>
@endsection
