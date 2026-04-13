<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Farm Worker App</title>
    
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
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
            background: linear-gradient(180deg, #428246 0%, #152c17 100%);
            background-attachment: fixed;
            -webkit-tap-highlight-color: transparent;
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
<body class="text-white antialiased min-h-screen flex justify-center selection:bg-white/30">

    <!-- Mobile Device Container for Desktop viewing -->
    <div class="relative w-full h-full min-h-screen max-w-[420px] shadow-2xl flex flex-col bg-transparent">
        
        <!-- Main Scrollable Content Area -->
        <main class="flex-grow pb-28">
            @yield('content')
        </main>

        <!-- Bottom Navigation Bar (Fixed in Mobile Layout) -->
        <nav class="fixed bottom-6 left-1/2 -translate-x-1/2 w-[calc(100%-2rem)] max-w-[calc(420px-2rem)] z-50">
            <div class="glass-panel flex justify-between items-center px-8 py-3 rounded-[32px] shadow-2xl">
                <!-- Home -->
                <a href="{{ route('worker.dashboard') }}" class="flex flex-col items-center justify-center p-2 text-white">
                    <div class="flex items-center justify-center w-12 h-12 bg-white/20 rounded-full mb-1">
                        <i class='bx bxs-home text-2xl'></i>
                    </div>
                    <span class="text-[0.65rem] font-medium tracking-wide">Home</span>
                </a>
                
                <!-- Scanner -->
                <a href="#" style="opacity:0.6" class="flex flex-col items-center justify-center p-2 text-white transition-opacity hover:opacity-100">
                    <div class="flex items-center justify-center w-12 h-12 rounded-full mb-1">
                        <i class='bx bx-scan text-2xl'></i>
                    </div>
                    <span class="text-[0.65rem] font-medium tracking-wide">Scanner</span>
                </a>
                
                <!-- Profile -->
                <a href="#" style="opacity:0.6" class="flex flex-col items-center justify-center p-2 text-white transition-opacity hover:opacity-100">
                    <div class="flex items-center justify-center w-12 h-12 rounded-full mb-1">
                        <i class='bx bx-user text-2xl'></i>
                    </div>
                    <span class="text-[0.65rem] font-medium tracking-wide">Profile</span>
                </a>
            </div>
        </nav>
        
    </div>

</body>
</html>
