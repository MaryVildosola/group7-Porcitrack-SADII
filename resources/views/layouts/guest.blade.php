<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <title>{{ config('app.name', 'PorciTrack') }}</title>

    <!-- PWA Manifest -->
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#2e7d32">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: radial-gradient(ellipse at 30% 40%, #4caf50 0%, #2e7d32 35%, #1a3a1a 65%, #0d1f0d 100%);
            padding: 20px;
        }

        .auth-container {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 30px;
            width: 100%;
            max-width: 860px;
        }

        /* Logo Card */
        .logo-card {
            width: 310px;
            height: 310px;
            background: linear-gradient(145deg, #1a2e1a 0%, #0d1a0d 100%);
            border-radius: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 20px 60px rgba(0,0,0,0.4);
        }

        .logo-card img {
            width: 240px;
            height: 240px;
            object-fit: contain;
        }

        /* Glass Form Card */
        .form-card {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.15);
            border-radius: 20px;
            padding: 40px 36px;
            width: 100%;
            max-width: 320px;
            box-shadow: 0 8px 40px rgba(0,0,0,0.2);
        }

        .form-card h2 {
            font-size: 1.7rem;
            font-weight: 700;
            color: #2e7d32;
            text-align: center;
            margin-bottom: 28px;
        }

        /* Input groups */
        .input-group {
            position: relative;
            margin-bottom: 18px;
        }

        .input-group input {
            width: 100%;
            background: transparent;
            border: none;
            border-bottom: 1.5px solid rgba(255,255,255,0.5);
            color: rgba(255,255,255,0.9);
            font-size: 0.9rem;
            padding: 8px 36px 8px 4px;
            outline: none;
            transition: border-color 0.2s;
            font-family: 'Inter', sans-serif;
        }

        .input-group input::placeholder { color: rgba(255,255,255,0.5); }
        .input-group input:focus { border-bottom-color: #66bb6a; }

        .input-group .input-icon {
            position: absolute;
            right: 6px;
            top: 50%;
            transform: translateY(-50%);
            opacity: 0.55;
            pointer-events: none;
        }

        .input-group .input-icon svg {
            width: 16px;
            height: 16px;
            fill: rgba(255,255,255,0.7);
        }

        /* Error messages */
        .error-msg {
            color: #ff8a80;
            font-size: 0.75rem;
            margin-top: 3px;
        }

        /* Login Button */
        .btn-login {
            width: 100%;
            padding: 11px;
            margin-top: 8px;
            background: linear-gradient(135deg, #2e7d32, #1b5e20);
            color: #fff;
            font-size: 1rem;
            font-weight: 600;
            border: none;
            border-radius: 30px;
            cursor: pointer;
            transition: all 0.2s;
            font-family: 'Inter', sans-serif;
            box-shadow: 0 4px 15px rgba(46,125,50,0.5);
        }

        .btn-login:hover {
            background: linear-gradient(135deg, #388e3c, #2e7d32);
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(46,125,50,0.6);
        }

        .form-links {
            display: flex;
            justify-content: space-between;
            margin-top: 18px;
            gap: 10px;
        }

        .form-links a {
            color: rgba(255,255,255,0.65);
            font-size: 0.78rem;
            text-decoration: none;
            transition: color 0.2s;
        }

        .form-links a:hover { color: #fff; }

        .form-links.center { justify-content: center; }

        /* Session status */
        .session-status {
            padding: 10px 14px;
            background: rgba(102,187,106,0.15);
            border: 1px solid rgba(102,187,106,0.3);
            border-radius: 8px;
            color: #a5d6a7;
            font-size: 0.82rem;
            margin-bottom: 16px;
        }

        @media (max-width: 680px) {
            .auth-container { flex-direction: column; }
            .logo-card { width: 200px; height: 200px; }
            .logo-card img { width: 160px; height: 160px; }
        }
    </style>
</head>
<body>
    {{ $slot }}

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
