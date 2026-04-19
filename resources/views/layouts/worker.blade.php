<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Farm Worker App</title>

    <!-- PWA Manifest -->
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#2e7d32">

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Boxicons -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        app: {
                            green: '#65a767',
                            dark: '#1b3f21',
                            darker: '#132817',
                            accent: '#ff5c5c', // for alerts
                        }
                    }
                }
            }
        }
    </script>

    <style>
        body {
            /* Create a beautiful vibrant green gradient for the background */
            background: linear-gradient(135deg, #1a472a 0%, #0f2818 50%, #050a08 100%);
            background-attachment: fixed;
            -webkit-tap-highlight-color: transparent;
            margin: 0;
            padding: 0;
        }

        html,
        body {
            width: 100%;
            height: 100%;
            overflow-x: hidden;
        }

        /* Hide scrollbars for an app-like feel */
        ::-webkit-scrollbar {
            display: none;
        }

        .glass-panel {
            background: rgba(255, 255, 255, 0.06);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .glass-button {
            background: rgba(255, 255, 255, 0.10);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            transition: all 0.2s ease;
        }

        .glass-button:active {
            transform: scale(0.97);
            background: rgba(255, 255, 255, 0.35);
        }
    </style>
</head>

<body class="text-white antialiased min-h-screen selection:bg-white/30 overflow-x-hidden">

    <div class="flex h-screen w-screen overflow-hidden">
        
        <!-- Backdrop Overlay (Mobile only) -->
        <div id="sidebarBackdrop" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-[90] hidden md:hidden transition-opacity duration-300 opacity-0"></div>

        <!-- Mobile Header -->
        <div class="md:hidden fixed top-0 left-0 right-0 h-16 bg-white/5 backdrop-blur-lg border-b border-white/10 flex items-center justify-between px-4 z-[80]">
            <!-- Left: Logo -->
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-md bg-gradient-to-br from-[#428246] to-[#2d5a2f] flex items-center justify-center shadow-lg">
                    <i class='bx bx-pig text-white text-sm'></i>
                </div>
                <h2 class="font-bold text-white text-sm tracking-tight hidden sm:block">Porcitrack</h2>
            </div>

            <!-- Right: Actions & Menu -->
            <div class="flex items-center gap-3">
                <div id="mobileSyncStatus" class="flex items-center gap-1.5 bg-white/10 px-2.5 py-1.5 rounded-lg border border-white/10 cursor-pointer" onclick="if(typeof syncData === 'function'){ syncData(); }">
                    <div class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></div>
                    <span class="text-white text-[9px] font-bold uppercase tracking-widest leading-none">Synced</span>
                </div>
                <button onclick="if(typeof openNotificationsPanel === 'function'){ openNotificationsPanel(); } else { window.location.href='/worker/dashboard'; }" 
                        class="relative text-white/80 hover:text-white p-1">
                    <i class='bx bx-bell text-xl'></i>
                    <span id="mobileAlertBadge" class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full border border-[rgba(0,0,0,0.5)] animate-pulse"></span>
                </button>
                <button onclick="if(typeof showSearch === 'function'){ showSearch(); }" class="text-white/80 hover:text-white p-1">
                    <i class='bx bx-search text-xl'></i>
                </button>
                <button id="mobileMenuToggle" class="text-white text-2xl ml-1 active:scale-90 transition-transform">
                    <i class='bx bx-menu'></i>
                </button>
            </div>
        </div>

        <!-- Sidebar Navigation -->
        <aside id="workerSidebar" class="fixed inset-y-0 left-0 z-[100] w-72 bg-[#0f2818]/95 backdrop-blur-2xl border-r border-white/10 flex flex-col shrink-0 transform -translate-x-full transition-all duration-300 ease-in-out md:relative md:translate-x-0 md:bg-white/5 shadow-2xl md:shadow-none">
            <div class="p-6 border-b border-white/10">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-lg bg-gradient-to-br from-[#428246] to-[#2d5a2f] flex items-center justify-center shadow-inner">
                        <i class='bx bx-pig text-xl text-white font-bold'></i>
                    </div>
                    <div>
                        <h2 class="font-bold text-white">Porcitrack</h2>
                        <p class="text-xs text-white/60">Worker Portal</p>
                    </div>
                </div>
            </div>

            <nav class="flex-1 px-4 py-8 space-y-3">
                <a href="{{ route('worker.dashboard') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('worker.dashboard') ? 'bg-white/15 text-white' : 'text-white/70 hover:bg-white/10 hover:text-white' }} font-medium transition">
                    <i class='bx bx-home text-lg'></i>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('worker.tasks') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('worker.tasks') ? 'bg-white/15 text-white' : 'text-white/70 hover:bg-white/10 hover:text-white' }} font-medium transition">
                    <i class='bx bx-task text-lg'></i>
                    <span>Tasks</span>
                </a>

                <a href="{{ route('worker.reports') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('worker.reports') ? 'bg-white/15 text-white' : 'text-white/70 hover:bg-white/10 hover:text-white' }} font-medium transition">
                    <i class='bx bx-book-content text-lg'></i>
                    <span>Weekly Report</span>
                </a>
                <a href="{{ route('worker.feed-formulas') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('worker.feed-formulas') ? 'bg-white/15 text-white' : 'text-white/70 hover:bg-white/10 hover:text-white' }} font-medium transition">
                    <i class='bx bx-bowl-hot text-lg'></i>
                    <span>Feed Formulas</span>
                </a>
                <a href="{{ route('worker.settings') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('worker.settings') ? 'bg-white/15 text-white' : 'text-white/70 hover:bg-white/10 hover:text-white' }} font-medium transition">
                    <i class='bx bx-cog text-lg'></i>
                    <span>Settings</span>
                </a>
                
                <div class="px-4 mt-6 mb-2">
                    <p class="text-[10px] uppercase font-bold text-white/30 tracking-widest">Quick Actions</p>
                </div>
                <a href="#" onclick="triggerManualEntry(event)"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl bg-gradient-to-r from-green-500/20 to-emerald-500/10 text-white border border-green-500/30 hover:bg-green-500/30 font-medium transition shadow-sm">
                    <i class='bx bx-edit text-lg text-green-400'></i>
                    <span>Manual ID Entry</span>
                </a>
            </nav>

            <div class="p-4 border-t border-white/10">
                <div class="flex items-center gap-3 px-4 py-3">
                    <div class="w-10 h-10 rounded-full overflow-hidden border border-white/20 shadow-inner bg-white/10">
                        <img src="{{ auth()->user()->photo ? asset('storage/' . auth()->user()->photo) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=65a767&color=fff' }}" 
                             alt="User" class="w-full h-full object-cover">
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-white truncate">{{ auth()->user()->name ?? 'User' }}</p>
                        <p class="text-[10px] text-white/40 uppercase tracking-widest">Worker</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="mt-2">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center justify-center gap-2 px-4 py-2 text-white/60 hover:text-white hover:bg-white/5 rounded-lg transition text-xs font-medium border border-transparent hover:border-white/10">
                        <i class='bx bx-log-out text-base'></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
            
            <!-- Mobile Close Button -->
            <button id="mobileMenuClose" class="md:hidden absolute top-4 right-4 text-white/60 hover:text-white text-2xl p-2 transition">
                <i class='bx bx-x'></i>
            </button>
        </aside>

        <!-- Main Content Area -->
        <main class="flex-1 overflow-y-auto overflow-x-hidden pt-16 md:pt-0 relative">
            
            <!-- Global Floating Icons (Right Side) -->
            <div class="hidden md:flex absolute top-4 right-4 md:top-8 md:right-8 z-50 items-center gap-2 md:gap-3 pointer-events-none">
                <!-- Sync Status -->
                <div id="globalSyncStatus" class="pointer-events-auto flex items-center gap-2 md:gap-3 bg-white/10 backdrop-blur-md px-3 py-1.5 md:px-4 md:py-2 rounded-2xl border border-white/10 cursor-pointer hover:bg-white/20 transition shadow-lg" onclick="if(typeof syncData === 'function'){ syncData(); }">
                    <div class="w-1.5 h-1.5 md:w-2 md:h-2 rounded-full bg-green-500 shadow-[0_0_10px_rgba(34,197,94,0.6)] animate-pulse"></div>
                    <span class="text-white text-[9px] md:text-[10px] font-bold uppercase tracking-widest leading-none">Synced</span>
                </div>

                <!-- Notifications Bell -->
                <button onclick="if(typeof openNotificationsPanel === 'function'){ openNotificationsPanel(); } else { window.location.href='/worker/dashboard'; }" 
                        class="pointer-events-auto relative w-10 h-10 md:w-12 md:h-12 rounded-full flex items-center justify-center bg-white/5 backdrop-blur-md border border-white/10 hover:bg-white/20 transition shadow-lg text-white">
                    <i class='bx bx-bell text-lg md:text-xl'></i>
                    <span id="globalAlertBadge" class="absolute top-2 right-2 md:top-2.5 md:right-2.5 w-2.5 h-2.5 md:w-3 md:h-3 bg-red-500 rounded-full border border-[rgba(0,0,0,0.5)] animate-pulse"></span>
                </button>

                <!-- Search -->
                <button onclick="if(typeof showSearch === 'function'){ showSearch(); }" 
                        class="pointer-events-auto w-10 h-10 md:w-12 md:h-12 rounded-full flex items-center justify-center bg-white/5 backdrop-blur-md border border-white/10 hover:bg-white/20 transition shadow-lg text-white">
                    <i class='bx bx-search text-lg md:text-xl'></i>
                </button>
            </div>

            @yield('content')
        </main>
    </div>

    <!-- Notifications / Alerts Slide Panel (Global) -->
    <div id="notificationsBackdrop" class="fixed inset-0 z-[190] hidden bg-black/50 backdrop-blur-sm" onclick="closeNotificationsPanel()"></div>
    <div id="notificationsPanel" class="fixed top-0 right-0 bottom-0 z-[200] w-full max-w-sm bg-[#060f08] border-l border-white/10 shadow-2xl transform translate-x-full transition-transform duration-300 flex flex-col">
        <div class="p-6 border-b border-white/10 flex justify-between items-center shrink-0">
            <div>
                <h2 class="text-2xl font-black text-white">Alerts</h2>
                <p class="text-white/40 text-xs font-semibold mt-0.5">All farm notifications</p>
            </div>
            <button onclick="closeNotificationsPanel()" class="w-12 h-12 rounded-2xl bg-white/5 text-white flex items-center justify-center hover:bg-white/10 transition">
                <i class='bx bx-x text-2xl'></i>
            </button>
        </div>

        <!-- Filter Tabs -->
        <div class="flex gap-2 px-6 py-4 border-b border-white/5 shrink-0">
            <button onclick="filterPanel('all', this)" class="panel-filter-btn flex-1 py-2 rounded-xl bg-green-500/20 text-green-300 border border-green-500/30 text-xs font-black uppercase">All</button>
            <button onclick="filterPanel('critical', this)" class="panel-filter-btn flex-1 py-2 rounded-xl bg-white/5 text-white/50 border border-white/10 text-xs font-black uppercase">Critical</button>
            <button onclick="filterPanel('health', this)" class="panel-filter-btn flex-1 py-2 rounded-xl bg-white/5 text-white/50 border border-white/10 text-xs font-black uppercase">Health</button>
            <button onclick="filterPanel('general', this)" class="panel-filter-btn flex-1 py-2 rounded-xl bg-white/5 text-white/50 border border-white/10 text-xs font-black uppercase">General</button>
        </div>

        <!-- Alert Items -->
        <div class="flex-1 overflow-y-auto p-4 space-y-3" id="alertPanelList">
            <!-- Critical -->
            <div class="alert-item" data-type="critical">
                <div class="p-4 rounded-2xl bg-red-500/10 border border-red-500/30">
                    <div class="flex gap-3 items-start">
                        <div class="w-10 h-10 rounded-xl bg-red-500/25 flex items-center justify-center shrink-0">
                            <i class='bx bx-heart-broken text-red-400 text-lg'></i>
                        </div>
                        <div class="flex-1">
                            <div class="flex justify-between items-start">
                                <p class="text-red-300 font-black text-sm">Pig #42 — Health Crisis</p>
                                <span class="text-white/30 text-[10px]">2 min ago</span>
                            </div>
                            <p class="text-white/60 text-xs mt-1 leading-snug">Rapid breathing and lethargy in Pen 3. Vet required.</p>
                            <div class="flex gap-2 mt-3">
                                <span class="px-2 py-0.5 bg-red-500/20 text-red-300 rounded-md text-[9px] font-black border border-red-500/30 uppercase">Critical</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Health -->
            <div class="alert-item" data-type="health">
                <div class="p-4 rounded-2xl bg-yellow-500/10 border border-yellow-500/20">
                    <div class="flex gap-3 items-start">
                        <div class="w-10 h-10 rounded-xl bg-yellow-500/20 flex items-center justify-center shrink-0">
                            <i class='bx bx-error-alt text-yellow-400 text-lg'></i>
                        </div>
                        <div class="flex-1">
                            <div class="flex justify-between items-start">
                                <p class="text-yellow-300 font-black text-sm">Pig #17 — Check Needed</p>
                                <span class="text-white/30 text-[10px]">1 hr ago</span>
                            </div>
                            <p class="text-white/60 text-xs mt-1 leading-snug">Due for routine health monitoring. Last check was 4 days ago.</p>
                            <div class="flex gap-2 mt-3">
                                <span class="px-2 py-0.5 bg-yellow-500/15 text-yellow-300 rounded-md text-[9px] font-black border border-yellow-500/20 uppercase">Health</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Responsive Menu Toggle Logic
        const mobileMenuToggle = document.getElementById('mobileMenuToggle');
        const mobileMenuClose = document.getElementById('mobileMenuClose');
        const workerSidebar = document.getElementById('workerSidebar');
        const sidebarBackdrop = document.getElementById('sidebarBackdrop');

        function openSidebar() {
            workerSidebar.classList.remove('-translate-x-full');
            sidebarBackdrop.classList.remove('hidden');
            setTimeout(() => sidebarBackdrop.classList.add('opacity-100'), 10);
            document.body.style.overflow = 'hidden';
        }

        function closeSidebar() {
            workerSidebar.classList.add('-translate-x-full');
            sidebarBackdrop.classList.remove('opacity-100');
            setTimeout(() => sidebarBackdrop.classList.add('hidden'), 300);
            document.body.style.overflow = '';
        }

        if (mobileMenuToggle) mobileMenuToggle.addEventListener('click', openSidebar);
        if (mobileMenuClose) mobileMenuClose.addEventListener('click', closeSidebar);
        if (sidebarBackdrop) sidebarBackdrop.addEventListener('click', closeSidebar);

        function triggerManualEntry(e) {
            if(e) e.preventDefault();
            closeSidebar();

            Swal.fire({
                title: 'Manual ID Entry',
                input: 'text',
                inputPlaceholder: 'e.g. PEN-1 or PIG-123',
                html: '<p class="text-xs text-white/50 mb-4 px-2">Type the Pen ID or animal Tag ID directly instead of scanning the QR.</p>',
                background: '#0a180e',
                color: '#fff',
                confirmButtonText: 'Record Log',
                confirmButtonColor: '#22c55e',
                showCancelButton: true,
                cancelButtonColor: '#4b5563',
                customClass: {
                    input: 'bg-white/5 border border-white/10 text-white rounded-xl text-center uppercase tracking-widest text-lg font-bold'
                },
                inputValidator: (value) => {
                    if (!value) return 'You need to enter an ID!'
                }
            }).then((result) => {
                if (result.isConfirmed && result.value) {
                    const tagId = result.value.toUpperCase().trim();
                    // If we are on dashboard where qr scanner logic sits
                    if (typeof window.onScanSuccess === 'function') {
                        window.onScanSuccess(tagId, null);
                    } else {
                        // Redirect to dashboard with query param so it can be handled
                        window.location.href = "{{ route('worker.dashboard') }}?manual_scan=" + encodeURIComponent(tagId);
                    }
                }
            });
        }

        // Global Notifications Panel Logic
        function openNotificationsPanel() {
            document.getElementById('notificationsPanel').classList.remove('translate-x-full');
            document.getElementById('notificationsBackdrop').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            if(window.innerWidth < 768) {
                closeSidebar(); // close mobile sidebar if open
            }
        }

        function closeNotificationsPanel() {
            document.getElementById('notificationsPanel').classList.add('translate-x-full');
            document.getElementById('notificationsBackdrop').classList.add('hidden');
            document.body.style.overflow = '';
        }

        function filterPanel(type, btn) {
            document.querySelectorAll('.panel-filter-btn').forEach(b => {
                b.classList.remove('bg-green-500/20','text-green-300','border-green-500/30');
                b.classList.add('bg-white/5','text-white/50','border-white/10');
            });
            btn.classList.add('bg-green-500/20','text-green-300','border-green-500/30');
            btn.classList.remove('bg-white/5','text-white/50','border-white/10');

            document.querySelectorAll('.alert-item').forEach(item => {
                if (type === 'all' || item.dataset.type === type) {
                    item.style.display = '';
                } else {
                    item.style.display = 'none';
                }
            });
        }
    </script>

    <!-- PWA Registration -->
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js')
                    .then(reg => console.log('Service Worker registered', reg))
                    .catch(err => console.log('Service Worker registration failed', err));
            });
        }
    </script>
</body>

</html>
