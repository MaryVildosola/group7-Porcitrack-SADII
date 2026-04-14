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
                    class="flex items-center gap-3 px-4 py-3 rounded-xl bg-white/15 text-white font-medium transition hover:bg-white/25">
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
                        <p class="text-base font-medium text-white/70 mb-2">Manage Your</p>
                        <h1 class="text-5xl font-bold text-white">Tasks</h1>
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

                <!-- Filters and Add Task -->
                <div class="flex gap-4 mb-8">
                    <button
                        class="px-6 py-3 bg-green-500/30 text-green-300 border border-green-400/40 rounded-xl font-medium hover:bg-green-500/40 transition">
                        All Tasks
                    </button>
                    <button
                        class="px-6 py-3 bg-white/10 text-white/70 border border-white/20 rounded-xl font-medium hover:bg-white/20 transition">
                        Pending
                    </button>
                    <button
                        class="px-6 py-3 bg-white/10 text-white/70 border border-white/20 rounded-xl font-medium hover:bg-white/20 transition">
                        In Progress
                    </button>
                    <button
                        class="px-6 py-3 bg-white/10 text-white/70 border border-white/20 rounded-xl font-medium hover:bg-white/20 transition">
                        Completed
                    </button>
                    <button
                        class="ml-auto px-6 py-3 bg-gradient-to-r from-green-500 to-green-600 text-white rounded-xl font-medium hover:from-green-600 hover:to-green-700 transition flex items-center gap-2">
                        <i class='bx bx-plus text-xl'></i>
                        Add Task
                    </button>
                </div>

                <!-- Task Grid -->
                <div class="grid grid-cols-2 gap-6 mb-8">

                    <!-- Task Card 1 -->
                    <div class="glass-panel rounded-2xl p-6 hover:bg-white/20 transition cursor-pointer group">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-xl font-semibold text-white mb-2">Feed Pen 1</h3>
                                <p class="text-sm text-white/60">Morning feeding routine</p>
                            </div>
                            <div class="px-3 py-1 bg-green-500/20 text-green-300 rounded-full text-xs font-medium">Pending
                            </div>
                        </div>

                        <div class="space-y-3">
                            <div class="flex items-center gap-2 text-white/70 text-sm">
                                <i class='bx bx-time text-lg'></i>
                                <span>Today 8:00 AM</span>
                            </div>
                            <div class="flex items-center gap-2 text-white/70 text-sm">
                                <i class='bx bx-check text-lg'></i>
                                <span>12 of 15 pigs fed</span>
                            </div>
                            <div class="flex items-center gap-2 text-white/70 text-sm">
                                <i class='bx bx-user text-lg'></i>
                                <span>Assigned to: You</span>
                            </div>
                        </div>

                        <div class="mt-4 flex gap-2">
                            <button
                                class="flex-1 px-4 py-2 bg-green-500/30 text-green-300 border border-green-400/40 rounded-lg font-medium hover:bg-green-500/40 transition text-sm">
                                Start Task
                            </button>
                            <button
                                class="flex-1 px-4 py-2 bg-white/10 text-white border border-white/20 rounded-lg font-medium hover:bg-white/20 transition text-sm">
                                Details
                            </button>
                        </div>
                    </div>

                    <!-- Task Card 2 -->
                    <div class="glass-panel rounded-2xl p-6 hover:bg-white/20 transition cursor-pointer">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-xl font-semibold text-white mb-2">Water Check - Pen 5</h3>
                                <p class="text-sm text-white/60">Check water levels and refill</p>
                            </div>
                            <div class="px-3 py-1 bg-blue-500/20 text-blue-300 rounded-full text-xs font-medium">In Progress
                            </div>
                        </div>

                        <div class="space-y-3">
                            <div class="flex items-center gap-2 text-white/70 text-sm">
                                <i class='bx bx-time text-lg'></i>
                                <span>Today 10:30 AM</span>
                            </div>
                            <div class="flex items-center gap-2 text-white/70 text-sm">
                                <i class='bx bx-hourglass text-lg'></i>
                                <span>Progress: 50%</span>
                            </div>
                            <div class="flex items-center gap-2 text-white/70 text-sm">
                                <i class='bx bx-user text-lg'></i>
                                <span>Assigned to: You</span>
                            </div>
                        </div>

                        <div class="mt-4 flex gap-2">
                            <button
                                class="flex-1 px-4 py-2 bg-blue-500/30 text-blue-300 border border-blue-400/40 rounded-lg font-medium hover:bg-blue-500/40 transition text-sm">
                                Continue
                            </button>
                            <button
                                class="flex-1 px-4 py-2 bg-white/10 text-white border border-white/20 rounded-lg font-medium hover:bg-white/20 transition text-sm">
                                Details
                            </button>
                        </div>
                    </div>

                    <!-- Task Card 3 -->
                    <div class="glass-panel rounded-2xl p-6 hover:bg-white/20 transition cursor-pointer opacity-60">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-xl font-semibold text-white mb-2">Health Check - Pen 3</h3>
                                <p class="text-sm text-white/60">Inspect pig health and vitals</p>
                            </div>
                            <div class="px-3 py-1 bg-emerald-500/20 text-emerald-300 rounded-full text-xs font-medium">
                                Completed</div>
                        </div>

                        <div class="space-y-3">
                            <div class="flex items-center gap-2 text-white/70 text-sm">
                                <i class='bx bx-time text-lg'></i>
                                <span>Today 2:00 PM</span>
                            </div>
                            <div class="flex items-center gap-2 text-white/70 text-sm">
                                <i class='bx bx-check-circle text-lg'></i>
                                <span>All pigs healthy</span>
                            </div>
                            <div class="flex items-center gap-2 text-white/70 text-sm">
                                <i class='bx bx-user text-lg'></i>
                                <span>Assigned to: You</span>
                            </div>
                        </div>

                        <div class="mt-4 flex gap-2">
                            <button
                                class="flex-1 px-4 py-2 bg-white/10 text-white border border-white/20 rounded-lg font-medium hover:bg-white/20 transition text-sm">
                                View Report
                            </button>
                            <button
                                class="flex-1 px-4 py-2 bg-white/10 text-white border border-white/20 rounded-lg font-medium hover:bg-white/20 transition text-sm">
                                Details
                            </button>
                        </div>
                    </div>

                    <!-- Task Card 4 -->
                    <div class="glass-panel rounded-2xl p-6 hover:bg-white/20 transition cursor-pointer">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-xl font-semibold text-white mb-2">Pen 7 Cleaning</h3>
                                <p class="text-sm text-white/60">Deep clean and disinfect pen</p>
                            </div>
                            <div class="px-3 py-1 bg-yellow-500/20 text-yellow-300 rounded-full text-xs font-medium">
                                Pending</div>
                        </div>

                        <div class="space-y-3">
                            <div class="flex items-center gap-2 text-white/70 text-sm">
                                <i class='bx bx-time text-lg'></i>
                                <span>Tomorrow 9:00 AM</span>
                            </div>
                            <div class="flex items-center gap-2 text-white/70 text-sm">
                                <i class='bx bx-calendar text-lg'></i>
                                <span>Scheduled task</span>
                            </div>
                            <div class="flex items-center gap-2 text-white/70 text-sm">
                                <i class='bx bx-user text-lg'></i>
                                <span>Assigned to: You</span>
                            </div>
                        </div>

                        <div class="mt-4 flex gap-2">
                            <button
                                class="flex-1 px-4 py-2 bg-yellow-500/30 text-yellow-300 border border-yellow-400/40 rounded-lg font-medium hover:bg-yellow-500/40 transition text-sm">
                                Schedule
                            </button>
                            <button
                                class="flex-1 px-4 py-2 bg-white/10 text-white border border-white/20 rounded-lg font-medium hover:bg-white/20 transition text-sm">
                                Details
                            </button>
                        </div>
                    </div>

                </div>

                <!-- Task Summary -->
                <div class="grid grid-cols-4 gap-6">
                    <div class="glass-panel rounded-2xl p-6">
                        <p class="text-sm font-medium text-white/70 mb-3">Total Tasks</p>
                        <h3 class="text-4xl font-bold text-white">8</h3>
                        <p class="text-xs text-white/60 mt-2">This month</p>
                    </div>
                    <div class="glass-panel rounded-2xl p-6">
                        <p class="text-sm font-medium text-white/70 mb-3">Completed</p>
                        <h3 class="text-4xl font-bold text-emerald-400">3</h3>
                        <p class="text-xs text-white/60 mt-2">37.5% done</p>
                    </div>
                    <div class="glass-panel rounded-2xl p-6">
                        <p class="text-sm font-medium text-white/70 mb-3">In Progress</p>
                        <h3 class="text-4xl font-bold text-blue-400">1</h3>
                        <p class="text-xs text-white/60 mt-2">12.5% in progress</p>
                    </div>
                    <div class="glass-panel rounded-2xl p-6">
                        <p class="text-sm font-medium text-white/70 mb-3">Pending</p>
                        <h3 class="text-4xl font-bold text-yellow-400">4</h3>
                        <p class="text-xs text-white/60 mt-2">50% remaining</p>
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
