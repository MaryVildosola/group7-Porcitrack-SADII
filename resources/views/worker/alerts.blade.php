@extends('layouts.worker')

@section('content')
    <div class="p-6 md:p-12 max-w-full">

        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4 mb-8 md:mb-10">
            <div>
                <p class="text-sm md:text-base font-medium text-white/70 mb-1 md:mb-2">Stay Informed</p>
                <h1 class="text-3xl md:text-5xl font-bold text-white">Alerts</h1>
            </div>
            <div class="flex items-center gap-4">
                <button
                    class="relative w-12 h-12 rounded-full flex items-center justify-center glass-button hover:bg-white/20 transition shadow-lg">
                    <i class='bx bx-bell text-xl text-white'></i>
                    <span
                        class="absolute top-2.5 right-2.5 w-3 h-3 bg-red-500 rounded-full border border-[#428246] animate-pulse"></span>
                </button>
            </div>
        </div>

        <!-- Alert Filters -->
        <div class="flex flex-wrap gap-2 md:gap-4 mb-8">
            <button onclick="filterAlerts('Critical')"
                class="px-4 md:px-6 py-2 md:py-3 bg-red-500/30 text-red-300 border border-red-400/40 rounded-xl font-medium hover:bg-red-500/40 transition text-xs md:text-sm shadow-md">
                Critical
            </button>
            <button onclick="filterAlerts('Health')"
                class="px-4 md:px-6 py-2 md:py-3 bg-white/10 text-white/70 border border-white/20 rounded-xl font-medium hover:bg-white/20 transition text-xs md:text-sm">
                Health
            </button>
            <button onclick="filterAlerts('Maintenance')"
                class="px-4 md:px-6 py-2 md:py-3 bg-white/10 text-white/70 border border-white/20 rounded-xl font-medium hover:bg-white/20 transition text-xs md:text-sm">
                Maintenance
            </button>
        </div>

        <!-- Critical Alerts Section -->
        <div class="mb-10">
            <div class="flex items-center gap-2 mb-4">
                <i class='bx bx-error-circle text-red-500 text-2xl'></i>
                <h2 class="text-xl md:text-2xl font-bold text-white tracking-tight">Critical Alerts</h2>
                <span class="ml-2 px-3 py-0.5 bg-red-500/30 text-red-300 rounded-full text-[10px] md:text-xs font-bold border border-red-500/40">2</span>
            </div>

            <div class="space-y-4">
                <!-- Critical Alert 1 -->
                <div
                    class="glass-panel rounded-3xl p-5 md:p-6 border-l-4 border-red-500 hover:bg-white/10 transition cursor-pointer shadow-lg group">
                    <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-4">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-3">
                                <div class="w-10 h-10 rounded-2xl bg-white/5 flex items-center justify-center border border-white/10">
                                    <i class='bx bx-heart-broken text-red-400 text-lg'></i>
                                </div>
                                <div>
                                    <h3 class="text-base md:text-lg font-bold text-white">Pig #42 - Health Crisis</h3>
                                    <p class="text-[10px] md:text-sm text-white/40 uppercase tracking-widest">Pen 3 | 2 mins ago</p>
                                </div>
                            </div>
                            <p class="text-white/80 text-xs md:text-sm mb-4 leading-relaxed">Unusual behavior detected: rapid breathing, lethargy. Immediate veterinary attention required.</p>

                            <div class="flex gap-2">
                                <span class="px-2.5 py-1 bg-red-500/20 text-red-300 rounded-lg text-[9px] md:text-[10px] font-bold border border-red-500/30 uppercase">High Urgency</span>
                            </div>
                        </div>
                        <button onclick="takeAlertAction('Pig #42')"
                            class="w-full md:w-auto px-6 py-3 bg-red-500/20 text-red-300 border border-red-500/40 rounded-xl font-bold hover:bg-red-500/40 transition text-xs uppercase tracking-widest">
                            Take Action
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Alert Statistics -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6">
            <div class="glass-panel rounded-2xl p-5 md:p-6 shadow-md text-center">
                <p class="text-[10px] md:text-sm font-medium text-white/70 mb-2 uppercase tracking-tight">Active</p>
                <h3 class="text-2xl md:text-4xl font-bold text-red-400">2</h3>
            </div>
            <div class="glass-panel rounded-2xl p-5 md:p-6 shadow-md text-center">
                <p class="text-[10px] md:text-sm font-medium text-white/70 mb-2 uppercase tracking-tight">Resolved</p>
                <h3 class="text-2xl md:text-4xl font-bold text-emerald-400">8</h3>
            </div>
        </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function filterAlerts(type) {
            Swal.fire({ title: 'Alert Filter', text: 'Displaying ' + type + ' alerts...', icon: 'info', timer: 1500, showConfirmButton: false, background: '#1a0a0a', color: '#fff' });
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
                background: '#1a0a0a',
                color: '#fff'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({ title: 'Protocol Active', text: 'HQ has been notified. Med-kit deployed.', icon: 'success', background: '#1a0a0a', color: '#fff' });
                }
            });
        }
    </script>
@endsection
