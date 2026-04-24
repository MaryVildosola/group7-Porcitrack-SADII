@extends('layouts.worker')

@section('content')
<style>
    .worker-dash .text-white          { color: #1e293b !important; }
    .worker-dash .text-white\/30,
    .worker-dash .text-white\/40,
    .worker-dash .text-white\/50,
    .worker-dash .text-white\/60,
    .worker-dash .text-white\/70,
    .worker-dash .text-white\/80      { color: #64748b !important; }
    .worker-dash .bg-white\/5,
    .worker-dash .bg-white\/10,
    .worker-dash .bg-white\/15        { background-color: rgba(0,0,0,0.05) !important; }
    .worker-dash .border-white\/10,
    .worker-dash .border-white\/5     { border-color: rgba(0,0,0,0.1) !important; }
    .worker-dash .hover\:bg-white\/10:hover { background-color: rgba(0,0,0,0.07) !important; }
    .worker-dash .glass-panel         { background: rgba(255,255,255,0.85) !important; border-color: rgba(0,0,0,0.1) !important; }
</style>
<div class="worker-dash min-h-screen bg-[#f8fafc]">
    <div class="p-6 md:p-12 max-w-full">

        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4 mb-8 md:mb-10">
            <div>
                <p class="text-sm md:text-base font-medium text-white/70 mb-1 md:mb-2">Your Work History</p>
                <h1 class="text-3xl md:text-5xl font-bold text-white tracking-tight">Activity Log</h1>
            </div>
        </div>

        <!-- Activity Timeline -->
        <div class="space-y-6">
            <!-- Day Divider -->
            <div class="flex items-center gap-3">
                <div class="h-px bg-white/10 flex-1"></div>
                <span class="text-[10px] md:text-xs text-white/40 uppercase tracking-widest font-bold">Today</span>
                <div class="h-px bg-white/10 flex-1"></div>
            </div>

            <!-- Activity Entry 1 -->
            <div class="glass-panel rounded-3xl p-5 md:p-6 hover:bg-white/10 transition cursor-pointer shadow-lg group border border-white/10">
                <div class="flex gap-4">
                    <div class="flex flex-col items-center">
                        <div class="w-10 h-10 md:w-12 md:h-12 rounded-2xl bg-green-500/30 flex items-center justify-center border border-green-500/30 shadow-inner">
                            <i class='bx bxs-bowl-rice text-green-400 text-lg md:text-xl'></i>
                        </div>
                        <div class="w-0.5 flex-1 bg-gradient-to-b from-green-500/30 to-transparent mt-2"></div>
                    </div>
                    <div class="flex-1 pt-1">
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <h3 class="text-base md:text-lg font-bold text-white">Pen 5 Feeding</h3>
                                <p class="text-[10px] md:text-xs text-white/40 uppercase tracking-wider">Routine Activity</p>
                            </div>
                            <span class="text-[10px] md:text-sm text-white/40 font-medium">2:30 PM</span>
                        </div>
                        <p class="text-white/80 text-xs md:text-sm mb-4 leading-relaxed">Successfully fed 15 pigs in Pen 5. 5 kg feed consumed.</p>
                        <div class="flex gap-2">
                            <span class="px-2 py-0.5 bg-green-500/20 text-green-300 rounded-md text-[9px] md:text-[10px] font-bold border border-green-500/20 uppercase">Completed</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
