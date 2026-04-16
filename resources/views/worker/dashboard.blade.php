@extends('layouts.worker')

@section('content')
    <div class="p-6 md:p-12 max-w-full">

        <!-- Header Section -->
        <div class="mb-8 md:mb-10 w-full md:w-2/3 lg:w-1/2">
            <p class="text-sm md:text-base font-medium text-white/70 mb-1 md:mb-2">Welcome Back,</p>
            <h1 class="text-3xl md:text-5xl font-bold text-white tracking-tight">{{ Auth::user()->name }}</h1>
        </div>

        <!-- Critical Alerts Banner (only shown when there are active critical alerts) -->
        <div id="criticalAlertsBanner" class="mb-6 space-y-3">
            <div class="flex items-center gap-3 p-4 rounded-2xl bg-red-500/15 border border-red-500/40 cursor-pointer hover:bg-red-500/20 transition" onclick="openNotificationsPanel()">
                <div class="w-10 h-10 rounded-xl bg-red-500/30 flex items-center justify-center shrink-0 animate-pulse">
                    <i class='bx bx-error text-red-400 text-xl'></i>
                </div>
                <div class="flex-1">
                    <p class="text-red-300 font-black text-sm">CRITICAL — Pig #42, Pen 3</p>
                    <p class="text-white/60 text-xs mt-0.5">Unusual behavior: rapid breathing and lethargy detected. Tap to view.</p>
                </div>
                <i class='bx bx-chevron-right text-white/40 text-xl'></i>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="flex flex-col md:flex-row gap-4 mb-8">
            <button onclick="startQRScanner()" class="flex-1 glass-panel p-6 rounded-3xl flex items-center justify-center gap-4 hover:bg-green-500/20 transition group border border-green-500/20 shadow-lg active:scale-95">
                <div class="w-12 h-12 rounded-2xl bg-green-500/20 flex items-center justify-center group-hover:scale-110 transition">
                    <i class='bx bx-qr-scan text-2xl text-green-400'></i>
                </div>
                <div class="text-left">
                    <p class="text-white font-bold text-lg">Scan QR Code</p>
                    <p class="text-white/40 text-xs uppercase tracking-wider font-semibold">Immediate Monitoring</p>
                </div>
            </button>
            <button onclick="showTaskModal()" class="flex-1 glass-panel p-6 rounded-3xl flex items-center justify-center gap-4 hover:bg-blue-500/20 transition group border border-blue-500/20 shadow-lg active:scale-95">
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
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-10">
            <div class="glass-panel p-6 rounded-3xl relative overflow-hidden group hover:bg-white/15 transition cursor-pointer" onclick="window.location='{{ route('worker.tasks') }}'">
                <div class="flex flex-col relative z-20">
                    <span class="text-white/40 text-xs font-bold uppercase tracking-widest mb-2">Active Tasks</span>
                    <span class="text-4xl font-bold text-white">08</span>
                </div>
                <i class='bx bx-list-check absolute bottom-[-10px] right-[-10px] text-6xl md:text-8xl text-white/10 group-hover:scale-110 transition duration-500'></i>
            </div>
            <div class="glass-panel p-6 rounded-3xl relative overflow-hidden group hover:bg-white/15 transition cursor-pointer" onclick="showAnimalSummary()">
                <div class="flex flex-col relative z-20">
                    <span class="text-white/40 text-xs font-bold uppercase tracking-widest mb-2">Animals</span>
                    <span class="text-4xl font-bold text-white">452</span>
                </div>
                <i class='bx bxs-dog absolute bottom-[-10px] right-[-10px] text-6xl md:text-8xl text-white/10 group-hover:scale-110 transition duration-500'></i>
            </div>
            <div class="glass-panel p-6 rounded-3xl relative overflow-hidden group hover:bg-white/15 transition cursor-pointer border-l-4 border-red-500/50" onclick="openNotificationsPanel()">
                <div class="flex flex-col relative z-20">
                    <span class="text-white/40 text-xs font-bold uppercase tracking-widest mb-2">Alerts</span>
                    <span id="alertCountStat" class="text-4xl font-bold text-red-400">03</span>
                </div>
                <i class='bx bxs-bell absolute bottom-[-10px] right-[-10px] text-6xl md:text-8xl text-red-500/10 group-hover:scale-110 transition duration-500'></i>
            </div>
            <div class="glass-panel p-6 rounded-3xl relative overflow-hidden group hover:bg-white/15 transition cursor-pointer" onclick="showFeedSummary()">
                <div class="flex flex-col relative z-20">
                    <span class="text-white/40 text-xs font-bold uppercase tracking-widest mb-2">Feed Stock</span>
                    <span class="text-4xl font-bold text-green-400">78%</span>
                </div>
                <i class='bx bxs-bowl-rice absolute bottom-[-10px] right-[-10px] text-6xl md:text-8xl text-green-500/10 group-hover:scale-110 transition duration-500'></i>
            </div>
        </div>

        <!-- Pens & Pigs Tracker -->
        <div class="mb-10">
            <div class="flex items-center justify-between mb-5">
                <h2 class="text-xl md:text-2xl font-bold text-white">Pens Overview</h2>
                <span class="text-xs text-white/40 uppercase font-bold tracking-widest">Tap a pen to log</span>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Pen 1 -->
                <div onclick="openFeedingModal('1')" class="glass-panel rounded-2xl p-5 border border-white/10 hover:bg-white/15 transition cursor-pointer group active:scale-[0.98]">
                    <div class="flex justify-between items-start mb-3">
                        <div>
                            <p class="text-white font-black text-lg">Pen 1</p>
                            <p class="text-white/40 text-xs font-semibold">Piglets</p>
                        </div>
                        <span class="px-2 py-1 bg-green-500/20 text-green-300 rounded-full text-[10px] font-black border border-green-500/30 uppercase">Good</span>
                    </div>
                    <div class="grid grid-cols-3 gap-2 mb-3 text-center">
                        <div class="bg-white/5 rounded-xl p-2">
                            <p class="text-white/40 text-[9px] uppercase font-black">Pigs</p>
                            <p class="text-white font-black text-lg">24</p>
                        </div>
                        <div class="bg-white/5 rounded-xl p-2">
                            <p class="text-white/40 text-[9px] uppercase font-black">Sick</p>
                            <p class="text-green-400 font-black text-lg">0</p>
                        </div>
                        <div class="bg-white/5 rounded-xl p-2">
                            <p class="text-white/40 text-[9px] uppercase font-black">Avg kg</p>
                            <p class="text-white font-black text-lg">12</p>
                        </div>
                    </div>
                    <div class="w-full h-2 bg-white/10 rounded-full overflow-hidden">
                        <div class="h-full bg-green-500 rounded-full" style="width:30%"></div>
                    </div>
                    <p class="text-white/30 text-[10px] mt-1 font-semibold">30% to target weight</p>
                </div>
                <!-- Pen 5 -->
                <div onclick="openFeedingModal('5')" class="glass-panel rounded-2xl p-5 border border-white/10 hover:bg-white/15 transition cursor-pointer group active:scale-[0.98]">
                    <div class="flex justify-between items-start mb-3">
                        <div>
                            <p class="text-white font-black text-lg">Pen 5</p>
                            <p class="text-white/40 text-xs font-semibold">Fattening</p>
                        </div>
                        <span class="px-2 py-1 bg-yellow-500/20 text-yellow-300 rounded-full text-[10px] font-black border border-yellow-500/30 uppercase">Fair</span>
                    </div>
                    <div class="grid grid-cols-3 gap-2 mb-3 text-center">
                        <div class="bg-white/5 rounded-xl p-2">
                            <p class="text-white/40 text-[9px] uppercase font-black">Pigs</p>
                            <p class="text-white font-black text-lg">48</p>
                        </div>
                        <div class="bg-white/5 rounded-xl p-2">
                            <p class="text-white/40 text-[9px] uppercase font-black">Sick</p>
                            <p class="text-red-400 font-black text-lg">2</p>
                        </div>
                        <div class="bg-white/5 rounded-xl p-2">
                            <p class="text-white/40 text-[9px] uppercase font-black">Avg kg</p>
                            <p class="text-white font-black text-lg">65</p>
                        </div>
                    </div>
                    <div class="w-full h-2 bg-white/10 rounded-full overflow-hidden">
                        <div class="h-full bg-yellow-500 rounded-full" style="width:59%"></div>
                    </div>
                    <p class="text-white/30 text-[10px] mt-1 font-semibold">59% to target weight</p>
                </div>
                <!-- Pen 12 -->
                <div onclick="openFeedingModal('12')" class="glass-panel rounded-2xl p-5 border border-white/10 hover:bg-white/15 transition cursor-pointer group active:scale-[0.98]">
                    <div class="flex justify-between items-start mb-3">
                        <div>
                            <p class="text-white font-black text-lg">Pen 12</p>
                            <p class="text-white/40 text-xs font-semibold">Breeding</p>
                        </div>
                        <span class="px-2 py-1 bg-emerald-500/20 text-emerald-300 rounded-full text-[10px] font-black border border-emerald-500/30 uppercase">Excellent</span>
                    </div>
                    <div class="grid grid-cols-3 gap-2 mb-3 text-center">
                        <div class="bg-white/5 rounded-xl p-2">
                            <p class="text-white/40 text-[9px] uppercase font-black">Pigs</p>
                            <p class="text-white font-black text-lg">12</p>
                        </div>
                        <div class="bg-white/5 rounded-xl p-2">
                            <p class="text-white/40 text-[9px] uppercase font-black">Sick</p>
                            <p class="text-green-400 font-black text-lg">0</p>
                        </div>
                        <div class="bg-white/5 rounded-xl p-2">
                            <p class="text-white/40 text-[9px] uppercase font-black">Avg kg</p>
                            <p class="text-white font-black text-lg">90</p>
                        </div>
                    </div>
                    <div class="w-full h-2 bg-white/10 rounded-full overflow-hidden">
                        <div class="h-full bg-emerald-500 rounded-full" style="width:82%"></div>
                    </div>
                    <p class="text-white/30 text-[10px] mt-1 font-semibold">82% to target weight</p>
                </div>
            </div>
        </div>

        <!-- Recent Monitoring Logs -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-5">
                <h2 class="text-xl md:text-2xl font-bold text-white">Recent Monitoring</h2>
                <a href="{{ route('worker.activity-log') }}" class="text-xs text-white/40 hover:text-white transition uppercase font-bold tracking-widest">View All</a>
            </div>
            <div id="recentMonitoringList" class="space-y-3">
                <!-- Static placeholder -->
                <div class="glass-panel rounded-2xl p-5 flex gap-4 items-start border border-white/5">
                    <div class="w-10 h-10 rounded-xl bg-green-500/20 flex items-center justify-center shrink-0 border border-green-500/20">
                        <i class='bx bxs-bowl-rice text-green-400 text-lg'></i>
                    </div>
                    <div class="flex-1">
                        <div class="flex justify-between items-start">
                            <p class="text-white font-bold text-sm">Pen 5 — Feeding Log</p>
                            <span class="text-white/30 text-xs">2:30 PM</span>
                        </div>
                        <p class="text-white/50 text-xs mt-1">5kg of grower mix. All pigs active.</p>
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

    <!-- Health & Pig Monitoring Form Modal (Individual) -->
    <div id="healthModal" class="fixed inset-0 z-[210] hidden bg-[#0a180e]/95 backdrop-blur-3xl flex items-start justify-center p-4 overflow-y-auto">
        <div class="glass-panel w-full max-w-lg rounded-3xl overflow-hidden shadow-2xl border border-white/10 animate-fade-in my-6">

            <!-- Header -->
            <div class="p-6 border-b border-white/10 bg-white/5">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-white/50 text-sm font-semibold uppercase tracking-widest mb-1">Ear Tag No.</p>
                        <h2 class="text-4xl font-black text-white tracking-tight" id="targetPigId">--</h2>
                    </div>
                    <button onclick="closeHealthModal()" class="w-14 h-14 rounded-2xl bg-white/10 text-white flex items-center justify-center hover:bg-white/20 transition active:scale-90">
                        <i class='bx bx-x text-4xl'></i>
                    </button>
                </div>
                <p class="text-white/40 text-base mt-3 font-medium">Pig Monitoring Report — fill in all sections below.</p>
            </div>

            <div class="p-6 space-y-8">

                <!-- Animal Quick Info -->
                <div class="grid grid-cols-3 gap-3">
                    <div class="p-4 bg-white/5 rounded-2xl border border-white/10 text-center">
                        <p class="text-xs text-white/40 font-bold uppercase mb-1">Pen</p>
                        <p class="text-lg text-white font-black" id="pigInfoPen">—</p>
                    </div>
                    <div class="p-4 bg-white/5 rounded-2xl border border-white/10 text-center">
                        <p class="text-xs text-white/40 font-bold uppercase mb-1">Stage</p>
                        <p class="text-lg text-white font-black" id="pigInfoStage">—</p>
                    </div>
                    <div class="p-4 bg-white/5 rounded-2xl border border-white/10 text-center">
                        <p class="text-xs text-white/40 font-bold uppercase mb-1">Last Check</p>
                        <p class="text-base text-white font-black" id="pigInfoLastCheck">—</p>
                    </div>
                </div>

                <!-- Last Vaccination Banner -->
                <div class="p-4 bg-emerald-500/10 border border-emerald-500/30 rounded-2xl flex gap-4 items-center">
                    <i class='bx bx-shield-quarter text-emerald-400 text-3xl shrink-0'></i>
                    <div>
                        <p class="text-white font-bold text-base">Last Vaccination: <span class="text-emerald-300">12 Apr — Swine Flu</span></p>
                        <p class="text-sm text-emerald-400 font-bold mt-0.5">Status: CLEARED</p>
                    </div>
                </div>

                <!-- Physical Inspection Checklist -->
                <div>
                    <p class="text-base font-black text-white mb-4">Physical Inspection — Tap each item to confirm</p>
                    <div class="space-y-3" id="physicalChecklist"></div>
                </div>

                <!-- Body Condition Score -->
                <div>
                    <p class="text-base font-black text-white mb-1">Body Condition Score</p>
                    <p class="text-sm text-white/50 mb-3">1 = Very Thin &nbsp; 3 = Ideal &nbsp; 5 = Obese</p>
                    <div class="flex gap-2">
                        <button type="button" onclick="setBCS(this,1)" class="bcs-btn flex-1 py-4 rounded-xl border border-white/10 bg-white/5 text-white font-black text-base transition active:scale-95">
                            1<br><span class="text-xs font-medium text-white/50">Thin</span>
                        </button>
                        <button type="button" onclick="setBCS(this,2)" class="bcs-btn flex-1 py-4 rounded-xl border border-white/10 bg-white/5 text-white font-black text-base transition active:scale-95">
                            2<br><span class="text-xs font-medium text-white/50">Lean</span>
                        </button>
                        <button type="button" onclick="setBCS(this,3)" class="bcs-btn flex-1 py-4 rounded-xl border border-white/10 bg-white/5 text-white font-black text-base transition active:scale-95">
                            3<br><span class="text-xs font-medium text-white/50">Ideal</span>
                        </button>
                        <button type="button" onclick="setBCS(this,4)" class="bcs-btn flex-1 py-4 rounded-xl border border-white/10 bg-white/5 text-white font-black text-base transition active:scale-95">
                            4<br><span class="text-xs font-medium text-white/50">Fat</span>
                        </button>
                        <button type="button" onclick="setBCS(this,5)" class="bcs-btn flex-1 py-4 rounded-xl border border-white/10 bg-white/5 text-white font-black text-base transition active:scale-95">
                            5<br><span class="text-xs font-medium text-white/50">Obese</span>
                        </button>
                    </div>
                    <input type="hidden" id="selectedBCS" value="">
                </div>

                <!-- Estimated Weight -->
                <div>
                    <p class="text-base font-black text-white mb-3">Estimated Weight (kg)</p>
                    <div class="relative">
                        <input type="number" id="pigWeight" placeholder="0"
                            class="w-full bg-white/5 border border-white/10 rounded-2xl py-5 pl-6 pr-16 text-white text-3xl font-black focus:outline-none focus:border-green-500/50 transition">
                        <span class="absolute right-6 top-1/2 -translate-y-1/2 text-white/40 font-bold text-xl">kg</span>
                    </div>
                </div>

                <!-- Feeding Behavior -->
                <div>
                    <p class="text-base font-black text-white mb-3">Feeding Behavior</p>
                    <div class="grid grid-cols-3 gap-3">
                        <button type="button" onclick="setFeedBehavior(this,'Active')"
                            class="feed-btn py-5 rounded-2xl border border-white/10 bg-white/5 text-white font-black text-sm transition active:scale-95">
                            <i class='bx bx-run block text-3xl mb-2 mx-auto'></i>Active
                        </button>
                        <button type="button" onclick="setFeedBehavior(this,'Normal')"
                            class="feed-btn py-5 rounded-2xl border border-white/10 bg-white/5 text-white font-black text-sm transition active:scale-95">
                            <i class='bx bx-check-circle block text-3xl mb-2 mx-auto'></i>Normal
                        </button>
                        <button type="button" onclick="setFeedBehavior(this,'Poor/None')"
                            class="feed-btn py-5 rounded-2xl border border-white/10 bg-white/5 text-white font-black text-sm transition active:scale-95">
                            <i class='bx bx-minus-circle block text-3xl mb-2 mx-auto'></i>Poor / None
                        </button>
                    </div>
                    <input type="hidden" id="selectedFeedBehavior" value="">
                </div>

                <!-- Overall Health / Symptom -->
                <div>
                    <p class="text-base font-black text-white mb-3">Observed Symptom</p>
                    <div class="relative">
                        <select id="symptom" class="w-full bg-white/5 border border-white/10 rounded-2xl py-5 pl-5 pr-10 text-white text-base focus:outline-none focus:border-green-500/50 transition appearance-none font-bold">
                            <option value="Healthy" class="bg-[#0a180e]">Healthy — No Issues</option>
                            <option value="Coughing" class="bg-[#0a180e]">Coughing / Respiratory Problem</option>
                            <option value="Lethargic" class="bg-[#0a180e]">Lethargic / Not Eating</option>
                            <option value="Diarrhea" class="bg-[#0a180e]">Diarrhea / Loose Stool</option>
                            <option value="Lameness" class="bg-[#0a180e]">Lameness / Limping</option>
                            <option value="Skin" class="bg-[#0a180e]">Skin Wound / Rash</option>
                            <option value="Fever" class="bg-[#0a180e]">Suspected Fever</option>
                            <option value="Other" class="bg-[#0a180e]">Other — See Notes Below</option>
                        </select>
                        <i class='bx bx-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-white/40 pointer-events-none text-2xl'></i>
                    </div>
                </div>

                <!-- Additional Notes -->
                <div>
                    <p class="text-base font-black text-white mb-3">Additional Notes</p>
                    <textarea id="pigNotes" rows="3" placeholder="Write any other observations here..."
                        class="w-full bg-white/5 border border-white/10 rounded-2xl py-4 px-5 text-white text-base font-medium focus:outline-none focus:border-green-500/50 transition resize-none leading-relaxed"></textarea>
                </div>

                <!-- Submit Button -->
                <div class="pb-4 space-y-3">
                    <button onclick="submitHealthLog()"
                            class="w-full bg-gradient-to-r from-green-500 to-green-600 text-white py-6 rounded-2xl font-black text-xl hover:shadow-[0_10px_30px_rgba(34,197,94,0.3)] transition active:scale-[0.98]">
                        Save Report
                    </button>
                    <p class="text-center text-white/30 text-xs font-bold">Symptoms flagged will automatically alert the Site Lead</p>
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
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-white/40 z-10 pointer-events-none">
                            <i class='bx bx-grid-alt text-xl'></i>
                        </span>
                        <select id="taskPen"
                            class="w-full border border-white/10 rounded-2xl py-4 pl-12 pr-10 text-white focus:outline-none focus:border-green-500/50 transition font-medium appearance-none cursor-pointer"
                            style="background-color: #0f2015;">
                            <option value="Pen 1"  style="background:#0f2015;color:#fff;padding:8px;">Pen 1 (Piglets)</option>
                            <option value="Pen 5"  style="background:#0f2015;color:#fff;padding:8px;">Pen 5 (Fattening)</option>
                            <option value="Pen 12" style="background:#0f2015;color:#fff;padding:8px;">Pen 12 (Breeding)</option>
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
            try { stopQRScanner(); } catch(e) {}
            
            let id = decodedText.toUpperCase().trim();
            // If the worker just inputs the number directly, we assume it's an ear tag (PIG)
            if (/^\\d+$/.test(id)) {
                id = 'PIG-' + id;
            }

            // Operational Logic: Differentiate Pen vs Pig
            if (id.startsWith('PEN-') || id.startsWith('PEN')) {
                const penId = id.replace('PEN-', '').replace('PEN', '').trim();
                openFeedingModal(penId);
            } else if (id.startsWith('PIG-') || id.startsWith('PIG')) {
                const pigId = id.replace('PIG-', '').replace('PIG', '').trim();
                openHealthModal(pigId);
            } else {
                Swal.fire({
                    title: 'Unknown Code',
                    text: `ID "${id}" not recognized in farm database. Use PEN-X or PIG-X format.`,
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
        const physicalCheckItems = [
            'Snout — No discharge or crustiness',
            'Eyes — Clear, bright, no swelling',
            'Ears — No redness or foul odor',
            'Legs — Walking normally, no limping',
            'Skin — No wounds, lesions, or rashes',
            'Breathing — Normal, no coughing',
            'Temperature — Feels normal, no fever',
            'Water — Drinking water adequately',
        ];
        let physicalCheckState = {};

        function openHealthModal(pigId) {
            document.getElementById('targetPigId').innerText = pigId;

            // Populate quick info with demo data (replace with DB lookup as needed)
            document.getElementById('pigInfoPen').innerText = 'A1';
            document.getElementById('pigInfoStage').innerText = 'Fattening';
            document.getElementById('pigInfoLastCheck').innerText = '3 days ago';

            // Reset all form fields
            document.getElementById('selectedBCS').value = '';
            document.getElementById('selectedFeedBehavior').value = '';
            document.getElementById('pigWeight').value = '';
            document.getElementById('pigNotes').value = '';
            document.getElementById('symptom').value = 'Healthy';
            document.querySelectorAll('.bcs-btn').forEach(b => b.classList.remove('bg-green-500/30','border-green-500','text-green-300'));
            document.querySelectorAll('.feed-btn').forEach(b => b.classList.remove('bg-green-500/30','border-green-500','text-green-300','bg-blue-500/30','border-blue-500','text-blue-300','bg-red-500/30','border-red-500','text-red-300'));

            // Render physical checklist
            physicalCheckState = {};
            const container = document.getElementById('physicalChecklist');
            container.innerHTML = '';
            physicalCheckItems.forEach((item, i) => {
                physicalCheckState[i] = false;
                container.insertAdjacentHTML('beforeend', `
                    <div onclick="togglePhysicalCheck(${i}, this)"
                         class="flex items-center gap-4 p-4 rounded-2xl bg-white/5 border border-white/10 hover:bg-white/10 transition cursor-pointer active:scale-[0.98]"
                         id="pcheck-${i}">
                        <div class="w-8 h-8 rounded-xl border-2 border-white/30 flex items-center justify-center transition-all shrink-0" id="pcheck-box-${i}">
                            <i class='bx bx-check text-xl text-white opacity-0 transition-opacity'></i>
                        </div>
                        <span class="text-white/80 text-base font-semibold leading-snug">${item}</span>
                    </div>
                `);
            });

            document.getElementById('healthModal').classList.remove('hidden');
            document.getElementById('healthModal').classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        function togglePhysicalCheck(index, el) {
            physicalCheckState[index] = !physicalCheckState[index];
            const box = document.getElementById(`pcheck-box-${index}`);
            const icon = box.querySelector('i');
            if (physicalCheckState[index]) {
                box.classList.add('bg-green-500', 'border-green-500');
                box.classList.remove('border-white/20');
                icon.classList.remove('opacity-0');
                el.classList.add('bg-green-500/10', 'border-green-500/20');
            } else {
                box.classList.remove('bg-green-500', 'border-green-500');
                box.classList.add('border-white/20');
                icon.classList.add('opacity-0');
                el.classList.remove('bg-green-500/10', 'border-green-500/20');
            }
        }

        function setBCS(btn, score) {
            document.querySelectorAll('.bcs-btn').forEach(b => {
                b.classList.remove('bg-green-500/30','border-green-500','text-green-300');
                b.classList.add('bg-white/5','border-white/10','text-white/60');
            });
            btn.classList.add('bg-green-500/30','border-green-500','text-green-300');
            btn.classList.remove('bg-white/5','border-white/10','text-white/60');
            document.getElementById('selectedBCS').value = score;
        }

        function setFeedBehavior(btn, value) {
            document.querySelectorAll('.feed-btn').forEach(b => {
                b.classList.remove('bg-green-500/30','border-green-500','text-green-300','bg-blue-500/30','border-blue-500','text-blue-300','bg-red-500/30','border-red-500','text-red-300');
                b.classList.add('bg-white/5','border-white/10','text-white/60');
            });
            btn.classList.remove('bg-white/5','border-white/10','text-white/60');
            if (value === 'Active')      btn.classList.add('bg-green-500/30','border-green-500','text-green-300');
            else if (value === 'Normal') btn.classList.add('bg-blue-500/30','border-blue-500','text-blue-300');
            else                         btn.classList.add('bg-red-500/30','border-red-500','text-red-300');
            document.getElementById('selectedFeedBehavior').value = value;
        }

        function closeHealthModal() {
            document.getElementById('healthModal').classList.add('hidden');
            document.getElementById('healthModal').classList.remove('flex');
            document.body.style.overflow = 'auto';
        }

        function submitHealthLog() {
            const pigId   = document.getElementById('targetPigId').innerText;
            const symptom = document.getElementById('symptom').value;
            const bcs     = document.getElementById('selectedBCS').value;
            const feed    = document.getElementById('selectedFeedBehavior').value;
            const weight  = document.getElementById('pigWeight').value;
            const notes   = document.getElementById('pigNotes').value;

            const checkedCount = Object.values(physicalCheckState).filter(v => v).length;
            const totalChecks  = physicalCheckItems.length;

            const now = new Date();
            const timeStr = now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

            const logData = {
                type: 'health', pigId, symptom, bcs, feed, weight, notes,
                physicalChecks: checkedCount + '/' + totalChecks,
                timestamp: now.toISOString(),
                timeStr
            };
            queueAction(logData);

            // Save to localStorage for recent monitoring display
            const existing = JSON.parse(localStorage.getItem('recent_monitoring') || '[]');
            existing.unshift(logData);
            if (existing.length > 10) existing.pop();
            localStorage.setItem('recent_monitoring', JSON.stringify(existing));

            const isSick = symptom !== 'Healthy' || feed === 'Poor/None';

            // If sick, add to alert panel dynamically
            if (isSick) {
                addAlertToPanel({
                    type: 'critical',
                    title: `Pig #${pigId} — ${symptom}`,
                    body: `Reported by worker. Weight: ${weight || '?'}kg, BCS: ${bcs || '?'}, Feeding: ${feed || '?'}. ${notes ? 'Note: '+notes : ''}`,
                    time: 'Just now'
                });
            }

            Swal.fire({
                title: isSick ? 'Alert Flagged' : 'Report Saved',
                html: `
                    <div class="text-left space-y-1 text-sm">
                        <p><b>Pig:</b> #${pigId}</p>
                        <p><b>Condition:</b> ${symptom}</p>
                        <p><b>BCS:</b> ${bcs || '—'} &nbsp;|&nbsp; <b>Weight:</b> ${weight ? weight+'kg' : '—'}</p>
                        <p><b>Feeding:</b> ${feed || '—'}</p>
                        <p><b>Checks Passed:</b> ${checkedCount}/${totalChecks}</p>
                        ${isSick ? '<p class="text-red-400 font-bold mt-2">Site Lead has been notified.</p>' : ''}
                    </div>`,
                icon: isSick ? 'warning' : 'success',
                background: '#0a180e',
                color: '#fff',
                confirmButtonColor: '#22c55e'
            }).then(() => {
                closeHealthModal();
                renderRecentMonitoring();
                processQueue();
            });
        }

        function renderRecentMonitoring() {
            const logs = JSON.parse(localStorage.getItem('recent_monitoring') || '[]');
            const container = document.getElementById('recentMonitoringList');
            if (!logs.length) return;

            const isSickColor = (log) => log.symptom !== 'Healthy' || log.feed === 'Poor/None';

            container.innerHTML = logs.map(log => {
                const sick = isSickColor(log);
                const border = sick ? 'border-red-500/30' : 'border-green-500/20';
                const iconBg = sick ? 'bg-red-500/20' : 'bg-green-500/20';
                const iconColor = sick ? 'text-red-400' : 'text-green-400';
                const icon = sick ? 'bx-error-circle' : 'bx-heart';
                const badge = sick
                    ? `<span class="px-2 py-0.5 bg-red-500/20 text-red-300 rounded-md text-[9px] font-black border border-red-500/30 uppercase">Alert</span>`
                    : `<span class="px-2 py-0.5 bg-green-500/20 text-green-300 rounded-md text-[9px] font-black border border-green-500/20 uppercase">Healthy</span>`;
                return `
                    <div class="glass-panel rounded-2xl p-4 flex gap-4 items-start border ${border}">
                        <div class="w-10 h-10 rounded-xl ${iconBg} flex items-center justify-center shrink-0">
                            <i class='bx ${icon} ${iconColor} text-lg'></i>
                        </div>
                        <div class="flex-1">
                            <div class="flex justify-between items-start">
                                <p class="text-white font-bold text-sm">Pig #${log.pigId} — ${log.symptom}</p>
                                <span class="text-white/30 text-xs">${log.timeStr}</span>
                            </div>
                            <p class="text-white/50 text-xs mt-1">BCS: ${log.bcs||'—'} · Weight: ${log.weight?log.weight+'kg':'—'} · Feeding: ${log.feed||'—'} · Checks: ${log.physicalChecks}</p>
                            ${log.notes ? `<p class="text-white/40 text-xs mt-1 italic">"${log.notes}"</p>` : ''}
                            <div class="mt-2">${badge}</div>
                        </div>
                    </div>`;
            }).join('');
        }

        // --- Notifications / Alerts Panel ---
        function openNotificationsPanel() {
            document.getElementById('notificationsPanel').classList.remove('translate-x-full');
            document.getElementById('notificationsBackdrop').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeNotificationsPanel() {
            document.getElementById('notificationsPanel').classList.add('translate-x-full');
            document.getElementById('notificationsBackdrop').classList.add('hidden');
            document.body.style.overflow = '';
        }

        function filterPanel(type, btn) {
            document.querySelectorAll('.panel-filter-btn').forEach(b => {
                b.classList.remove('bg-green-500/20','text-green-300','border-green-500/30');
                b.classList.add('bg-white/5','text-white/50','border-white/10');
            });
            btn.classList.add('bg-green-500/20','text-green-300','border-green-500/30');
            btn.classList.remove('bg-white/5','text-white/50','border-white/10');

            document.querySelectorAll('.alert-item').forEach(item => {
                if (type === 'all' || item.dataset.type === type) {
                    item.style.display = '';
                } else {
                    item.style.display = 'none';
                }
            });
        }

        function addAlertToPanel({ type, title, body, time }) {
            const colors = {
                critical: { bg: 'bg-red-500/10', border: 'border-red-500/30', text: 'text-red-300', icon: 'bx-error-circle', ibg: 'bg-red-500/25' },
                health:   { bg: 'bg-yellow-500/10', border: 'border-yellow-500/20', text: 'text-yellow-300', icon: 'bx-error-alt', ibg: 'bg-yellow-500/20' },
                general:  { bg: 'bg-white/5', border: 'border-white/10', text: 'text-white', icon: 'bx-info-circle', ibg: 'bg-blue-500/20' },
            };
            const c = colors[type] || colors.general;
            const html = `
                <div class="alert-item" data-type="${type}">
                    <div class="p-4 rounded-2xl ${c.bg} border ${c.border}">
                        <div class="flex gap-3 items-start">
                            <div class="w-10 h-10 rounded-xl ${c.ibg} flex items-center justify-center shrink-0">
                                <i class='bx ${c.icon} ${c.text} text-lg'></i>
                            </div>
                            <div class="flex-1">
                                <div class="flex justify-between items-start">
                                    <p class="${c.text} font-black text-sm">${title}</p>
                                    <span class="text-white/30 text-[10px]">${time}</span>
                                </div>
                                <p class="text-white/60 text-xs mt-1 leading-snug">${body}</p>
                                <div class="flex gap-2 mt-3">
                                    <span class="px-2 py-0.5 ${c.bg} ${c.text} rounded-md text-[9px] font-black border ${c.border} uppercase">${type}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>`;
            document.getElementById('alertPanelList').insertAdjacentHTML('afterbegin', html);
            // Update badge count
            const count = document.querySelectorAll('.alert-item').length;
            const stat = document.getElementById('alertCountStat');
            if (stat) stat.innerText = String(count).padStart(2, '0');
        }

        function takeAlertAction(target) {
            Swal.fire({
                title: 'Emergency Response',
                text: 'Deploy health protocol for ' + target + '?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#333',
                confirmButtonText: 'Yes, Deploy Now',
                background: '#0a180e',
                color: '#fff'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({ title: 'Protocol Active', text: 'HQ has been notified. Med-kit deployed.', icon: 'success', background: '#0a180e', color: '#fff' });
                }
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
        document.addEventListener('DOMContentLoaded', () => {
            updateSyncBadge();
            renderRecentMonitoring();

            const urlParams = new URLSearchParams(window.location.search);
            const manualScan = urlParams.get('manual_scan');
            if (manualScan) {
                // Remove parameter from URL to prevent infinite triggers on refresh
                window.history.replaceState({}, document.title, window.location.pathname);
                
                // Slight delay to ensure modals are ready
                setTimeout(() => {
                    onScanSuccess(manualScan, null);
                }, 400);
            }
        });

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
