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
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .glass-button {
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.3);
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
        <div class="md:hidden fixed top-0 left-0 right-0 h-16 bg-white/5 backdrop-blur-lg border-b border-white/10 flex items-center justify-between px-6 z-[80]">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-md bg-gradient-to-br from-[#428246] to-[#2d5a2f] flex items-center justify-center shadow-lg">
                    <i class='bx bx-pig text-white text-sm'></i>
                </div>
                <h2 class="font-bold text-white text-sm tracking-tight">Porcitrack</h2>
            </div>
            <button id="mobileMenuToggle" class="text-white text-2xl active:scale-90 transition-transform">
                <i class='bx bx-menu'></i>
            </button>
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
                <a href="{{ route('worker.alerts') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('worker.alerts') ? 'bg-white/15 text-white' : 'text-white/70 hover:bg-white/10 hover:text-white' }} font-medium transition">
                    <i class='bx bx-bell text-lg'></i>
                    <span>Alerts</span>
                </a>
                <a href="{{ route('worker.reports') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('worker.reports') ? 'bg-white/15 text-white' : 'text-white/70 hover:bg-white/10 hover:text-white' }} font-medium transition">
                    <i class='bx bx-book-content text-lg'></i>
                    <span>Weekly Report</span>
                </a>
                <a href="{{ route('worker.settings') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('worker.settings') ? 'bg-white/15 text-white' : 'text-white/70 hover:bg-white/10 hover:text-white' }} font-medium transition">
                    <i class='bx bx-cog text-lg'></i>
                    <span>Settings</span>
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
        <main class="flex-1 overflow-y-auto overflow-x-hidden pt-16 md:pt-0">
            @yield('content')
        </main>
    </div>

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
