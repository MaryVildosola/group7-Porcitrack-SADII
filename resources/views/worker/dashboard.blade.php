@extends('layouts.worker')

@section('content')
<div class="worker-dash min-h-screen bg-[#f1f5f9]">
    <div class="px-6 md:px-12 py-10 max-w-full">

        <!-- Header Section -->
        <div class="mb-10 md:mb-14">
            <p class="text-xs md:text-sm font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Operational Dashboard</p>
            <h1 class="text-4xl md:text-6xl font-black text-slate-900 tracking-tighter">Hello, <span class="text-green-600">{{ explode(' ', Auth::user()->name)[0] }}</span></h1>
        </div>

        <!-- Critical Alerts Banner -->
        <div id="criticalAlertsBanner" class="mb-10 animate-fade-in">
            <div class="flex items-center gap-4 p-5 rounded-[2rem] bg-white border border-red-100 shadow-sm hover:shadow-md transition cursor-pointer" onclick="openNotificationsPanel()">
                <div class="w-12 h-12 rounded-2xl bg-red-50 text-red-500 flex items-center justify-center shrink-0 animate-pulse">
                    <i class='bx bxs-error-circle text-2xl'></i>
                </div>
                <div class="flex-1">
                    <p class="text-slate-900 font-black text-sm">CRITICAL — Pig #42, Pen 3</p>
                    <p class="text-slate-500 text-xs font-medium">Unusual health metrics detected. Immediate check-up required.</p>
                </div>
                <i class='bx bx-chevron-right text-slate-300 text-2xl'></i>
            </div>
        </div>

        <!-- Top Actions Wrapper -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
            <button onclick="startQRScanner()" class="group relative p-8 rounded-[2.5rem] bg-green-600 hover:bg-green-700 transition-all shadow-xl shadow-green-500/20 flex items-center gap-6 overflow-hidden">
                <div class="absolute right-0 top-0 w-32 h-32 bg-white/10 rounded-full -mr-16 -mt-16 blur-2xl"></div>
                <div class="w-16 h-16 rounded-3xl bg-white/20 flex items-center justify-center text-white shrink-0 group-hover:scale-110 transition-transform">
                    <i class='bx bx-qr-scan text-3xl'></i>
                </div>
                <div class="text-left relative z-10">
                    <p class="text-white font-black text-2xl tracking-tight">Scan QR Code</p>
                    <p class="text-white/70 text-[10px] uppercase font-black tracking-widest mt-1">Manual ID Verification</p>
                </div>
            </button>

            <div class="glass-panel p-8 rounded-[2.5rem] flex items-center justify-between border border-slate-200">
                <div class="flex items-center gap-5">
                    <div class="w-14 h-14 rounded-2xl bg-slate-100 flex items-center justify-center text-slate-400">
                        <i class='bx bx-cloud-upload text-2xl'></i>
                    </div>
                    <div>
                        <p class="text-slate-900 font-extrabold text-lg">Auto-Sync Active</p>
                        <p class="text-slate-400 text-[10px] uppercase font-black tracking-widest">Network: Operational</p>
                    </div>
                </div>
                <div class="w-3 h-3 rounded-full bg-green-500 shadow-[0_0_10px_rgba(34,197,94,0.4)]"></div>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 mb-16">
            @php
                $stats = [
                    ['label' => 'Active Tasks', 'val' => '08', 'icon' => 'bx-list-check', 'color' => 'slate'],
                    ['label' => 'Total Animals', 'val' => '452', 'icon' => 'bx-pig', 'color' => 'slate'],
                    ['label' => 'Alerts', 'val' => '03', 'icon' => 'bx-bell', 'color' => 'red'],
                    ['label' => 'Feed Stock', 'val' => '78%', 'icon' => 'bx-bowl-hot', 'color' => 'green'],
                ];
            @endphp
            @foreach($stats as $s)
                <div class="bg-white p-7 rounded-[2.2rem] border border-slate-100 shadow-sm relative overflow-hidden group hover:shadow-xl transition-all">
                    <div class="relative z-10">
                        <span class="text-slate-400 text-[10px] font-black uppercase tracking-[0.2em] block mb-2">{{ $s['label'] }}</span>
                        <span class="text-4xl font-black text-{{ $s['color'] }}-600 tracking-tighter">{{ $s['val'] }}</span>
                    </div>
                    <i class='bx {{ $s['icon'] }} absolute bottom-[-15px] right-[-15px] text-7xl text-slate-50 group-hover:scale-110 group-hover:text-slate-100 transition-all duration-500'></i>
                </div>
            @endforeach
        </div>

        <!-- Section Header -->
        <div class="flex items-center justify-between mb-8 px-1">
            <div>
                <h2 class="text-2xl md:text-3xl font-black text-slate-900 tracking-tight">Pens Overview</h2>
                <p class="text-[10px] text-slate-400 uppercase font-black tracking-widest mt-1">Real-time inventory</p>
            </div>
            <button class="w-10 h-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-slate-400 hover:text-green-600 transition shadow-sm">
                <i class='bx bx-filter-alt'></i>
            </button>
        </div>

        <!-- Pens Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
            @foreach([
                ['id' => '1', 'name' => 'Pen 1', 'type' => 'Piglets', 'count' => 24, 'sick' => 0, 'weight' => 12, 'progress' => 30, 'tag' => 'Good', 'color' => 'green'],
                ['id' => '5', 'name' => 'Pen 5', 'type' => 'Fattening', 'count' => 48, 'sick' => 2, 'weight' => 65, 'progress' => 59, 'tag' => 'Fair', 'color' => 'amber'],
                ['id' => '12', 'name' => 'Pen 12', 'type' => 'Breeding', 'count' => 12, 'sick' => 0, 'weight' => 90, 'progress' => 82, 'tag' => 'Excellent', 'color' => 'indigo']
            ] as $pen)
                <div onclick="openFeedingModal('{{ $pen['id'] }}')" class="group bg-white rounded-[2.5rem] p-8 border border-slate-100 hover:border-green-500/50 hover:shadow-2xl transition-all cursor-pointer relative overflow-hidden shadow-sm">
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <h3 class="text-2xl font-black text-slate-900 tracking-tighter">{{ $pen['name'] }}</h3>
                            <p class="text-slate-400 text-[10px] font-black uppercase tracking-widest mt-1">{{ $pen['type'] }}</p>
                        </div>
                        <span class="px-3 py-1 bg-{{ $pen['color'] }}-50 text-{{ $pen['color'] }}-600 rounded-full text-[9px] font-black border border-{{ $pen['color'] }}-100 uppercase tracking-widest">{{ $pen['tag'] }}</span>
                    </div>

                    <div class="grid grid-cols-3 gap-3 mb-8">
                        <div class="bg-slate-50 rounded-2xl p-4 text-center group-hover:bg-green-50 transition-colors">
                            <p class="text-slate-400 text-[8px] uppercase font-black mb-1">Pigs</p>
                            <p class="text-slate-900 font-black text-xl tracking-tight">{{ $pen['count'] }}</p>
                        </div>
                        <div class="bg-slate-50 rounded-2xl p-4 text-center">
                            <p class="text-slate-400 text-[8px] uppercase font-black mb-1">Sick</p>
                            <p class="{{ $pen['sick'] > 0 ? 'text-red-500' : 'text-slate-900' }} font-black text-xl tracking-tight">{{ $pen['sick'] }}</p>
                        </div>
                        <div class="bg-slate-50 rounded-2xl p-4 text-center">
                            <p class="text-slate-400 text-[8px] uppercase font-black mb-1">Avg Kg</p>
                            <p class="text-slate-900 font-black text-xl tracking-tight">{{ $pen['weight'] }}</p>
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <p class="text-slate-400 text-[9px] font-black uppercase tracking-widest">Weight Target</p>
                            <p class="text-slate-900 text-[9px] font-black">{{ $pen['progress'] }}%</p>
                        </div>
                        <div class="w-full h-2.5 bg-slate-100 rounded-full overflow-hidden p-0.5">
                            <div class="h-full bg-{{ $pen['color'] }}-500 rounded-full shadow-[0_0_10px_rgba(0,0,0,0.1)] transition-all duration-1000" style="width: {{ $pen['progress'] }}%"></div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Recent Logs Header -->
        <div class="flex items-center justify-between mb-8 px-1">
            <div>
                <h2 class="text-2xl md:text-3xl font-black text-slate-900 tracking-tight">Recent Activity</h2>
                <p class="text-[10px] text-slate-400 uppercase font-black tracking-widest mt-1">Latest synchronization</p>
            </div>
            <a href="{{ route('worker.activity-log') }}" class="text-[10px] font-black text-green-600 uppercase tracking-[0.2em] hover:text-green-700 transition">View History</a>
        </div>

        <div id="recentMonitoringList" class="space-y-4 pb-20">
            <div class="bg-white rounded-[2rem] p-6 flex gap-5 items-center border border-slate-100 shadow-sm hover:shadow-md transition cursor-pointer">
                <div class="w-14 h-14 rounded-2xl bg-green-50 flex items-center justify-center shrink-0 border border-green-100 text-green-600">
                    <i class='bx bx-check-double text-2xl'></i>
                </div>
                <div class="flex-1">
                    <div class="flex justify-between items-start mb-0.5">
                        <p class="text-slate-900 font-black text-base tracking-tight">Pen 5 — Feeding Log Complete</p>
                        <span class="text-slate-300 text-[10px] font-black">2:30 PM</span>
                    </div>
                    <p class="text-slate-500 text-xs font-medium">500kg total distributed. All animals matched behavior specs.</p>
                </div>
            </div>
        </div>

    </div>
</div>

<style>
    @keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    .animate-fade-in { animation: fadeIn 0.6s cubic-bezier(0.23, 1, 0.32, 1) forwards; }
</style>
@endsection
