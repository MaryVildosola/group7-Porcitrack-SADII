@extends('layouts.worker')

@section('content')
<div class="p-6 md:p-12 max-w-full">
    <div class="mb-10">
        <p class="text-sm font-medium text-white/60 mb-2 uppercase tracking-widest">Mandatory Log</p>
        <h1 class="text-3xl md:text-5xl font-bold text-white tracking-tight">Weekly Report</h1>
    </div>

    @if(session('success'))
        <div class="glass-panel p-6 rounded-3xl bg-green-500/20 border-green-500/50 mb-8 flex items-center gap-4 animate-fade-in shadow-2xl">
            <i class='bx bxs-check-circle text-3xl text-green-400'></i>
            <div>
                <p class="text-white font-bold">Submission Successful!</p>
                <p class="text-white/60 text-sm">Your weekly data has been securely sent to the administrator.</p>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Status Card -->
        <div class="lg:col-span-1">
            <div class="glass-panel p-8 rounded-[2.5rem] relative overflow-hidden group border border-white/5 shadow-2xl">
                <div class="relative z-10 text-center">
                    <div class="w-20 h-20 rounded-3xl bg-white/10 mx-auto flex items-center justify-center mb-6">
                        @if($existingReport)
                             <i class='bx bxs-check-shield text-4xl text-green-400'></i>
                        @else
                             <i class='bx bx-time-five text-4xl text-yellow-400 animate-pulse'></i>
                        @endif
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">Current Status</h3>
                    <p class="text-white/40 text-xs uppercase tracking-widest font-bold mb-6">Week of {{ \Carbon\Carbon::parse($thisWeek)->format('M d') }}</p>
                    
                    @if($existingReport)
                        <div class="px-6 py-3 bg-green-500/20 text-green-300 rounded-2xl font-bold border border-green-500/30 uppercase tracking-widest">SUBMITTED</div>
                    @else
                        <div class="px-6 py-3 bg-yellow-500/20 text-yellow-300 rounded-2xl font-bold border border-yellow-500/30 uppercase tracking-widest">PENDING</div>
                    @endif
                </div>
                <i class='bx bx-calendar absolute bottom-[-20px] left-[-20px] text-8xl text-white/5'></i>
            </div>
        </div>

        <!-- Submission Form -->
        <div class="lg:col-span-2">
            <div class="glass-panel p-8 md:p-10 rounded-[2.5rem] shadow-2xl border border-white/10">
                <form action="{{ route('worker.reports.store') }}" method="POST">
                    @csrf
                    <div class="mb-8">
                        <label class="block text-xs font-bold text-white/40 uppercase tracking-widest mb-4">Detailed Progress Summary</label>
                        <textarea name="details" rows="8" placeholder="Summarize your work, observations, and any issues encountered this week..."
                                  class="w-full bg-white/5 border border-white/10 rounded-3xl p-6 text-white focus:outline-none focus:border-green-500/40 transition text-lg placeholder:text-white/20"
                                  {{ $existingReport ? 'readonly' : '' }}>{{ $existingReport ? $existingReport->details : old('details') }}</textarea>
                        @error('details') <p class="text-red-400 text-xs mt-2 font-bold">{{ $message }}</p> @enderror
                    </div>

                    @if(!$existingReport)
                        <button type="submit" class="w-full bg-gradient-to-r from-blue-500 to-blue-600 text-white py-5 rounded-[1.5rem] font-bold text-xl hover:shadow-[0_10px_40px_rgba(59,130,246,0.3)] transition active:scale-[0.98] flex items-center justify-center gap-3">
                            <i class='bx bx-paper-plane'></i> Submit Weekly Report
                        </button>
                    @else
                        <button type="button" disabled class="w-full bg-white/5 text-white/20 py-5 rounded-[1.5rem] font-bold text-xl pointer-events-none border border-white/5">
                            Report already submitted
                        </button>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
