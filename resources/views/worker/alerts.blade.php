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
                    class="flex items-center gap-3 px-4 py-3 rounded-xl text-white/70 font-medium transition hover:bg-white/10 hover:text-white">
                    <i class='bx bx-home text-lg'></i>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('worker.tasks') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl text-white/70 font-medium transition hover:bg-white/10 hover:text-white">
                    <i class='bx bx-task text-lg'></i>
                    <span>Tasks</span>
                </a>
                <a href="{{ route('worker.alerts') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl bg-white/15 text-white font-medium transition hover:bg-white/25">
                    <i class='bx bx-bell text-lg'></i>
                    <span>Alerts</span>
                    <span class="ml-auto bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full">5</span>
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
                        <p class="text-base font-medium text-white/70 mb-2">Stay Informed</p>
                        <h1 class="text-5xl font-bold text-white">Alerts</h1>
                    </div>
                    <div class="flex items-center gap-4">
                        <button
                            class="relative w-12 h-12 rounded-full flex items-center justify-center glass-button hover:bg-white/20 transition">
                            <i class='bx bx-bell text-xl text-white'></i>
                            <span
                                class="absolute top-2.5 right-2.5 w-3 h-3 bg-red-500 rounded-full border border-[#428246] animate-pulse"></span>
                        </button>
                        <button
                            class="w-12 h-12 rounded-full flex items-center justify-center glass-button hover:bg-white/20 transition">
                            <i class='bx bx-search text-xl text-white'></i>
                        </button>
                    </div>
                </div>

                <!-- Alert Filters -->
                <div class="flex gap-4 mb-8 flex-wrap">
                    <button
                        class="px-6 py-3 bg-red-500/30 text-red-300 border border-red-400/40 rounded-xl font-medium hover:bg-red-500/40 transition">
                        All Alerts
                    </button>
                    <button
                        class="px-6 py-3 bg-white/10 text-white/70 border border-white/20 rounded-xl font-medium hover:bg-white/20 transition">
                        Critical
                    </button>
                    <button
                        class="px-6 py-3 bg-white/10 text-white/70 border border-white/20 rounded-xl font-medium hover:bg-white/20 transition">
                        High Priority
                    </button>
                    <button
                        class="px-6 py-3 bg-white/10 text-white/70 border border-white/20 rounded-xl font-medium hover:bg-white/20 transition">
                        Health
                    </button>
                    <button
                        class="px-6 py-3 bg-white/10 text-white/70 border border-white/20 rounded-xl font-medium hover:bg-white/20 transition">
                        Maintenance
                    </button>
                    <button
                        class="px-6 py-3 bg-white/10 text-white/70 border border-white/20 rounded-xl font-medium hover:bg-white/20 transition">
                        Resolved
                    </button>
                </div>

                <!-- Critical Alerts Section -->
                <div class="mb-10">
                    <div class="flex items-center gap-2 mb-4">
                        <i class='bx bx-error-circle text-red-500 text-2xl'></i>
                        <h2 class="text-2xl font-bold text-white">Critical Alerts</h2>
                        <span class="ml-2 px-3 py-1 bg-red-500/30 text-red-300 rounded-full text-sm font-bold">2</span>
                    </div>

                    <div class="space-y-3">
                        <!-- Critical Alert 1 -->
                        <div
                            class="glass-panel rounded-2xl p-6 border-l-4 border-red-500 hover:bg-white/20 transition cursor-pointer">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-3">
                                        <div class="w-10 h-10 rounded-full bg-red-500/30 flex items-center justify-center">
                                            <i class='bx bx-heart-broken text-red-400 text-lg'></i>
                                        </div>
                                        <div>
                                            <h3 class="text-lg font-semibold text-white">Pig #42 - Critical Health Issue
                                            </h3>
                                            <p class="text-sm text-white/60">Pen 3 | Detected 2 minutes ago</p>
                                        </div>
                                    </div>
                                    <p class="text-white/80 text-sm mb-4">Unusual behavior detected: rapid breathing,
                                        lethargy. Immediate veterinary attention required.</p>

                                    <div class="flex gap-3 mb-4">
                                        <span
                                            class="px-3 py-1 bg-red-500/20 text-red-300 rounded-full text-xs font-bold">CRITICAL</span>
                                        <span
                                            class="px-3 py-1 bg-orange-500/20 text-orange-300 rounded-full text-xs font-bold">REQUIRES
                                            ACTION</span>
                                    </div>
                                </div>
                                <button
                                    class="px-4 py-2 bg-red-500/30 text-red-300 border border-red-400/40 rounded-lg font-medium hover:bg-red-500/40 transition text-sm shrink-0 ml-4">
                                    Take Action
                                </button>
                            </div>
                        </div>

                        <!-- Critical Alert 2 -->
                        <div
                            class="glass-panel rounded-2xl p-6 border-l-4 border-red-500 hover:bg-white/20 transition cursor-pointer">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-3">
                                        <div class="w-10 h-10 rounded-full bg-red-500/30 flex items-center justify-center">
                                            <i class='bx bx-water text-red-400 text-lg'></i>
                                        </div>
                                        <div>
                                            <h3 class="text-lg font-semibold text-white">Pen 7 - Water System Failure</h3>
                                            <p class="text-sm text-white/60">System Status | Detected 15 minutes ago</p>
                                        </div>
                                    </div>
                                    <p class="text-white/80 text-sm mb-4">Automatic water dispenser is offline. Pigs need
                                        access to water immediately.</p>

                                    <div class="flex gap-3 mb-4">
                                        <span
                                            class="px-3 py-1 bg-red-500/20 text-red-300 rounded-full text-xs font-bold">CRITICAL</span>
                                        <span
                                            class="px-3 py-1 bg-purple-500/20 text-purple-300 rounded-full text-xs font-bold">MAINTENANCE</span>
                                    </div>
                                </div>
                                <button
                                    class="px-4 py-2 bg-red-500/30 text-red-300 border border-red-400/40 rounded-lg font-medium hover:bg-red-500/40 transition text-sm shrink-0 ml-4">
                                    Take Action
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- High Priority Alerts Section -->
                <div class="mb-10">
                    <div class="flex items-center gap-2 mb-4">
                        <i class='bx bx-alert text-yellow-500 text-2xl'></i>
                        <h2 class="text-2xl font-bold text-white">High Priority Alerts</h2>
                        <span
                            class="ml-2 px-3 py-1 bg-yellow-500/30 text-yellow-300 rounded-full text-sm font-bold">2</span>
                    </div>

                    <div class="space-y-3">
                        <!-- High Priority Alert 1 -->
                        <div
                            class="glass-panel rounded-2xl p-6 border-l-4 border-yellow-500 hover:bg-white/20 transition cursor-pointer">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-3">
                                        <div
                                            class="w-10 h-10 rounded-full bg-yellow-500/30 flex items-center justify-center">
                                            <i class='bx bx-temperature text-yellow-400 text-lg'></i>
                                        </div>
                                        <div>
                                            <h3 class="text-lg font-semibold text-white">Pen 2 - High Temperature</h3>
                                            <p class="text-sm text-white/60">Climate Control | Detected 1 hour ago</p>
                                        </div>
                                    </div>
                                    <p class="text-white/80 text-sm mb-4">Pen temperature is 28.5°C - higher than optimal
                                        (24-26°C). Check cooling system.</p>

                                    <div class="flex gap-3 mb-4">
                                        <span
                                            class="px-3 py-1 bg-yellow-500/20 text-yellow-300 rounded-full text-xs font-bold">HIGH
                                            PRIORITY</span>
                                        <span
                                            class="px-3 py-1 bg-blue-500/20 text-blue-300 rounded-full text-xs font-bold">CLIMATE</span>
                                    </div>
                                </div>
                                <button
                                    class="px-4 py-2 bg-yellow-500/30 text-yellow-300 border border-yellow-400/40 rounded-lg font-medium hover:bg-yellow-500/40 transition text-sm shrink-0 ml-4">
                                    Check Now
                                </button>
                            </div>
                        </div>

                        <!-- High Priority Alert 2 -->
                        <div
                            class="glass-panel rounded-2xl p-6 border-l-4 border-yellow-500 hover:bg-white/20 transition cursor-pointer">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-3">
                                        <div
                                            class="w-10 h-10 rounded-full bg-yellow-500/30 flex items-center justify-center">
                                            <i class='bx bx-food-menu text-yellow-400 text-lg'></i>
                                        </div>
                                        <div>
                                            <h3 class="text-lg font-semibold text-white">Feed Inventory - Low Stock</h3>
                                            <p class="text-sm text-white/60">Supply Management | Detected 3 hours ago</p>
                                        </div>
                                    </div>
                                    <p class="text-white/80 text-sm mb-4">Feed inventory at 15% capacity. Reorder needed
                                        within 2 days to avoid shortage.</p>

                                    <div class="flex gap-3 mb-4">
                                        <span
                                            class="px-3 py-1 bg-yellow-500/20 text-yellow-300 rounded-full text-xs font-bold">HIGH
                                            PRIORITY</span>
                                        <span
                                            class="px-3 py-1 bg-amber-500/20 text-amber-300 rounded-full text-xs font-bold">SUPPLY</span>
                                    </div>
                                </div>
                                <button
                                    class="px-4 py-2 bg-yellow-500/30 text-yellow-300 border border-yellow-400/40 rounded-lg font-medium hover:bg-yellow-500/40 transition text-sm shrink-0 ml-4">
                                    Order Now
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- General Alerts Section -->
                <div class="mb-10">
                    <div class="flex items-center gap-2 mb-4">
                        <i class='bx bx-info-circle text-blue-500 text-2xl'></i>
                        <h2 class="text-2xl font-bold text-white">General Alerts</h2>
                        <span class="ml-2 px-3 py-1 bg-blue-500/30 text-blue-300 rounded-full text-sm font-bold">1</span>
                    </div>

                    <div class="space-y-3">
                        <!-- General Alert -->
                        <div
                            class="glass-panel rounded-2xl p-6 border-l-4 border-blue-500 hover:bg-white/20 transition cursor-pointer">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-3">
                                        <div
                                            class="w-10 h-10 rounded-full bg-blue-500/30 flex items-center justify-center">
                                            <i class='bx bx-calendar-event text-blue-400 text-lg'></i>
                                        </div>
                                        <div>
                                            <h3 class="text-lg font-semibold text-white">Scheduled Maintenance - Pen 5</h3>
                                            <p class="text-sm text-white/60">Maintenance | Scheduled for tomorrow</p>
                                        </div>
                                    </div>
                                    <p class="text-white/80 text-sm mb-4">Routine pen cleaning and equipment inspection
                                        scheduled. No pigs will be affected.</p>

                                    <div class="flex gap-3 mb-4">
                                        <span
                                            class="px-3 py-1 bg-blue-500/20 text-blue-300 rounded-full text-xs font-bold">INFORMATION</span>
                                        <span
                                            class="px-3 py-1 bg-green-500/20 text-green-300 rounded-full text-xs font-bold">SCHEDULED</span>
                                    </div>
                                </div>
                                <button
                                    class="px-4 py-2 bg-blue-500/30 text-blue-300 border border-blue-400/40 rounded-lg font-medium hover:bg-blue-500/40 transition text-sm shrink-0 ml-4">
                                    Acknowledge
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Alert Statistics -->
                <div class="grid grid-cols-4 gap-6">
                    <div class="glass-panel rounded-2xl p-6">
                        <p class="text-sm font-medium text-white/70 mb-3">Total Alerts</p>
                        <h3 class="text-4xl font-bold text-white">5</h3>
                        <p class="text-xs text-white/60 mt-2">This month</p>
                    </div>
                    <div class="glass-panel rounded-2xl p-6">
                        <p class="text-sm font-medium text-white/70 mb-3">Critical</p>
                        <h3 class="text-4xl font-bold text-red-400">2</h3>
                        <p class="text-xs text-white/60 mt-2">Require action</p>
                    </div>
                    <div class="glass-panel rounded-2xl p-6">
                        <p class="text-sm font-medium text-white/70 mb-3">High Priority</p>
                        <h3 class="text-4xl font-bold text-yellow-400">2</h3>
                        <p class="text-xs text-white/60 mt-2">Check soon</p>
                    </div>
                    <div class="glass-panel rounded-2xl p-6">
                        <p class="text-sm font-medium text-white/70 mb-3">Resolved</p>
                        <h3 class="text-4xl font-bold text-emerald-400">8</h3>
                        <p class="text-xs text-white/60 mt-2">This week</p>
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
