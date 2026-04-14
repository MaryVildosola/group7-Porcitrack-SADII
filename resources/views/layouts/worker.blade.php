<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Farm Worker App</title>

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

    <!-- Web-based Full Layout -->
    <main class="w-full h-full min-h-screen">
        @yield('content')
    </main>

</body>

</html>
