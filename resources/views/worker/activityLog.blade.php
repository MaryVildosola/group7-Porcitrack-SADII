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
                    class="flex items-center gap-3 px-4 py-3 rounded-xl text-white/70 font-medium transition hover:bg-white/10 hover:text-white">
                    <i class='bx bx-bell text-lg'></i>
                    <span>Alerts</span>
                </a>
                <a href="{{ route('worker.activity-log') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl bg-white/15 text-white font-medium transition hover:bg-white/25">
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
                        <p class="text-base font-medium text-white/70 mb-2">Your Work History</p>
                        <h1 class="text-5xl font-bold text-white">Activity Log</h1>
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

                <!-- Filter Section -->
                <div class="flex gap-4 mb-8 flex-wrap">
                    <button
                        class="px-6 py-3 bg-blue-500/30 text-blue-300 border border-blue-400/40 rounded-xl font-medium hover:bg-blue-500/40 transition">
                        All Activities
                    </button>
                    <button
                        class="px-6 py-3 bg-white/10 text-white/70 border border-white/20 rounded-xl font-medium hover:bg-white/20 transition">
                        Feeding
                    </button>
                    <button
                        class="px-6 py-3 bg-white/10 text-white/70 border border-white/20 rounded-xl font-medium hover:bg-white/20 transition">
                        Health Check
                    </button>
                    <button
                        class="px-6 py-3 bg-white/10 text-white/70 border border-white/20 rounded-xl font-medium hover:bg-white/20 transition">
                        Maintenance
                    </button>
                    <button
                        class="px-6 py-3 bg-white/10 text-white/70 border border-white/20 rounded-xl font-medium hover:bg-white/20 transition">
                        System
                    </button>
                    <button
                        class="px-6 py-3 bg-white/10 text-white/70 border border-white/20 rounded-xl font-medium hover:bg-white/20 transition">
                        Login/Logout
                    </button>
                </div>

                <!-- Activity Timeline -->
                <div class="space-y-4">

                    <!-- Activity Entry 1 -->
                    <div class="glass-panel rounded-2xl p-6 hover:bg-white/20 transition">
                        <div class="flex gap-4">
                            <div class="flex flex-col items-center">
                                <div
                                    class="w-12 h-12 rounded-full bg-green-500/30 flex items-center justify-center border border-green-400/40 shrink-0">
                                    <i class='bx bxs-bowl-rice text-green-400 text-xl'></i>
                                </div>
                                <div class="w-1 h-12 bg-gradient-to-b from-green-400/50 to-transparent mt-2"></div>
                            </div>
                            <div class="flex-1 pt-1">
                                <div class="flex justify-between items-start mb-2">
                                    <div>
                                        <h3 class="text-lg font-semibold text-white">Pen 5 Feeding Completed</h3>
                                        <p class="text-sm text-white/60">Feeding Activity</p>
                                    </div>
                                    <span class="text-sm text-white/60">Today 2:30 PM</span>
                                </div>
                                <p class="text-white/80 text-sm mb-3">Successfully fed 15 pigs in Pen 5. 5 kg feed consumed.
                                    All pigs appear healthy and active.</p>
                                <div class="flex gap-2">
                                    <span
                                        class="px-3 py-1 bg-green-500/20 text-green-300 rounded-full text-xs font-medium">Completed</span>
                                    <span
                                        class="px-3 py-1 bg-blue-500/20 text-blue-300 rounded-full text-xs font-medium">Feed</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Activity Entry 2 -->
                    <div class="glass-panel rounded-2xl p-6 hover:bg-white/20 transition">
                        <div class="flex gap-4">
                            <div class="flex flex-col items-center">
                                <div
                                    class="w-12 h-12 rounded-full bg-amber-500/30 flex items-center justify-center border border-amber-400/40 shrink-0">
                                    <i class='bx bx-time text-amber-400 text-xl'></i>
                                </div>
                                <div class="w-1 h-12 bg-gradient-to-b from-amber-400/50 to-transparent mt-2"></div>
                            </div>
                            <div class="flex-1 pt-1">
                                <div class="flex justify-between items-start mb-2">
                                    <div>
                                        <h3 class="text-lg font-semibold text-white">Health Check - Pen 3 Performed</h3>
                                        <p class="text-sm text-white/60">Health Monitoring</p>
                                    </div>
                                    <span class="text-sm text-white/60">Today 1:15 PM</span>
                                </div>
                                <p class="text-white/80 text-sm mb-3">Routine health inspection of Pen 3. All 12 pigs
                                    checked. Vital signs normal. One pig showing slight lethargy - monitoring advised.</p>
                                <div class="flex gap-2">
                                    <span
                                        class="px-3 py-1 bg-amber-500/20 text-amber-300 rounded-full text-xs font-medium">In
                                        Review</span>
                                    <span
                                        class="px-3 py-1 bg-purple-500/20 text-purple-300 rounded-full text-xs font-medium">Health</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Activity Entry 3 -->
                    <div class="glass-panel rounded-2xl p-6 hover:bg-white/20 transition">
                        <div class="flex gap-4">
                            <div class="flex flex-col items-center">
                                <div
                                    class="w-12 h-12 rounded-full bg-blue-500/30 flex items-center justify-center border border-blue-400/40 shrink-0">
                                    <i class='bx bx-water text-blue-400 text-xl'></i>
                                </div>
                                <div class="w-1 h-12 bg-gradient-to-b from-blue-400/50 to-transparent mt-2"></div>
                            </div>
                            <div class="flex-1 pt-1">
                                <div class="flex justify-between items-start mb-2">
                                    <div>
                                        <h3 class="text-lg font-semibold text-white">Water System Maintenance - Pen 7</h3>
                                        <p class="text-sm text-white/60">System Maintenance</p>
                                    </div>
                                    <span class="text-sm text-white/60">Today 11:45 AM</span>
                                </div>
                                <p class="text-white/80 text-sm mb-3">Repaired water dispenser in Pen 7. System tested and
                                    working properly. Water quality checked - all parameters normal.</p>
                                <div class="flex gap-2">
                                    <span
                                        class="px-3 py-1 bg-green-500/20 text-green-300 rounded-full text-xs font-medium">Fixed</span>
                                    <span
                                        class="px-3 py-1 bg-cyan-500/20 text-cyan-300 rounded-full text-xs font-medium">Maintenance</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Activity Entry 4 -->
                    <div class="glass-panel rounded-2xl p-6 hover:bg-white/20 transition">
                        <div class="flex gap-4">
                            <div class="flex flex-col items-center">
                                <div
                                    class="w-12 h-12 rounded-full bg-pink-500/30 flex items-center justify-center border border-pink-400/40 shrink-0">
                                    <i class='bx bx-temperature text-pink-400 text-xl'></i>
                                </div>
                                <div class="w-1 h-12 bg-gradient-to-b from-pink-400/50 to-transparent mt-2"></div>
                            </div>
                            <div class="flex-1 pt-1">
                                <div class="flex justify-between items-start mb-2">
                                    <div>
                                        <h3 class="text-lg font-semibold text-white">Temperature Check - Pen 2</h3>
                                        <p class="text-sm text-white/60">Climate Monitoring</p>
                                    </div>
                                    <span class="text-sm text-white/60">Yesterday 4:30 PM</span>
                                </div>
                                <p class="text-white/80 text-sm mb-3">Checked pen temperature and cooling system.
                                    Temperature at 25.2°C - within optimal range. Cooling fans operating normally.</p>
                                <div class="flex gap-2">
                                    <span
                                        class="px-3 py-1 bg-green-500/20 text-green-300 rounded-full text-xs font-medium">Normal</span>
                                    <span
                                        class="px-3 py-1 bg-pink-500/20 text-pink-300 rounded-full text-xs font-medium">Climate</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Activity Entry 5 -->
                    <div class="glass-panel rounded-2xl p-6 hover:bg-white/20 transition">
                        <div class="flex gap-4">
                            <div class="flex flex-col items-center">
                                <div
                                    class="w-12 h-12 rounded-full bg-green-500/30 flex items-center justify-center border border-green-400/40 shrink-0">
                                    <i class='bx bxs-bowl-rice text-green-400 text-xl'></i>
                                </div>
                                <div class="w-1 h-12 bg-gradient-to-b from-green-400/50 to-transparent mt-2"></div>
                            </div>
                            <div class="flex-1 pt-1">
                                <div class="flex justify-between items-start mb-2">
                                    <div>
                                        <h3 class="text-lg font-semibold text-white">Pen 1 Feeding Completed</h3>
                                        <p class="text-sm text-white/60">Feeding Activity</p>
                                    </div>
                                    <span class="text-sm text-white/60">Yesterday 3:00 PM</span>
                                </div>
                                <p class="text-white/80 text-sm mb-3">Morning feeding session completed. 12 pigs fed with 4
                                    kg of standard feed. No issues reported.</p>
                                <div class="flex gap-2">
                                    <span
                                        class="px-3 py-1 bg-green-500/20 text-green-300 rounded-full text-xs font-medium">Completed</span>
                                    <span
                                        class="px-3 py-1 bg-blue-500/20 text-blue-300 rounded-full text-xs font-medium">Feed</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Activity Entry 6 -->
                    <div class="glass-panel rounded-2xl p-6 hover:bg-white/20 transition">
                        <div class="flex gap-4">
                            <div class="flex flex-col items-center">
                                <div
                                    class="w-12 h-12 rounded-full bg-indigo-500/30 flex items-center justify-center border border-indigo-400/40 shrink-0">
                                    <i class='bx bx-log-in text-indigo-400 text-xl'></i>
                                </div>
                            </div>
                            <div class="flex-1 pt-1">
                                <div class="flex justify-between items-start mb-2">
                                    <div>
                                        <h3 class="text-lg font-semibold text-white">Logged In</h3>
                                        <p class="text-sm text-white/60">System Access</p>
                                    </div>
                                    <span class="text-sm text-white/60">Yesterday 8:00 AM</span>
                                </div>
                                <p class="text-white/80 text-sm mb-3">User logged in successfully from Dashboard. Browser:
                                    Chrome on Windows.</p>
                                <div class="flex gap-2">
                                    <span
                                        class="px-3 py-1 bg-indigo-500/20 text-indigo-300 rounded-full text-xs font-medium">System</span>
                                    <span
                                        class="px-3 py-1 bg-gray-500/20 text-gray-300 rounded-full text-xs font-medium">Login</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Activity Statistics -->
                <div class="grid grid-cols-4 gap-6 mt-10">
                    <div class="glass-panel rounded-2xl p-6">
                        <p class="text-sm font-medium text-white/70 mb-3">Total Activities</p>
                        <h3 class="text-4xl font-bold text-white">247</h3>
                        <p class="text-xs text-white/60 mt-2">This month</p>
                    </div>
                    <div class="glass-panel rounded-2xl p-6">
                        <p class="text-sm font-medium text-white/70 mb-3">Feeding Tasks</p>
                        <h3 class="text-4xl font-bold text-green-400">85</h3>
                        <p class="text-xs text-white/60 mt-2">Completed</p>
                    </div>
                    <div class="glass-panel rounded-2xl p-6">
                        <p class="text-sm font-medium text-white/70 mb-3">Health Checks</p>
                        <h3 class="text-4xl font-bold text-purple-400">42</h3>
                        <p class="text-xs text-white/60 mt-2">Performed</p>
                    </div>
                    <div class="glass-panel rounded-2xl p-6">
                        <p class="text-sm font-medium text-white/70 mb-3">Maintenance</p>
                        <h3 class="text-4xl font-bold text-cyan-400">28</h3>
                        <p class="text-xs text-white/60 mt-2">Tasks completed</p>
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
