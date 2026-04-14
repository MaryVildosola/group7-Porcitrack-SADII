@extends('layouts.worker')

@section('content')
    <div class="flex h-screen w-screen bg-gradient-to-br from-[#1a472a] via-[#0f2818] to-[#050a08]">

        <!-- Sidebar Navigation -->
        <aside class="w-72 bg-white/5 backdrop-blur-md border-r border-white/10 flex flex-col shrink-0">
            <div class="p-6 border-b border-white/10">
                <div class="flex items-center gap-3">
                    <div
                        class="w-12 h-12 rounded-lg bg-gradient-to-br from-[#428246] to-[#2d5a2f] flex items-center justify-center">
                        <i class='bx bx-pig text-xl text-white font-bold'></i>
                    </div>
                    <div>
                        <h2 class="font-bold text-white">Porcitrack</h2>
                        <p class="text-xs text-white/60">Worker Portal</p>
                    </div>
                </div>
            </div>

            <nav class="flex-1 px-4 py-6 space-y-2">
                <a href="{{ route('worker.dashboard') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl bg-white/15 text-white font-medium transition hover:bg-white/25">
                    <i class='bx bx-home text-lg'></i>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('worker.tasks') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl text-white/70 font-medium transition hover:bg-white/10 hover:text-white">
                    <i class='bx bx-task text-lg'></i>
                    <span>Tasks</span>
                </a>
                <a href="{{ route('worker.alerts') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl text-white/70 font-medium transition hover:bg-white/10 hover:text-white">
                    <i class='bx bx-bell text-lg'></i>
                    <span>Alerts</span>
                </a>
                <a href="{{ route('worker.activity-log') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl text-white/70 font-medium transition hover:bg-white/10 hover:text-white">
                    <i class='bx bx-history text-lg'></i>
                    <span>Activity Log</span>
                </a>
            </nav>

            <div class="p-4 border-t border-white/10">
                <button
                    class="w-full flex items-center gap-3 px-4 py-3 hover:bg-white/10 rounded-lg transition relative group"
                    id="userMenuBtn">
                    <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center">
                        <i class='bx bx-user text-white'></i>
                    </div>
                    <div class="flex-1 min-w-0 text-left">
                        <p class="text-sm font-medium text-white truncate">{{ auth()->user()->name ?? 'User' }}</p>
                        <p class="text-xs text-white/60">Worker</p>
                    </div>
                    <i class='bx bx-chevron-down text-white/60'></i>
                </button>

                <!-- User Dropdown Menu -->
                <div id="userDropdown"
                    class="absolute bottom-20 left-4 right-4 bg-white/10 backdrop-blur-md border border-white/20 rounded-lg shadow-lg hidden z-50">
                    <div class="p-3 border-b border-white/10">
                        <p class="text-sm font-medium text-white">{{ auth()->user()->name ?? 'User' }}</p>
                        <p class="text-xs text-white/60">{{ auth()->user()->email ?? 'worker@porcitrack.com' }}</p>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" class="p-2">
                        @csrf
                        <button type="submit"
                            class="w-full flex items-center gap-3 px-4 py-2 text-white hover:bg-white/10 rounded-lg transition text-sm font-medium">
                            <i class='bx bx-log-out text-lg'></i>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto overflow-x-hidden">
            <div class="p-12 max-w-full">

                <!-- Header Section -->
                <div class="flex justify-between items-center mb-10">
                    <div>
                        <p class="text-base font-medium text-white/70 mb-2">Welcome back,</p>
                        <h1 class="text-5xl font-bold text-white">{{ auth()->user()->name ?? 'Worker' }}</h1>
                    </div>
                    <div class="flex items-center gap-4">
                        <button
                            class="relative w-12 h-12 rounded-full flex items-center justify-center glass-button hover:bg-white/20 transition">
                            <i class='bx bx-bell text-xl text-white'></i>
                            <!-- Notification Dot -->
                            <span
                                class="absolute top-2.5 right-2.5 w-3 h-3 bg-red-500 rounded-full border border-[#428246] animate-pulse"></span>
                        </button>
                        <button
                            class="w-12 h-12 rounded-full flex items-center justify-center glass-button hover:bg-white/20 transition">
                            <i class='bx bx-search text-xl text-white'></i>
                        </button>
                    </div>
                </div>

                <!-- Primary Action Section -->
                <div class="mb-10">
                    <button
                        class="w-full h-56 glass-panel rounded-3xl flex flex-col items-center justify-center relative overflow-hidden group hover:bg-white/20 transition-all active:scale-[0.98] shadow-2xl">
                        <div
                            class="absolute inset-0 bg-gradient-to-br from-white/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity">
                        </div>
                        <div
                            class="mb-5 relative z-10 w-24 h-24 bg-gradient-to-br from-white/30 to-white/10 border border-white/40 rounded-3xl flex items-center justify-center shadow-lg">
                            <i class='bx bx-qr-scan text-6xl font-light text-white drop-shadow'></i>
                        </div>
                        <h2 class="text-4xl font-bold tracking-wide relative z-10 text-white drop-shadow-md">Scan Pen Gate
                        </h2>
                        <p class="text-white/60 text-sm mt-2 relative z-10">Quick access to pen management</p>

                        <!-- Subtle decorative background blob -->
                        <div class="absolute -top-20 -right-20 w-56 h-56 bg-white/5 rounded-full blur-3xl"></div>
                    </button>
                </div>

                <!-- Stats Grid (4 columns) -->
                <div class="grid grid-cols-4 gap-8 mb-10">

                    <!-- Pending Tasks -->
                    <div
                        class="glass-panel rounded-2xl p-8 flex flex-col justify-between min-h-[200px] relative overflow-hidden group hover:bg-white/20 transition-all cursor-pointer">
                        <div>
                            <p class="text-sm font-medium text-white/70 mb-6">Pending Tasks</p>
                            <h3 class="text-5xl font-bold text-white drop-shadow-sm">4</h3>
                        </div>
                        <i class='bx bx-list-check absolute bottom-4 right-4 text-6xl text-white/10'></i>
                    </div>

                    <!-- Critical Alerts -->
                    <div
                        class="glass-panel rounded-2xl p-8 flex flex-col justify-between min-h-[200px] relative overflow-hidden group hover:bg-white/20 transition-all cursor-pointer border border-red-400/20">
                        <div>
                            <div class="flex items-center gap-2 mb-1">
                                <div class="w-2.5 h-2.5 bg-red-400 rounded-full animate-pulse"></div>
                                <p class="text-sm font-medium text-red-300">Critical Alerts</p>
                            </div>
                            <h3 class="text-5xl font-bold text-red-400 drop-shadow-sm mt-4">1</h3>
                        </div>
                        <i class='bx bx-error-alt absolute bottom-4 right-4 text-6xl text-red-500/10'></i>
                    </div>

                    <!-- Pens Fed Today -->
                    <div
                        class="glass-panel rounded-2xl p-8 flex flex-col justify-between min-h-[200px] relative overflow-hidden group hover:bg-white/20 transition-all cursor-pointer">
                        <div>
                            <p class="text-sm font-medium text-white/70 mb-6">Pens Fed Today</p>
                            <h3 class="text-5xl font-bold text-green-400 drop-shadow-sm">12</h3>
                        </div>
                        <i class='bx bxs-bowl-rice absolute bottom-4 right-4 text-6xl text-green-500/10'></i>
                    </div>

                    <!-- Health Status -->
                    <div
                        class="glass-panel rounded-2xl p-8 flex flex-col justify-between min-h-[200px] relative overflow-hidden group hover:bg-white/20 transition-all cursor-pointer">
                        <div>
                            <p class="text-sm font-medium text-white/70 mb-6">Healthy Pigs</p>
                            <h3 class="text-5xl font-bold text-blue-400 drop-shadow-sm">48</h3>
                        </div>
                        <i class='bx bx-check-circle absolute bottom-4 right-4 text-6xl text-blue-500/10'></i>
                    </div>

                </div>

                <!-- Recent Activity & Quick Stats Section -->
                <div class="grid grid-cols-3 gap-8">

                    <!-- Recent Activity (2 columns) -->
                    <div class="col-span-2">
                        <div class="glass-panel rounded-2xl p-8">
                            <div class="flex justify-between items-center mb-6">
                                <h3 class="text-lg font-semibold tracking-wide text-white">Recent Activity</h3>
                                <button class="text-sm text-white/60 hover:text-white transition font-medium">View all
                                    →</button>
                            </div>

                            <div class="space-y-3">

                                <!-- Activity Item 1 -->
                                <div
                                    class="flex items-center gap-4 pb-4 border-b border-white/10 last:border-0 hover:bg-white/5 p-3 rounded-lg transition cursor-pointer">
                                    <div
                                        class="w-12 h-12 rounded-full bg-green-500/30 flex items-center justify-center border border-green-400/40 shrink-0">
                                        <i class='bx bxs-bowl-rice text-white text-lg'></i>
                                    </div>
                                    <div class="flex-grow">
                                        <p class="font-medium text-white">Pen 5 Fed</p>
                                        <p class="text-sm text-white/60">2 hours ago</p>
                                    </div>
                                    <span
                                        class="text-xs bg-green-500/20 text-green-300 px-3 py-1 rounded-full">Completed</span>
                                </div>

                                <!-- Activity Item 2 -->
                                <div
                                    class="flex items-center gap-4 pb-4 border-b border-white/10 last:border-0 hover:bg-white/5 p-3 rounded-lg transition cursor-pointer">
                                    <div
                                        class="w-12 h-12 rounded-full bg-red-500/40 flex items-center justify-center border border-red-500/50 shrink-0">
                                        <i class='bx bx-alert-triangle text-white text-lg'></i>
                                    </div>
                                    <div class="flex-grow">
                                        <p class="font-medium text-white">Pig #105 Health Alert</p>
                                        <p class="text-sm text-white/60">Sick | 4 hours ago</p>
                                    </div>
                                    <span class="text-xs bg-red-500/20 text-red-300 px-3 py-1 rounded-full">Alert</span>
                                </div>

                                <!-- Activity Item 3 -->
                                <div
                                    class="flex items-center gap-4 pb-4 border-b border-white/10 last:border-0 hover:bg-white/5 p-3 rounded-lg transition cursor-pointer">
                                    <div
                                        class="w-12 h-12 rounded-full bg-blue-500/30 flex items-center justify-center border border-blue-400/40 shrink-0">
                                        <i class='bx bx-water text-white text-lg'></i>
                                    </div>
                                    <div class="flex-grow">
                                        <p class="font-medium text-white">Pen 8 Water Refilled</p>
                                        <p class="text-sm text-white/60">6 hours ago</p>
                                    </div>
                                    <span
                                        class="text-xs bg-blue-500/20 text-blue-300 px-3 py-1 rounded-full">Completed</span>
                                </div>

                                <!-- Activity Item 4 -->
                                <div
                                    class="flex items-center gap-4 hover:bg-white/5 p-3 rounded-lg transition cursor-pointer">
                                    <div
                                        class="w-12 h-12 rounded-full bg-amber-500/30 flex items-center justify-center border border-amber-400/40 shrink-0">
                                        <i class='bx bx-time text-white text-lg'></i>
                                    </div>
                                    <div class="flex-grow">
                                        <p class="font-medium text-white">Temperature Check - Pen 3</p>
                                        <p class="text-sm text-white/60">7 hours ago</p>
                                    </div>
                                    <span
                                        class="text-xs bg-amber-500/20 text-amber-300 px-3 py-1 rounded-full">Pending</span>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- Quick Stats Widget -->
                    <div class="glass-panel rounded-2xl p-8">
                        <h3 class="text-lg font-semibold text-white mb-6">Today's Summary</h3>

                        <div class="space-y-4">
                            <div class="flex justify-between items-center p-3 bg-white/5 rounded-lg">
                                <span class="flex items-center gap-2 text-white/80">
                                    <i class='bx bxs-bowl-rice text-green-400 text-lg'></i>
                                    Feedings
                                </span>
                                <span class="font-bold text-white">12/15</span>
                            </div>

                            <div class="flex justify-between items-center p-3 bg-white/5 rounded-lg">
                                <span class="flex items-center gap-2 text-white/80">
                                    <i class='bx bx-water text-blue-400 text-lg'></i>
                                    Water Checks
                                </span>
                                <span class="font-bold text-white">8/12</span>
                            </div>

                            <div class="flex justify-between items-center p-3 bg-white/5 rounded-lg">
                                <span class="flex items-center gap-2 text-white/80">
                                    <i class='bx bx-time text-amber-400 text-lg'></i>
                                    Temperature
                                </span>
                                <span class="font-bold text-white">5/8</span>
                            </div>

                            <div class="mt-6 pt-4 border-t border-white/10">
                                <p class="text-sm text-white/60 mb-3">Efficiency</p>
                                <div class="w-full bg-white/10 rounded-full h-3">
                                    <div
                                        class="bg-gradient-to-r from-green-400 to-blue-400 h-3 rounded-full w-3/4 shadow-lg shadow-green-400/30">
                                    </div>
                                </div>
                                <p class="text-right text-xs text-white/60 mt-2">75% Complete</p>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </main>

    </div>

    <script>
        // User menu dropdown toggle
        const userMenuBtn = document.getElementById('userMenuBtn');
        const userDropdown = document.getElementById('userDropdown');

        userMenuBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            userDropdown.classList.toggle('hidden');
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!userMenuBtn.contains(e.target) && !userDropdown.contains(e.target)) {
                userDropdown.classList.add('hidden');
            }
        });
    </script>
@endsection
