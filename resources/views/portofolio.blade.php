@extends('layouts.app')

@section('content')
<!-- 
    PORTFOLIO ULTIMATE EDITION - RESPONSIVE UPDATE
    - Navbar Kiri & Menu @ Dropdown
    - Layout Showcase Petak untuk Mobile
-->

<style>
    :root {
        --primary: #ffffff;
        --bg: #030303;
        --accent-blue: rgba(59, 130, 246, 1);
        --accent-purple: rgba(139, 92, 246, 1);
        --accent-blue-glow: rgba(59, 130, 246, 0.5);
        --accent-purple-glow: rgba(139, 92, 246, 0.5);
    }

    /* Sembunyikan kursor asli */
    html, body, a, button, .project-card {
        cursor: none !important;
    }

    /* --- Animasi Kustom --- */
    @keyframes spin-slower {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    .animate-spin-slower { animation: spin-slower 12s linear infinite; }

    @keyframes pulse-slow {
        0%, 100% { opacity: 0.4; transform: scale(1); }
        50% { opacity: 0.7; transform: scale(1.1); }
    }
    .animate-pulse-slow { animation: pulse-slow 8s ease-in-out infinite; }

    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-15px) scale(1.05); }
    }
    .animate-float { animation: float 6s ease-in-out infinite; }

    /* --- Marquee Animations --- */
    @keyframes scrollLeft {
        from { transform: translateX(0); }
        to { transform: translateX(-50%); }
    }
    @keyframes scrollRight {
        from { transform: translateX(-50%); }
        to { transform: translateX(0); }
    }

    .marquee-container {
        display: flex;
        overflow: hidden;
        user-select: none;
        gap: 40px;
        mask-image: linear-gradient(to right, transparent, black 15%, black 85%, transparent);
    }

    .marquee-content {
        display: flex;
        flex-shrink: 0;
        gap: 40px;
        min-width: 100%;
        align-items: center;
    }

    .animate-scroll-left { animation: scrollLeft 30s linear infinite; }
    .animate-scroll-right { animation: scrollRight 30s linear infinite; }

    /* --- Dasar Latar Belakang & Glow --- */
    .bg-main {
        background-color: var(--bg);
        position: fixed;
        inset: 0;
        z-index: -2;
    }

    .glow-blob {
        position: fixed;
        width: 50vw;
        height: 50vw;
        filter: blur(120px);
        border-radius: 50%;
        z-index: -1;
        pointer-events: none;
        opacity: 0.25;
        animation: drift 20s infinite alternate ease-in-out;
    }

    .blob-blue { background: radial-gradient(circle, var(--accent-blue-glow) 0%, transparent 70%); top: -10%; left: -10%; }
    .blob-purple { background: radial-gradient(circle, var(--accent-purple-glow) 0%, transparent 70%); bottom: -10%; right: -10%; animation-delay: -5s; }

    @keyframes drift {
        from { transform: translate(-10%, -10%) scale(1); }
        to { transform: translate(10%, 10%) scale(1.2); }
    }

    /* --- Efek Kaca Bias --- */
    .glass-card {
        background: rgba(255, 255, 255, 0.02);
        backdrop-filter: blur(25px) saturate(150%);
        border: 1px solid rgba(255, 255, 255, 0.06);
        box-shadow: inset 0 1px 1px rgba(255, 255, 255, 0.05);
    }

    /* ===== Navbar Capsule ===== */
    .nav-pill {
        display: flex;
        align-items: center;
        gap: 0.25rem;
        padding: 0.25rem;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(20px);
    }

    .nav-pill-link {
        padding: 0.5rem 1.2rem;
        border-radius: 999px;
        font-size: 13px;
        font-weight: 600;
        color: rgba(255, 255, 255, 0.6);
        transition: all 0.35s ease;
        text-decoration: none;
    }

    /* Ukuran PC lebih besar sedikit */
    @media (min-width: 768px) {
        .nav-pill { gap: 0.35rem; padding: 0.35rem; }
        .nav-pill-link { padding: 0.6rem 1.8rem; font-size: 14px; }
    }

    .nav-pill-link:hover { color: #fff; }
    .nav-pill-link.active { background: rgba(255, 255, 255, 0.1); color: #fff; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }

    .logo-text {
        font-weight: 900;
        font-size: 22px;
        text-transform: uppercase;
        letter-spacing: -0.05em;
        color: white;
        text-decoration: none;
    }

    .nav-right-link {
        font-size: 14px;
        font-weight: 600;
        color: rgba(255, 255, 255, 0.7);
        transition: all 0.3s ease;
        text-decoration: none;
    }
    .nav-right-link:hover { color: #ffffff; }

    .menu-btn {
        width: 44px; height: 44px; border-radius: 50%;
        background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.15);
        backdrop-filter: blur(15px); color: white;
        font-size: 18px; transition: all 0.3s ease; cursor: none;
    }
    
    .menu-btn:hover {
        background: rgba(255,255,255,0.1);
    }

    /* ===== Glassmorphism Button ===== */
    .animated-button {
        position: relative;
        display: flex;
        align-items: center;
        gap: 4px;
        padding: 14px 36px;
        background: rgba(255, 255, 255, 0.04);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 100px;
        font-size: 11px;
        text-transform: uppercase;
        font-weight: 800;
        letter-spacing: 0.15em;
        color: #fff;
        cursor: pointer;
        overflow: hidden;
        transition: all 0.6s cubic-bezier(0.23, 1, 0.32, 1);
        text-decoration: none;
        width: fit-content;
    }

    .animated-button .circle {
        position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);
        width: 20px; height: 20px; background-color: var(--accent-blue);
        border-radius: 50%; opacity: 0; transition: all 0.8s cubic-bezier(0.23, 1, 0.32, 1);
    }
    .animated-button:hover .circle { width: 300px; height: 300px; opacity: 1; }
    .animated-button .text { position: relative; z-index: 1; transform: translateX(-10px); transition: all 0.8s cubic-bezier(0.23, 1, 0.32, 1); }
    .animated-button svg { position: absolute; width: 16px; fill: #fff; z-index: 9; transition: all 0.8s cubic-bezier(0.23, 1, 0.32, 1); }
    .animated-button .arr-1 { right: 16px; }
    .animated-button .arr-2 { left: -25%; }
    .animated-button:hover { border-color: rgba(255, 255, 255, 0.3); }
    .animated-button:hover .arr-1 { right: -25%; }
    .animated-button:hover .arr-2 { left: 16px; }
    .animated-button:hover .text { transform: translateX(12px); }

    /* ===== Minecraft Cursor & Effects ===== */
    #minecraft-cursor { position: fixed; top: 0; left: 0; width: 44px; height: 44px; background-image: url('https://cur.cursors-4u.net/games/gam-13/gam1282.png'); background-size: contain; background-repeat: no-repeat; pointer-events: none; z-index: 10000; transform: rotate(-15deg); filter: drop-shadow(0 0 8px var(--accent-blue-glow)); }
    #cursor-glow { position: fixed; width: 160px; height: 160px; background: radial-gradient(circle, rgba(59, 130, 246, 0.3) 0%, rgba(139, 92, 246, 0.1) 40%, transparent 75%); border-radius: 50%; pointer-events: none; z-index: 9999; transform: translate(-50%, -50%); transition: width 0.4s ease, height 0.4s ease; }
    .particle { position: fixed; background: radial-gradient(circle, #fff 0%, var(--accent-blue) 60%, transparent 100%); border-radius: 50%; pointer-events: none; z-index: 9998; box-shadow: 0 0 10px rgba(59, 130, 246, 0.8); animation: particleLife 0.8s forwards ease-out; }
    @keyframes particleLife { 0% { opacity: 1; transform: scale(1); } 100% { opacity: 0; transform: scale(0) translateY(20px); } }

    /* --- Reveal --- */
    html { scroll-behavior: smooth; }
    .reveal { opacity: 0; transform: translateY(30px); transition: all 1s cubic-bezier(0.16, 1, 0.3, 1); }
    .reveal.active { opacity: 1; transform: translateY(0); }

    /* ===== Footer Section ===== */
    .footer-section { padding: 100px 8vw 60px; border-top: 1px solid rgba(255,255,255,0.08); background: #030303; position: relative; z-index: 10; }
    
    @media (min-width: 768px) {
        .footer-section { padding: 100px 15vw 60px; }
    }
</style>

<!-- Background & Glow -->
<div class="bg-main"></div>
<div class="glow-blob blob-blue"></div>
<div class="glow-blob blob-purple"></div>

<!-- Custom Cursor & Aura -->
<div id="cursor-glow"></div>
<div id="minecraft-cursor"></div>

<div class="relative z-10 text-white selection:bg-white selection:text-black font-sans">
    
    <!-- HEADER NAVBAR -->
    @include('partials.navbar')

    <!-- HERO SECTION -->
    <section class="min-h-screen flex flex-col justify-center px-8 md:px-48 relative overflow-hidden pt-32 md:pt-0">
        <div class="reveal grid lg:grid-cols-2 gap-12 items-center">
            
            <div class="order-2 lg:order-1">
                <!-- Tipografi diseimbangkan line-height dan font-size nya -->
                <h1 class="text-[13vw] md:text-[7vw] font-black leading-[0.9] md:leading-[0.85] tracking-tighter uppercase mb-8">
                    Digital <br /> 
                    <span class="text-zinc-800 hover:text-white transition-colors duration-1000 cursor-default">Architect.</span>
                </h1>
                
                <div class="max-w-sm">
                    <p class="text-zinc-400 text-base md:text-lg leading-relaxed mb-10">
                        Membangun jembatan antara teknologi dan estetika melalui desain <span class="text-white font-medium">Glassmorphism</span> yang modern.
                    </p>
                    <div class="flex">
                        <a href="#work" class="animated-button">
                          <svg viewBox="0 0 24 24" class="arr-2" xmlns="http://www.w3.org/2000/svg">
                            <path d="M16.1716 10.9999L10.8076 5.63589L12.2218 4.22168L20 11.9999L12.2218 19.778L10.8076 18.3638L16.1716 12.9999H4V10.9999H16.1716Z"></path>
                          </svg>
                          <span class="text">Lihat Showcase</span>
                          <span class="circle"></span>
                          <svg viewBox="0 0 24 24" class="arr-1" xmlns="http://www.w3.org/2000/svg">
                            <path d="M16.1716 10.9999L10.8076 5.63589L12.2218 4.22168L20 11.9999L12.2218 19.778L10.8076 18.3638L16.1716 12.9999H4V10.9999H16.1716Z"></path>
                          </svg>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Profile Image (Diturunkan via margin mobile di parent grid/padding top) -->
            <div class="order-1 lg:order-2 flex justify-center lg:justify-end items-center mb-8 md:mb-0">
                <div class="relative group animate-float">
                    <div class="absolute -inset-6 opacity-[25%] z-0 hidden sm:block">
                        <div class="absolute inset-0 bg-gradient-to-r from-violet-600 via-indigo-500 to-purple-600 rounded-full blur-2xl animate-spin-slower"></div>
                        <div class="absolute inset-0 bg-gradient-to-l from-fuchsia-500 via-rose-500 to-pink-600 rounded-full blur-2xl animate-pulse-slow opacity-50"></div>
                    </div>
                    
                    <div class="relative">
                        <div class="w-56 h-56 md:w-72 md:h-72 rounded-full overflow-hidden shadow-[0_0_40px_rgba(120,119,198,0.3)] transform transition-all duration-700 group-hover:scale-105">
                            <div class="absolute inset-0 border-4 border-white/20 rounded-full z-20 transition-all duration-700 group-hover:border-white/40"></div>
                            <img src="https://i.pravatar.cc/500?img=32" alt="Profile" class="w-full h-full object-cover transition-all duration-700 group-hover:scale-110 group-hover:rotate-2" loading="lazy">
                            <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-all duration-700 z-20 hidden sm:block">
                                <div class="absolute inset-0 bg-gradient-to-tr from-transparent via-white/20 to-transparent transform -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></div>
                                <div class="absolute inset-0 rounded-full border-8 border-white/10 scale-0 group-hover:scale-100 transition-transform duration-700 animate-pulse-slow"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- WORK SECTION -->
    <section id="work" class="px-6 md:px-48 py-24 md:py-32 border-t border-white/5 relative">
        <div class="flex flex-col md:flex-row justify-between items-end mb-16 md:mb-24 reveal">
            <div>
                <!-- Teks "Portofolio" Dihapus -->
                <h2 class="text-4xl md:text-7xl font-black tracking-tighter uppercase leading-none">Showcase.</h2>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-12 gap-6 md:gap-10">
            @php
                $projects = [
                    ['title' => 'Nexus Platform', 'company' => 'Google, \'23', 'desc' => 'Membangun ekosistem yang berkelanjutan.', 'img' => 'https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?q=80&w=1200', 'span' => 'md:col-span-8'],
                    ['title' => 'Aether Identity', 'company' => 'Discord, \'22', 'desc' => 'Mendefinisikan ulang masa depan branding.', 'img' => 'https://images.unsplash.com/photo-1633167606207-d840b5070fc2?q=80&w=1200', 'span' => 'md:col-span-4'],
                ];
            @endphp

            @foreach($projects as $index => $p)
            <!-- Desain Kartu Diubah untuk Responsive (Petak pada Mobile) -->
            <a href="#" class="{{ $p['span'] }} group project-card relative overflow-hidden rounded-[2rem] glass-card reveal block no-underline" style="transition-delay: {{ $index * 150 }}ms">
                
                <!-- Background Image yang menggelap -->
                <div class="absolute inset-0 z-0">
                    <img src="{{ $p['img'] }}" class="w-full h-full object-cover opacity-30 group-hover:opacity-60 group-hover:scale-105 transition-all duration-1000" alt="{{ $p['title'] }}">
                    <div class="absolute inset-0 bg-gradient-to-t from-[#0a0a0a] via-[#0a0a0a]/60 to-transparent md:bg-none"></div>
                </div>

                <!-- Konten Kartu -->
                <div class="relative z-10 p-8 md:p-10 flex flex-col justify-between min-h-[350px] md:min-h-[500px]">
                    <div class="flex justify-between items-start">
                        <div class="pr-6">
                            <h3 class="text-3xl md:text-4xl font-bold tracking-tight text-white mb-3">{{ $p['title'] }}</h3>
                            <p class="text-gray-400 text-sm md:text-base leading-relaxed">
                                <span class="font-bold text-white">{{ $p['company'] }}</span> — {{ $p['desc'] }}
                            </p>
                        </div>
                        
                        <!-- Ikon Panah Kanan -->
                        <div class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center shrink-0 backdrop-blur-md transform group-hover:bg-white group-hover:text-black transition-all duration-300">
                            <svg class="w-5 h-5 transform -rotate-45 group-hover:rotate-0 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M12 5l7 7-7 7"></path>
                            </svg>
                        </div>
                    </div>

                    <!-- Elemen dekoratif/kosong di bawah untuk balance ruang -->
                    <div class="mt-auto hidden md:block">
                        <span class="text-blue-400 text-[10px] font-black uppercase tracking-[0.3em] block translate-y-4 group-hover:translate-y-0 opacity-0 group-hover:opacity-100 transition-all duration-500">View Project</span>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </section>

    <!-- OUR FRIENDS SECTION -->
    <section class="py-24 md:py-32 border-t border-white/5 relative overflow-hidden">
        <div class="px-8 md:px-48 mb-12 md:mb-16 reveal">
            <!-- Teks "Partnership" Dihapus -->
            <h2 class="text-4xl md:text-6xl font-black tracking-tighter uppercase leading-none">Our Friends.</h2>
        </div>

        <!-- Row 1: Moves Right -->
        <div class="marquee-container mb-8 md:mb-12">
            <div class="marquee-content animate-scroll-right">
                @foreach(range(1, 10) as $i)
                <div class="px-8 py-5 md:px-10 md:py-6 glass-card rounded-2xl flex items-center justify-center min-w-[160px] md:min-w-[200px] opacity-40 hover:opacity-100 transition-opacity">
                    <span class="text-lg md:text-xl font-bold tracking-widest uppercase italic">CLIENT_{{ $i }}</span>
                </div>
                @endforeach
                <!-- Duplicate for seamless loop -->
                @foreach(range(1, 10) as $i)
                <div class="px-8 py-5 md:px-10 md:py-6 glass-card rounded-2xl flex items-center justify-center min-w-[160px] md:min-w-[200px] opacity-40 hover:opacity-100 transition-opacity">
                    <span class="text-lg md:text-xl font-bold tracking-widest uppercase italic">CLIENT_{{ $i }}</span>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Row 2: Moves Left -->
        <div class="marquee-container">
            <div class="marquee-content animate-scroll-left">
                @foreach(range(11, 20) as $i)
                <div class="px-8 py-5 md:px-10 md:py-6 glass-card rounded-2xl flex items-center justify-center min-w-[160px] md:min-w-[200px] opacity-40 hover:opacity-100 transition-opacity">
                    <span class="text-lg md:text-xl font-bold tracking-widest uppercase italic">PARTNER_{{ $i }}</span>
                </div>
                @endforeach
                <!-- Duplicate for seamless loop -->
                @foreach(range(11, 20) as $i)
                <div class="px-8 py-5 md:px-10 md:py-6 glass-card rounded-2xl flex items-center justify-center min-w-[160px] md:min-w-[200px] opacity-40 hover:opacity-100 transition-opacity">
                    <span class="text-lg md:text-xl font-bold tracking-widest uppercase italic">PARTNER_{{ $i }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- FOOTER SECTION -->
    @include('partials.footer')
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // --- Mobile Menu Dropdown Logic ---
        const menuBtn = document.getElementById('menu-toggle');
        const menuIcon = document.getElementById('menu-icon');
        const mobileMenu = document.getElementById('mobile-menu');
        let isMenuOpen = false;

        if (menuBtn) {
            menuBtn.addEventListener('click', () => {
                isMenuOpen = !isMenuOpen;
                
                if (isMenuOpen) {
                    // Animasi rotasi ikon ke X
                    menuIcon.style.transform = 'rotate(90deg) scale(0.5)';
                    menuIcon.style.opacity = '0';
                    setTimeout(() => {
                        menuIcon.textContent = '✕';
                        menuIcon.style.transform = 'rotate(0deg) scale(1)';
                        menuIcon.style.opacity = '1';
                    }, 150);

                    // Munculkan menu
                    mobileMenu.classList.remove('opacity-0', 'pointer-events-none', '-translate-y-4');
                    mobileMenu.classList.add('opacity-100', 'pointer-events-auto', 'translate-y-0');
                } else {
                    // Animasi rotasi ikon kembali ke @
                    menuIcon.style.transform = 'rotate(-90deg) scale(0.5)';
                    menuIcon.style.opacity = '0';
                    setTimeout(() => {
                        menuIcon.textContent = '@';
                        menuIcon.style.transform = 'rotate(0deg) scale(1)';
                        menuIcon.style.opacity = '1';
                    }, 150);

                    // Sembunyikan menu
                    mobileMenu.classList.remove('opacity-100', 'pointer-events-auto', 'translate-y-0');
                    mobileMenu.classList.add('opacity-0', 'pointer-events-none', '-translate-y-4');
                }
            });

            // Tutup menu jika klik di luar
            document.addEventListener('click', (e) => {
                if (isMenuOpen && !menuBtn.contains(e.target) && !mobileMenu.contains(e.target)) {
                    menuBtn.click();
                }
            });
        }

        // --- Minecraft Cursor & Glow Logic ---
        // (Tetap berjalan di desktop, dan tidak masalah di mobile jika disentuh)
        const cursor = document.getElementById('minecraft-cursor');
        const glow = document.getElementById('cursor-glow');
        let targetX = 0, targetY = 0, currentX = 0, currentY = 0, glowX = 0, glowY = 0;

        document.addEventListener('mousemove', (e) => {
            targetX = e.clientX; targetY = e.clientY;
            createParticle(e.clientX, e.clientY);
        });

        function createParticle(x, y) {
            // Mengurangi partikel di mobile untuk performa
            if(window.innerWidth < 768 && Math.random() > 0.3) return; 

            const particle = document.createElement('div');
            particle.classList.add('particle');
            const size = Math.random() * 8 + 4;
            particle.style.width = `${size}px`; 
            particle.style.height = `${size}px`;
            particle.style.background = Math.random() > 0.5 ? 'radial-gradient(circle, #fff 0%, rgba(59, 130, 246, 0.8) 60%, transparent 100%)' : 'radial-gradient(circle, #fff 0%, rgba(139, 92, 246, 0.8) 60%, transparent 100%)';
            particle.style.left = (x + (Math.random() - 0.5) * 12) + 'px'; 
            particle.style.top = (y + (Math.random() - 0.5) * 12) + 'px';
            document.body.appendChild(particle);
            setTimeout(() => particle.remove(), 800);
        }

        const animate = () => {
            currentX += (targetX - currentX) * 0.2; 
            currentY += (targetY - currentY) * 0.2;
            glowX += (targetX - glowX) * 0.1; 
            glowY += (targetY - glowY) * 0.1;
            
            if(cursor && glow) {
                cursor.style.left = `${currentX}px`; 
                cursor.style.top = `${currentY}px`;
                glow.style.left = `${glowX}px`; 
                glow.style.top = `${glowY}px`;
            }
            requestAnimationFrame(animate);
        };
        animate();

        // Reveal Observer
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => { if (entry.isIntersecting) entry.target.classList.add('active'); });
        }, { threshold: 0.1 });
        document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
    });
</script>
@endsection