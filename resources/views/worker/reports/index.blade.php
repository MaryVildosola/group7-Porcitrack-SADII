@extends('layouts.worker')

@section('content')
<div class="p-6 md:p-12 max-w-full">
    <div class="mb-10 flex flex-col md:flex-row md:items-end justify-between gap-6">
        <div>
            <p class="text-sm font-medium text-white/40 mb-2 uppercase tracking-[0.2em]">Operational Intelligence</p>
            <h1 class="text-4xl md:text-6xl font-extrabold text-white tracking-tighter">Weekly Analytics</h1>
        </div>
        <div class="glass-panel px-6 py-4 rounded-3xl border border-white/10 flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-blue-500/20 flex items-center justify-center">
                <i class='bx bx-calendar text-2xl text-blue-400'></i>
            </div>
            <div>
                <p class="text-white/40 text-[10px] uppercase font-bold tracking-widest leading-none mb-1">Current Period</p>
                <p class="text-white font-bold">{{ \Carbon\Carbon::parse($thisWeek)->format('M d') }} — {{ \Carbon\Carbon::parse($thisWeek)->endOfWeek()->format('M d, Y') }}</p>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="glass-panel p-6 rounded-[2rem] bg-green-500/20 border-green-500/30 mb-10 flex items-center gap-5 animate-bounce-subtle">
            <div class="w-14 h-14 rounded-2xl bg-green-500/20 flex items-center justify-center">
                <i class='bx bxs-check-shield text-3xl text-green-400'></i>
            </div>
            <div>
                <p class="text-white font-black text-xl">Report Synchronized</p>
                <p class="text-white/60 text-sm font-medium">Your weekly analytics have been securely transmitted to HQ.</p>
            </div>
        </div>
    @endif

    <!-- Analytics Dashboard -->
    <div class="grid grid-cols-1 xl:grid-cols-4 gap-6 mb-10">
        <!-- Stat Cards -->
        <div class="xl:col-span-3 grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="glass-panel p-8 rounded-[2.5rem] relative overflow-hidden group">
                <div class="relative z-10">
                    <p class="text-white/40 text-xs font-bold uppercase tracking-widest mb-4">Live Population</p>
                    <h3 class="text-5xl font-black text-white mb-2">{{ $analytics['total_pigs'] }}</h3>
                    <p class="text-green-400 text-xs font-medium flex items-center gap-1">
                        <i class='bx bx-trending-up'></i> +12% from last week
                    </p>
                </div>
                <i class='bx bxs-group absolute bottom-[-20px] right-[-20px] text-8xl text-white/5 group-hover:scale-110 transition duration-700'></i>
            </div>

            <div class="glass-panel p-8 rounded-[2.5rem] relative overflow-hidden group border-l-4 border-red-500/30">
                <div class="relative z-10">
                    <p class="text-white/40 text-xs font-bold uppercase tracking-widest mb-4">Health Alerts</p>
                    <h3 class="text-5xl font-black text-red-400 mb-2">{{ $analytics['sick_pigs'] }}</h3>
                    <p class="text-red-400/60 text-xs font-medium">Critical attention required</p>
                </div>
                <i class='bx bxs-virus absolute bottom-[-20px] right-[-20px] text-8xl text-red-500/5 group-hover:scale-110 transition duration-700'></i>
            </div>

            <div class="glass-panel p-8 rounded-[2.5rem] relative overflow-hidden group">
                <div class="relative z-10">
                    <p class="text-white/40 text-xs font-bold uppercase tracking-widest mb-4">Avg. Weight</p>
                    <h3 class="text-5xl font-black text-blue-400 mb-2">{{ $analytics['avg_weight'] }}<span class="text-2xl ml-1">kg</span></h3>
                    <p class="text-blue-400/60 text-xs font-medium">Batch performance stable</p>
                </div>
                <i class='bx bxs-tachometer absolute bottom-[-20px] right-[-20px] text-8xl text-blue-500/5 group-hover:scale-110 transition duration-700'></i>
            </div>
        </div>

        <!-- Submission Status Side -->
        <div class="xl:col-span-1">
            <div class="glass-panel p-8 rounded-[2.5rem] h-full flex flex-col justify-center items-center text-center border-2 {{ $existingReport ? 'border-green-500/30 bg-green-500/5' : 'border-yellow-500/30 bg-yellow-500/5' }}">
                <div class="w-20 h-20 rounded-3xl flex items-center justify-center mb-6 {{ $existingReport ? 'bg-green-500/20' : 'bg-yellow-500/20' }}">
                     @if($existingReport)
                        <i class='bx bxs-badge-check text-5xl text-green-400 animate-pulse'></i>
                     @else
                        <i class='bx bx-error-circle text-5xl text-yellow-400 animate-pulse'></i>
                     @endif
                </div>
                <h4 class="text-2xl font-black text-white mb-2">{{ $existingReport ? 'Sync Complete' : 'Sync Pending' }}</h4>
                <p class="text-white/50 text-sm font-medium mb-6">
                    {{ $existingReport ? 'Your report for this week is safely stored in our HQ database.' : 'A weekly report is required to maintain operational records.' }}
                </p>
                @if($existingReport)
                    <div class="text-[10px] font-black uppercase tracking-[0.2em] text-green-400 bg-green-500/10 px-4 py-2 rounded-full border border-green-500/20">
                        Received by HQ
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">
        <!-- Performance Visualization -->
        <div class="lg:col-span-2">
            <div class="glass-panel p-8 rounded-[3rem] h-full relative overflow-hidden backdrop-blur-3xl border border-white/10">
                <div class="flex items-center justify-between mb-8 relative z-10">
                    <div>
                        <h3 class="text-2xl font-black text-white">Yield Performance</h3>
                        <p class="text-white/40 text-xs uppercase tracking-widest font-bold">7-Day Growth Efficiency</p>
                    </div>
                    <div class="flex gap-2">
                        <span class="w-3 h-3 rounded-full bg-blue-500"></span>
                        <span class="w-3 h-3 rounded-full bg-white/10"></span>
                    </div>
                </div>
                
                <div class="relative h-[300px] w-full">
                    <canvas id="yieldChart"></canvas>
                </div>
                
                <div class="grid grid-cols-2 gap-4 mt-8">
                    <div class="p-4 rounded-2xl bg-white/5 border border-white/5">
                        <p class="text-white/40 text-[10px] uppercase font-bold tracking-widest mb-1">Peak Efficiency</p>
                        <p class="text-white font-bold">Pen 12 (94%)</p>
                    </div>
                    <div class="p-4 rounded-2xl bg-white/5 border border-white/5">
                        <p class="text-white/40 text-[10px] uppercase font-bold tracking-widest mb-1">Weekly Feed Cost</p>
                        <p class="text-white font-bold">₱42,500.00</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Submission Form -->
        <div class="lg:col-span-1">
            <div class="glass-panel p-8 md:p-10 rounded-[3rem] shadow-2xl relative overflow-hidden border border-white/15">
                <form action="{{ route('worker.reports.store') }}" method="POST" id="submissionForm">
                    @csrf
                    <div class="space-y-6">
                        <h3 class="text-2xl font-black text-white">Submit to HQ</h3>
                        
                        <!-- Hidden Stats Fields (Pre-filled from Analytics) -->
                        <input type="hidden" name="total_pigs" value="{{ $analytics['total_pigs'] }}">
                        <input type="hidden" name="sick_pigs" value="{{ $analytics['sick_pigs'] }}">
                        <input type="hidden" name="avg_weight" value="{{ $analytics['avg_weight'] }}">
                        
                        <div>
                            <label class="block text-[10px] font-black text-white/40 uppercase tracking-[0.2em] mb-3">Feed Consumption (KG)</label>
                            <input type="number" name="feed_consumed" placeholder="Enter total KG used..." required
                                   class="w-full bg-white/5 border border-white/10 rounded-2xl p-4 text-white focus:outline-none focus:border-blue-500/50 transition font-bold"
                                   value="{{ $existingReport ? $existingReport->feed_consumed : '' }}" {{ $existingReport ? 'disabled' : '' }}>
                        </div>

                        <div>
                            <label class="block text-[10px] font-black text-white/40 uppercase tracking-[0.2em] mb-3">Operational Notes</label>
                            <textarea name="details" rows="5" placeholder="Summarize weekly activities, mortalities, or infrastructure issues..." required
                                      class="w-full bg-white/5 border border-white/10 rounded-2xl p-6 text-white focus:outline-none focus:border-blue-500/50 transition text-sm font-medium placeholder:text-white/20"
                                      {{ $existingReport ? 'disabled' : '' }}>{{ $existingReport ? $existingReport->details : old('details') }}</textarea>
                            @error('details') <p class="text-red-400 text-[10px] mt-2 font-black uppercase">{{ $message }}</p> @enderror
                        </div>

                        @if(!$existingReport)
                            <button type="submit" class="w-full bg-gradient-to-br from-blue-500 to-indigo-600 text-white py-5 rounded-[2rem] font-black text-lg hover:shadow-[0_20px_50px_rgba(59,130,246,0.3)] transition active:scale-[0.98] flex items-center justify-center gap-3 group">
                                <i class='bx bxs-cloud-upload text-2xl group-hover:animate-bounce'></i> Sync with HQ
                            </button>
                        @else
                            <button type="button" disabled class="w-full bg-white/5 text-white/20 py-5 rounded-[2rem] font-black text-lg pointer-events-none border border-white/5 flex items-center justify-center gap-3">
                                <i class='bx bxs-lock-alt'></i> Revision Locked
                            </button>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const ctx = document.getElementById('yieldChart').getContext('2d');
        
        // Custom Gradient for Chart
        const gradient = ctx.createLinearGradient(0, 0, 0, 300);
        gradient.addColorStop(0, 'rgba(59, 130, 246, 0.4)');
        gradient.addColorStop(1, 'rgba(59, 130, 246, 0)');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                datasets: [{
                    label: 'Batch Growth',
                    data: @json($analytics['weekly_progress']),
                    borderColor: '#3b82f6',
                    borderWidth: 4,
                    pointBackgroundColor: '#3b82f6',
                    pointBorderColor: 'rgba(255,255,255,0.2)',
                    pointBorderWidth: 8,
                    pointRadius: 6,
                    pointHoverRadius: 10,
                    tension: 0.4,
                    fill: true,
                    backgroundColor: gradient
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { color: 'rgba(255,255,255,0.4)', font: { weight: 'bold', size: 10 } }
                    },
                    y: {
                        display: false,
                        grid: { display: false }
                    }
                }
            }
        });
    });
</script>

<style>
    @keyframes bounce-subtle {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-5px); }
    }
    .animate-bounce-subtle {
        animation: bounce-subtle 3s ease-in-out infinite;
    }
</style>
@endsection
