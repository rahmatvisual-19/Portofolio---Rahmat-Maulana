<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sweety | Digital Portfolio</title>
    
    <!-- Vite Assets (Tailwind & JS) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap" rel="stylesheet">

    <!-- CSS Global Dasar -->
    <style>
        body {
            background-color: #0b0b0b;
            color: #ffffff;
            margin: 0;
            padding: 0;
            -webkit-font-smoothing: antialiased;
        }
        
        /* Smooth Scrolling */
        html {
            scroll-behavior: smooth;
        }

        /* Menghilangkan scrollbar untuk tampilan yang lebih bersih */
        ::-webkit-scrollbar {
            width: 0px;
            background: transparent;
        }
    </style>
</head>
<body class="font-sans antialiased">



    <!-- Navigasi Global disembunyikan karena portofolio sudah memiliki header sendiri -->
    <nav class="hidden fixed top-0 w-full z-[100] flex justify-between items-center p-8 md:px-12 mix-blend-difference pointer-events-none">
        <div class="font-black text-2xl uppercase tracking-tighter pointer-events-auto hidden md:block">
            <a href="/">Sweety.</a>
        </div>
    </nav>

    <!-- Tempat konten halaman (portofolio.blade.php) akan muncul -->
    <main>
        @yield('content')
    </main>

</body>
</html>