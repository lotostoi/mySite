<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>@yield('title', 'Александр - Психолог во Владивостоке')</title>

    <script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@400;500;600;700&family=Nunito:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: "#f59e0b",
                        "background-light": "#f8fafc",
                        "warm-beige": "#f5f5dc",
                        "muted-gold": "#d4af37",
                        "soft-brown": "#8b4513",
                        "light-peach": "#ffe0b2",
                        "earth-tone-bg": "#f9f6f1",
                    },
                    fontFamily: {
                        heading: ["Comfortaa", "sans-serif"],
                        body: ["Nunito", "sans-serif"],
                    },
                    borderRadius: {
                        DEFAULT: "0.5rem",
                    },
                },
            },
        };
    </script>

    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24
        }
    </style>

    @stack('styles')
</head>
<body class="font-body bg-earth-tone-bg text-soft-brown antialiased">
    <div class="relative min-h-screen">
        @yield('content')
    </div>

    @stack('scripts')
</body>
</html>
