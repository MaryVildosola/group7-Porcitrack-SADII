@extends('layouts.worker')

@section('content')
<div class="px-6 pt-10 pb-6">
    
    <!-- Header Section -->
    <div class="flex justify-between items-center mb-8">
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 rounded-full bg-white/20 flex items-center justify-center shadow-inner border border-white/30">
                <i class='bx bx-user text-2xl text-white'></i>
            </div>
            <div>
                <p class="text-sm font-medium text-white/80">Hello,</p>
                <h1 class="text-xl font-bold tracking-tight">Worker</h1>
            </div>
        </div>
        <button class="relative w-10 h-10 rounded-full flex items-center justify-center cursor-pointer glass-button hover:bg-white/30 transition float-right">
            <i class='bx bx-bell text-xl'></i>
            <!-- Notification Dot -->
            <span class="absolute top-2.5 right-2.5 w-2 h-2 bg-red-500 rounded-full border border-[#428246]"></span>
        </button>
    </div>

    <!-- Main Action Button -->
    <div class="mb-6">
        <button class="w-full h-40 glass-panel rounded-[2rem] flex flex-col items-center justify-center relative overflow-hidden group hover:bg-white/20 transition-all active:scale-[0.98]">
            <div class="mb-3 relative z-10 w-16 h-16 bg-white/20 border border-white/40 rounded-2xl flex items-center justify-center shadow-lg">
                <i class='bx bx-qr-scan text-3xl font-light text-white drop-shadow'></i>
            </div>
            <h2 class="text-[1.35rem] font-bold tracking-wide relative z-10 text-white drop-shadow-sm">Scan Pen Gate</h2>
            
            <!-- Subtle decorative background blob -->
            <div class="absolute -top-10 -right-10 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
        </button>
    </div>

    <!-- Stat Grid -->
    <div class="grid grid-cols-2 gap-4 mb-8">
        
        <!-- Pending Tasks -->
        <div class="glass-panel rounded-[1.75rem] p-5 flex flex-col justify-center min-h-[120px] relative overflow-hidden group hover:bg-white/20 transition-all cursor-pointer">
            <p class="text-sm font-medium text-white/80 mb-2 leading-tight">Pending<br>Tasks</p>
            <h3 class="text-3xl font-bold text-white drop-shadow-sm">4</h3>
            <!-- icon -->
            <i class='bx bx-list-check absolute bottom-3 right-4 text-4xl text-white/20'></i>
        </div>

        <!-- Critical Alerts -->
        <div class="glass-panel rounded-[1.75rem] p-5 flex flex-col justify-center min-h-[120px] relative overflow-hidden group hover:bg-white/20 transition-all cursor-pointer">
            <div class="absolute top-4 right-4 w-2 h-2 bg-red-400 rounded-full"></div>
            <h3 class="text-4xl font-bold text-red-400 drop-shadow-sm mb-1">1</h3>
            <p class="text-[0.8rem] font-medium text-white/80 leading-tight">Critical<br>Alerts</p>
            <!-- icon -->
            <i class='bx bx-error-alt absolute bottom-3 right-4 text-4xl text-red-500/20'></i>
        </div>

    </div>

    <!-- Recent Activity List -->
    <div>
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-sm font-semibold tracking-wide text-white/90">Recent Activity</h3>
            <button class="text-xs text-white/60 hover:text-white transition">View all</button>
        </div>
        
        <div class="flex flex-col gap-3">
            
            <!-- Activity Item 1 -->
            <div class="glass-panel rounded-2xl p-4 flex items-center gap-4">
                <div class="w-10 h-10 rounded-full bg-green-500/30 flex items-center justify-center border border-green-400/40 shrink-0">
                    <i class='bx bxs-bowl-rice text-white text-lg'></i>
                </div>
                <div class="flex-grow">
                    <p class="font-medium text-sm">Pen 5 Fed</p>
                    <p class="text-[0.7rem] text-white/60">2 hours ago</p>
                </div>
                <i class='bx bx-chevron-right text-white/40'></i>
            </div>
            
            <!-- Activity Item 2 -->
            <div class="glass-panel rounded-2xl p-4 flex items-center gap-4">
                <div class="w-10 h-10 rounded-full bg-red-500/40 flex items-center justify-center border border-red-500/50 shrink-0 relative">
                    <span class="absolute text-[0.6rem] font-bold">105</span>
                </div>
                <div class="flex-grow">
                    <p class="font-medium text-sm">Pig #105 Reported</p>
                    <p class="text-[0.7rem] text-white/60">Sick | 4 hours ago</p>
                </div>
                <i class='bx bx-chevron-right text-white/40'></i>
            </div>

        </div>
    </div>

</div>
@endsection
