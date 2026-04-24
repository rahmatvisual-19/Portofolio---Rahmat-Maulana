@extends('layouts.app')

@section('content')
<!-- 
    PORTFOLIO ULTIMATE EDITION - RESPONSIVE UPDATE
    - Navbar Kiri & Menu @ Dropdown
    - Layout Showcase Petak untuk Mobile
    - Added: Morph Animation untuk Card Lightbox
-->

<style>
    @import url('https://fonts.googleapis.com/css2?family=Albert+Sans:ital,wght@0,100..900;1,100..900&family=Gloock&family=JetBrains+Mono:ital,wght@0,100..800;1,100..800&display=swap');

    :root {
        --primary: #ffffff;
        --bg: #050505; /* Background diganti menjadi hitam pekat (mirip referensi) */
        --accent-blue: rgba(59, 130, 246, 1);
        --accent-purple: rgba(139, 92, 246, 1);
        --accent-blue-glow: rgba(59, 130, 246, 0.5);
        --accent-purple-glow: rgba(139, 92, 246, 0.5);
    }

    /* Set Custom Typography */
    .font-albert { font-family: 'Albert Sans', sans-serif; }
    .font-gloock { font-family: 'Gloock', serif; }
    .font-jetbrains { font-family: 'JetBrains Mono', monospace; }

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

    /* --- Dasar Latar Belakang (Dark dengan Radial Glow Putih) --- */
    .bg-main {
        background-color: var(--bg);
        /* Meniru efek blur radial gradient dari komponen referensi */
        background-image: radial-gradient(ellipse at top, rgba(255,255,255,0.08) 0%, transparent 60%);
        position: fixed;
        inset: 0;
        z-index: -2;
    }

    /* --- Efek Kaca Bias --- */
    .glass-card {
        background: rgba(255, 255, 255, 0.02);
        backdrop-filter: blur(25px) saturate(150%);
        border: 1px solid rgba(255, 255, 255, 0.06);
        box-shadow: inset 0 1px 1px rgba(255, 255, 255, 0.05);
    }

    /* --- macOS Window Style --- */
    .macos-window {
        border-radius: 16px;
        border: 1px solid rgba(255, 255, 255, 0.1);
        background: rgba(30, 30, 30, 0.4);
        backdrop-filter: blur(30px);
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        overflow: hidden;
        /* Hapus transisi transform dari hover agar tidak konflik dengan parallax scroll */
        transition: box-shadow 0.5s ease;
        transform-origin: top center;
    }
    .macos-window:hover {
        box-shadow: 0 30px 60px -12px rgba(0, 0, 0, 0.6);
    }
    .macos-header {
        display: flex;
        align-items: center;
        padding: 12px 16px;
        background: rgba(255, 255, 255, 0.03);
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        gap: 8px;
    }
    .macos-dot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
    }
    .dot-close { background-color: #FF5F56; box-shadow: inset 0 0 4px rgba(255, 95, 86, 0.5); }
    .dot-minimize { background-color: #FFBD2E; box-shadow: inset 0 0 4px rgba(255, 189, 46, 0.5); }
    .dot-expand { background-color: #27C93F; box-shadow: inset 0 0 4px rgba(39, 201, 63, 0.5); }

    /* --- Glare Effect Card Kustom (Dikembalikan) --- */
    .glare {
        position: absolute;
        inset: 0;
        background: linear-gradient(
            120deg,
            transparent 40%,
            rgba(255,255,255,0.2) 50%,
            transparent 60%
        );
        transform: translateX(-100%);
        transition: transform 0.8s cubic-bezier(0.25, 1, 0.5, 1);
        pointer-events: none;
        z-index: 10;
    }

    .group:hover .glare {
        transform: translateX(100%);
    }

    /* --- FILTER ANIMATION STATES --- */
    .filter-hide-up {
        opacity: 0 !important;
        transform: translateY(-30px) !important;
        pointer-events: none;
    }
    .filter-hide-down {
        opacity: 0 !important;
        transform: translateY(30px) !important;
        pointer-events: none;
    }
    .no-transition {
        transition: none !important;
    }

    /* --- Utilities Khusus --- */
    .hide-scrollbar::-webkit-scrollbar { 
        display: none; /* Sembunyikan scrollbar di Chrome/Safari */
    }
    .hide-scrollbar { 
        -ms-overflow-style: none; /* Sembunyikan scrollbar di IE/Edge */
        scrollbar-width: none; /* Sembunyikan scrollbar di Firefox */
    }

    /* --- Showcase Mobile Grid (2 Baris Horizontal) --- */
    .showcase-grid {
        display: grid;
        grid-template-rows: repeat(2, minmax(0, 1fr));
        grid-auto-flow: column;
        grid-auto-columns: 85vw;
    }
    @media (min-width: 640px) {
        .showcase-grid {
            grid-auto-columns: 45vw;
        }
    }
    @media (min-width: 768px) {
        .showcase-grid {
            grid-template-rows: none;
            grid-auto-flow: row;
            grid-auto-columns: auto;
        }
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
    #minecraft-cursor { position: fixed; top: 0; left: 0; width: 44px; height: 44px; background-image: url('https://cur.cursors-4u.net/games/gam-13/gam1282.png'); background-size: contain; background-repeat: no-repeat; pointer-events: none; z-index: 999999; transform: rotate(-15deg); filter: drop-shadow(0 0 8px var(--accent-blue-glow)); }
    #cursor-glow { position: fixed; width: 160px; height: 160px; background: radial-gradient(circle, rgba(59, 130, 246, 0.3) 0%, rgba(139, 92, 246, 0.1) 40%, transparent 75%); border-radius: 50%; pointer-events: none; z-index: 999998; transform: translate(-50%, -50%); transition: width 0.4s ease, height 0.4s ease; }
    .particle { position: fixed; background: radial-gradient(circle, #fff 0%, var(--accent-blue) 60%, transparent 100%); border-radius: 50%; pointer-events: none; z-index: 999997; box-shadow: 0 0 10px rgba(59, 130, 246, 0.8); animation: particleLife 0.8s forwards ease-out; }
    @keyframes particleLife { 0% { opacity: 1; transform: scale(1); } 100% { opacity: 0; transform: scale(0) translateY(20px); } }

    /* --- Premium Blur & Scale Reveal Animasi Scroll --- */
    html { scroll-behavior: smooth; }
    
    .reveal { 
        opacity: 0; 
        /* Mulai dengan keadaan buram (blur), ukuran 90%, dan posisi agak di bawah */
        filter: blur(16px);
        transform: translateY(50px) scale(0.9); 
        transition: all 1.2s cubic-bezier(0.16, 1, 0.3, 1); 
        will-change: opacity, transform, filter; /* Optimasi render browser */
    }
    
    .reveal.active { 
        opacity: 1; 
        /* Fokus menajam, kembali ke ukuran normal dan posisi asli */
        filter: blur(0px);
        transform: translateY(0) scale(1); 
    }

    /* ===== Footer Section ===== */
    .footer-section { padding: 100px 8vw 60px; border-top: 1px solid rgba(255,255,255,0.08); background: #030303; position: relative; z-index: 10; }
    
    @media (min-width: 768px) {
        .footer-section { padding: 100px 15vw 60px; }
    }

    /* ===== Animated Generate Button ===== */
    .ui-anim-btn {
        --highlight: hsl(var(--highlight-hue), 100%, 70%);
        --highlight-30: hsla(var(--highlight-hue), 100%, 70%, 0.3);
        --highlight-80: hsla(var(--highlight-hue), 100%, 70%, 0.8);
        box-shadow: inset 0px 1px 1px rgba(255,255,255,0.2), inset 0px 2px 2px rgba(255,255,255,0.1), 0 4px 16px rgba(0,0,0,0.3);
        text-decoration: none;
    }
    .ui-anim-btn::before {
        content: "";
        position: absolute;
        top: -4px; left: -4px;
        width: calc(100% + 8px);
        height: calc(100% + 8px);
        border-radius: 28px;
        pointer-events: none;
        background-image: linear-gradient(0deg, #0004, #000a);
        z-index: -1;
        transition: box-shadow 0.4s;
        box-shadow: 1px 1px 1px #fff2, 2px 2px 2px #fff1, -1px -1px 1px #0002;
    }
    .ui-anim-btn::after {
        content: "";
        position: absolute;
        inset: 0;
        border-radius: inherit;
        pointer-events: none;
        background-image: linear-gradient(0deg, #fff, var(--highlight), transparent);
        opacity: 0;
        transition: opacity 0.4s;
    }
    .ui-anim-btn:hover {
        border-color: hsla(210, 100%, 80%, 0.4) !important;
    }
    .ui-anim-btn:hover::before {
        box-shadow: 0 -8px 8px -6px #fffa inset, 0 -16px 16px -8px var(--highlight-30) inset, 1px 1px 1px #fff2, -1px -1px 1px #0002;
    }
    .ui-anim-btn:hover::after {
        opacity: 1;
        -webkit-mask-image: linear-gradient(0deg, #fff, transparent);
        mask-image: linear-gradient(0deg, #fff, transparent);
    }
    .ui-anim-btn:hover .ui-anim-txt { color: #fff; }
    .ui-anim-btn-svg {
        fill: #e8e8e8;
        filter: drop-shadow(0 0 2px #fff9);
        animation: ui-flicker 2s linear infinite;
        animation-delay: 0.5s;
        transition: fill 0.4s, filter 0.4s;
    }
    .ui-anim-btn:hover .ui-anim-btn-svg {
        fill: #fff;
        filter: drop-shadow(0 0 3px hsl(210, 100%, 70%));
        animation: none;
    }
    @keyframes ui-flicker {
        50% { opacity: 0.4; }
    }

    /* --- Form Kustom --- */
    .form-input {
        width: 100%;
        background-color: rgba(10, 10, 10, 0.6);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 12px;
        padding: 14px 16px;
        color: #fff;
        font-family: 'Albert Sans', sans-serif;
        font-size: 14px;
        outline: none;
        transition: all 0.3s ease;
    }
    .form-input:focus {
        border-color: rgba(79, 142, 247, 0.8);
        box-shadow: 0 0 0 1px rgba(79, 142, 247, 0.8);
    }
    .form-input::placeholder {
        color: rgba(255, 255, 255, 0.3);
    }
    .section-label {
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 0.15em;
        text-transform: uppercase;
        color: rgba(255, 255, 255, 0.4);
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .section-label::before {
        content: '';
        display: block;
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background-color: #fff;
    }
</style>

<!-- Background Hitam Gradient Glow -->
<div class="bg-main"></div>

<!-- Dotted Surface Background -->
<div id="dotted-surface" class="pointer-events-none fixed inset-0 z-[-1]"></div>

<!-- Custom Cursor & Aura -->
<div id="cursor-glow"></div>
<div id="minecraft-cursor"></div>

<div class="relative z-10 text-white selection:bg-white selection:text-black font-albert">
    
    <!-- HEADER NAVBAR -->
    @include('partials.navbar')

    <!-- HERO SECTION -->
    <section class="min-h-screen flex flex-col items-center justify-center relative overflow-hidden pt-32 md:pt-0">
        
        <!-- GLSL Hills Canvas Container -->
        <div id="glsl-hills-container" class="absolute inset-0 z-0 pointer-events-none"></div>

        <!-- Hero Content -->
        <div class="relative z-10 flex flex-col items-center justify-center text-center pointer-events-none px-4 reveal -mt-16 md:-mt-20 w-full">
            <h1 class="flex flex-col items-center justify-center w-full">
                <span class="italic text-4xl md:text-6xl lg:text-[5rem] font-light font-gloock text-white mb-2 md:mb-4 tracking-wide">
                    Designs That Speak
                </span>
                <span class="font-bold text-5xl md:text-7xl lg:text-[6.5rem] font-albert text-white tracking-tight leading-none">
                    Louder Than Words
                </span>
            </h1>
            
            <p class="text-sm md:text-base text-white/90 font-albert max-w-xl mx-auto mt-6 md:mt-8 leading-relaxed">
                We craft stunning visuals and user - friendly experiences that <br class="hidden md:block"/> help your brand stand out and connect with your audience.
            </p>

            <div class="relative inline-block mt-8 pointer-events-auto">
                <a href="#contact" id="btn-lets-work" class="ui-anim-btn relative flex items-center justify-center rounded-[24px] px-5 py-2.5 border border-white/20 transition-all duration-400" style="--highlight-hue: 210deg; background: rgba(255,255,255,0.04); backdrop-filter: blur(12px);">
                    <svg class="ui-anim-btn-svg mr-2 h-5 w-5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true" fill="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904 9 18.75l-.813-2.846a4.5 4.5 0 0 0-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 0 0 3.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 0 0 3.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 0 0-3.09 3.09ZM18.259 8.715 18 9.75l-.259-1.035a3.375 3.375 0 0 0-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 0 0 2.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 0 0 2.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 0 0-2.456 2.456ZM16.894 20.567 16.5 21.75l-.394-1.183a2.25 2.25 0 0 0-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 0 0 1.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 0 0 1.423 1.423l1.183.394-1.183.394a2.25 2.25 0 0 0-1.423 1.423Z"></path>
                    </svg>
                    <span class="ui-anim-txt text-sm font-semibold tracking-wide text-white/80">Let's Work Together</span>
                </a>
            </div>
        </div>

    </section>

    <!-- WORK SECTION -->
    <section id="work" class="px-6 md:px-32 lg:px-48 py-24 md:py-32 border-t border-white/5 relative">
        <div class="flex flex-col md:flex-row justify-between items-center md:items-end mb-12 md:mb-20 reveal gap-8 text-center md:text-left">
            <div class="w-full md:w-auto">
                <h2 class="text-4xl md:text-7xl font-black tracking-tighter uppercase leading-none font-albert">Showcase.</h2>
                <p class="font-gloock text-xl text-zinc-400 mt-4 italic">Stories behind the screens</p>
            </div>
            
            <div class="flex gap-2 p-1.5 bg-white/[0.03] backdrop-blur-md border border-white/10 rounded-full self-center md:self-end" id="filter-buttons">
                <button data-filter="all" class="filter-btn px-6 py-2 rounded-full text-[13px] font-jetbrains bg-white/10 text-white transition-all shadow-sm">All</button>
                <button data-filter="design" class="filter-btn px-6 py-2 rounded-full text-[13px] font-jetbrains text-white/50 hover:text-white hover:bg-white/5 transition-all">Design</button>
                <button data-filter="dev" class="filter-btn px-6 py-2 rounded-full text-[13px] font-jetbrains text-white/50 hover:text-white hover:bg-white/5 transition-all">Dev</button>
            </div>
        </div>

        <div class="showcase-grid md:grid-cols-2 lg:grid-cols-4 overflow-x-auto md:overflow-visible snap-x snap-mandatory md:snap-none gap-6 md:gap-8 transition-all duration-500 pb-8 md:pb-0 hide-scrollbar -mx-6 px-6 md:mx-0 md:px-0" id="projects-grid">
            @php
                $projects = [
                    ['category' => 'design', 'title' => 'Nexus', 'company' => 'Google, \'23', 'desc' => 'Desain ekosistem.', 'img' => 'https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?q=80&w=1200'],
                    ['category' => 'dev', 'title' => 'Aether', 'company' => 'Discord, \'22', 'desc' => 'Arsitektur backend.', 'img' => 'https://images.unsplash.com/photo-1633167606207-d840b5070fc2?q=80&w=1200'],
                    ['category' => 'design', 'title' => 'Lumina', 'company' => 'Spotify, \'21', 'desc' => 'Antarmuka futuristik.', 'img' => 'https://images.unsplash.com/photo-1558655146-d09347e92766?q=80&w=1200'],
                    ['category' => 'dev', 'title' => 'Orbit', 'company' => 'Stripe, \'24', 'desc' => 'Visualisasi data.', 'img' => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?q=80&w=1200'],
                    ['category' => 'design', 'title' => 'Echo', 'company' => 'Apple, \'23', 'desc' => 'Sistem suara spasial.', 'img' => 'https://images.unsplash.com/photo-1611162617474-5b21e879e113?q=80&w=1200'],
                    ['category' => 'dev', 'title' => 'Vanguard', 'company' => 'Vercel, \'22', 'desc' => 'Infrastruktur cloud.', 'img' => 'https://images.unsplash.com/photo-1555066931-4365d14bab8c?q=80&w=1200'],
                    ['category' => 'design', 'title' => 'Prism UI', 'company' => 'Figma, \'21', 'desc' => 'Sistem desain UI.', 'img' => 'https://images.unsplash.com/photo-1561070791-2526d30994b5?q=80&w=1200'],
                    ['category' => 'dev', 'title' => 'Quantum', 'company' => 'OpenAI, \'24', 'desc' => 'Mesin pemrosesan AI.', 'img' => 'https://images.unsplash.com/photo-1518770660439-4636190af475?q=80&w=1200'],
                ];
            @endphp

            @foreach($projects as $index => $p)
            <div class="project-item relative group reveal transition-all duration-500 w-full snap-center md:snap-align-none" data-category="{{ $p['category'] }}" style="transition-delay: {{ $index * 100 }}ms">
                
                <div class="absolute inset-0 rounded-[24px] border border-white/10 blur-sm opacity-40 group-hover:opacity-80 transition duration-500"></div>

                <!-- Perhatikan penggunaan "this" dan "data-attributes" untuk menghindari error karakter kutip -->
                <div onclick="openCardLightbox(this)"
                     data-img="{{ $p['img'] }}"
                     data-title="{{ $p['title'] }}"
                     data-company="{{ $p['company'] }}"
                     data-desc="{{ $p['desc'] }}"
                     data-category="{{ $p['category'] }}"
                     class="block h-full relative rounded-[24px] overflow-hidden bg-[#111111] border border-white/10 p-5 transition-all duration-500 hover:-translate-y-1 hover:bg-[#161616] cursor-none no-underline flex flex-col">

                    <div class="flex justify-between items-start mb-6">
                        <div class="pr-2">
                            <h3 class="text-xl md:text-2xl font-bold tracking-tight text-white mb-1 font-albert">
                                {{ $p['title'] }}
                            </h3>
                            <p class="text-zinc-400 text-xs md:text-sm font-albert font-light leading-relaxed mt-1 line-clamp-2">
                                <span class="text-white font-medium">{{ $p['company'] }}</span>
                                — {{ $p['desc'] }}
                            </p>
                        </div>

                        <img 
                            src="https://cdn.prod.website-files.com/63dcb6e1a80e9454b630f4c4/641284285486aaab07feafaa_icon-arrow-project.svg"
                            alt="Arrow"
                            class="w-6 h-6 transform -rotate-45 group-hover:rotate-0 transition duration-300 opacity-70 group-hover:opacity-100 shrink-0 mt-1"
                        />
                    </div>

                    <div class="relative rounded-xl md:rounded-[18px] overflow-hidden border border-white/10 aspect-[5/4] mt-auto card-image-container">
                        <img 
                            src="{{ $p['img'] }}"
                            alt="{{ $p['title'] }}"
                            class="w-full h-full object-cover opacity-100 transition duration-700 main-img"
                        />
                        <div class="absolute inset-0 bg-gradient-to-t from-[#111111]/60 via-transparent to-transparent pointer-events-none"></div>
                    </div>

                    <div class="glare"></div>
                    <div class="absolute inset-0 rounded-[24px] bg-gradient-to-br from-blue-500/10 to-purple-500/10 opacity-0 group-hover:opacity-100 transition duration-500 pointer-events-none"></div>

                </div>
            </div>
            @endforeach
        </div>
    </section>

    <!-- ===================== CARD LIGHTBOX (DENGAN MORPH ANIMATION) ===================== -->
    <div id="card-lightbox" class="fixed inset-0 z-[99999] flex items-center justify-center bg-black/80 backdrop-blur-md opacity-0 pointer-events-none transition-opacity duration-500 p-4 md:p-8" onclick="closeCardLightbox()">

        <button class="absolute top-6 right-6 text-white/80 hover:text-white transition-colors bg-white/5 hover:bg-white/10 p-3 rounded-full z-50 cursor-none">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>

        <!-- Modal Content: Dibuang class transform / transition bawaan agar JS bisa menangani morph animasi secara penuh -->
        <div id="card-lightbox-modal" class="relative w-full max-w-4xl bg-[#0c0c0c] border border-white/10 rounded-[28px] overflow-hidden flex flex-col md:flex-row shadow-[0_60px_120px_rgba(0,0,0,0.8)]" onclick="event.stopPropagation()">

            <div class="w-full md:w-[55%] relative overflow-hidden" style="min-height:260px;">
                <img id="card-lightbox-img" src="" alt="" class="w-full h-full object-cover" style="min-height:260px;">
                <div class="absolute inset-0 bg-gradient-to-r from-transparent via-transparent to-[#0c0c0c] hidden md:block pointer-events-none"></div>
                <div class="absolute inset-0 bg-gradient-to-t from-[#0c0c0c] via-transparent to-transparent md:hidden pointer-events-none"></div>
            </div>

            <div class="w-full md:w-[45%] p-8 md:p-12 flex flex-col justify-center gap-0 relative">
                <span id="lb-cat" class="text-[10px] font-bold tracking-[0.25em] uppercase text-blue-400 mb-5 block"></span>
                <h2 id="card-lightbox-title" class="text-3xl md:text-[2.5rem] font-black tracking-tight text-white font-albert leading-tight mb-2"></h2>
                <p id="card-lightbox-company" class="text-zinc-500 font-jetbrains text-xs mb-5"></p>
                <p id="card-lightbox-desc" class="text-zinc-400 text-sm leading-relaxed mb-8"></p>
                <a href="#contact" onclick="closeCardLightbox()" class="inline-flex items-center gap-2 px-6 py-3 rounded-full bg-white text-black text-sm font-bold hover:bg-zinc-100 transition-all w-fit cursor-none">
                    Discuss This Project
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            </div>
        </div>
    </div>

    <!-- OUR FRIENDS SECTION -->
    <section class="py-24 md:py-32 border-t border-white/5 relative overflow-hidden">
        <div class="px-8 md:px-48 mb-12 md:mb-16 reveal">
            <h2 class="text-4xl md:text-6xl font-black tracking-tighter uppercase leading-none font-albert">Selected Clients.</h2>
            <p class="font-gloock text-xl text-zinc-400 mt-4 italic">People I've worked with</p>
        </div>

        <div class="marquee-container mb-8 md:mb-12">
            <div class="marquee-content animate-scroll-right">
                @foreach(range(1, 10) as $i)
                <div class="px-8 py-5 md:px-10 md:py-6 glass-card rounded-2xl flex items-center justify-center min-w-[160px] md:min-w-[200px] opacity-40 hover:opacity-100 transition-opacity">
                    <span class="text-lg md:text-xl font-bold tracking-widest uppercase italic">CLIENT_{{ $i }}</span>
                </div>
                @endforeach
                @foreach(range(1, 10) as $i)
                <div class="px-8 py-5 md:px-10 md:py-6 glass-card rounded-2xl flex items-center justify-center min-w-[160px] md:min-w-[200px] opacity-40 hover:opacity-100 transition-opacity">
                    <span class="text-lg md:text-xl font-bold tracking-widest uppercase italic">CLIENT_{{ $i }}</span>
                </div>
                @endforeach
            </div>
        </div>

        <div class="marquee-container">
            <div class="marquee-content animate-scroll-left">
                @foreach(range(11, 20) as $i)
                <div class="px-8 py-5 md:px-10 md:py-6 glass-card rounded-2xl flex items-center justify-center min-w-[160px] md:min-w-[200px] opacity-40 hover:opacity-100 transition-opacity">
                    <span class="text-lg md:text-xl font-bold tracking-widest uppercase italic">PARTNER_{{ $i }}</span>
                </div>
                @endforeach
                @foreach(range(11, 20) as $i)
                <div class="px-8 py-5 md:px-10 md:py-6 glass-card rounded-2xl flex items-center justify-center min-w-[160px] md:min-w-[200px] opacity-40 hover:opacity-100 transition-opacity">
                    <span class="text-lg md:text-xl font-bold tracking-widest uppercase italic">PARTNER_{{ $i }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- CONTACT / CTA SECTION -->
    <section id="contact" class="py-24 md:py-32 border-t border-white/5 relative overflow-hidden px-6 md:px-16 lg:px-48 max-w-[1600px] mx-auto reveal">

        <div class="grid lg:grid-cols-12 gap-12 lg:gap-16 items-start relative z-10 w-full">
            
            <!-- Left: CTA Text -->
            <div class="lg:col-span-5 space-y-8">
                <div>
                    <div class="section-label mb-5">LET'S BUILD TOGETHER</div>
                    <h2 class="text-4xl md:text-5xl lg:text-6xl font-black tracking-tighter uppercase leading-none font-albert text-white mb-6">
                        Have a project in <br class="hidden md:block"/>
                        <span class="italic text-zinc-400 font-gloock font-normal lowercase pr-2">mind?</span>
                    </h2>
                    <p class="font-albert text-[15px] text-zinc-400 leading-relaxed max-w-sm">
                        I'm available for freelance projects and consulting. Whether you need a full product build, a design system, or performance optimization — let's make it exceptional.
                    </p>
                </div>

                <!-- Contact Options -->
                <div class="space-y-4">
                    <a href="mailto:hello@example.com" class="flex items-center gap-4 p-4 rounded-[20px] bg-white/[0.02] border border-white/10 hover:bg-white/[0.05] transition-all group">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0 bg-[#4F8EF7]/10 text-[#4F8EF7]">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        </div>
                        <div>
                            <div class="font-jetbrains text-[10px] text-zinc-500 uppercase tracking-widest">Email</div>
                            <div class="font-albert text-[14px] font-semibold text-white group-hover:text-[#4F8EF7] transition-colors">hello@example.com</div>
                        </div>
                    </a>
                    
                    <a href="#" class="flex items-center gap-4 p-4 rounded-[20px] bg-white/[0.02] border border-white/10 hover:bg-white/[0.05] transition-all group">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0 bg-[#F472B6]/10 text-[#F472B6]">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <rect x="2" y="2" width="20" height="20" rx="5" ry="5" stroke-width="2"></rect>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37z"></path>
                                <line x1="17.5" y1="6.5" x2="17.51" y2="6.5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></line>
                            </svg>
                        </div>
                        <div>
                            <div class="font-jetbrains text-[10px] text-zinc-500 uppercase tracking-widest">Instagram</div>
                            <div class="font-albert text-[14px] font-semibold text-white group-hover:text-[#F472B6] transition-colors">@yourhandle</div>
                        </div>
                    </a>
                    
                    <a href="#" class="flex items-center gap-4 p-4 rounded-[20px] bg-white/[0.02] border border-white/10 hover:bg-white/[0.05] transition-all group">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0 bg-[#22D3EE]/10 text-[#22D3EE]">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg>
                        </div>
                        <div>
                            <div class="font-jetbrains text-[10px] text-zinc-500 uppercase tracking-widest">GitHub</div>
                            <div class="font-albert text-[14px] font-semibold text-white group-hover:text-[#22D3EE] transition-colors">github.com/yourhandle</div>
                        </div>
                    </a>
                </div>

                <!-- Availability -->
                <div class="p-5 rounded-[20px] bg-green-500/5 border border-green-500/20 flex items-center gap-3">
                    <div class="w-3 h-3 rounded-full bg-green-500 animate-pulse flex-shrink-0"></div>
                    <div>
                        <div class="font-albert text-[14px] font-semibold text-white">Currently available</div>
                        <div class="font-jetbrains text-[11px] text-zinc-500 mt-1">Response within 24h</div>
                    </div>
                </div>
            </div>

            <!-- Right: Contact Form -->
            <div class="lg:col-span-7">
                <div class="bg-white/[0.02] backdrop-blur-xl border border-white/10 rounded-[28px] p-8 md:p-10 shadow-2xl">
                    <div class="mb-8">
                        <h3 class="font-albert text-[24px] font-bold text-white mb-2">Start a conversation</h3>
                        <p class="font-albert text-[14px] text-zinc-400">Tell me about your project and I'll get back to you via WhatsApp.</p>
                    </div>

                    <form id="contactForm" class="space-y-5">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label class="font-jetbrains text-[11px] text-zinc-500 uppercase tracking-widest block mb-2">Your Name</label>
                                <input type="text" id="wa-name" placeholder="Jane Smith" required class="form-input">
                            </div>
                            <div>
                                <label class="font-jetbrains text-[11px] text-zinc-500 uppercase tracking-widest block mb-2">Email Address</label>
                                <input type="email" id="wa-email" placeholder="jane@company.com" required class="form-input">
                            </div>
                        </div>

                        <div>
                            <label class="font-jetbrains text-[11px] text-zinc-500 uppercase tracking-widest block mb-2">Project Type</label>
                            <select id="wa-project" required class="form-input appearance-none cursor-pointer">
                                <option value="" disabled selected>Select project type</option>
                                <option value="Developer">Developer</option>
                                <option value="Desain">Desain</option>
                                <option value="General">General</option>
                            </select>
                        </div>

                        <div>
                            <label class="font-jetbrains text-[11px] text-zinc-500 uppercase tracking-widest block mb-2">Tell me about your project</label>
                            <textarea id="wa-desc" placeholder="Describe what you're building, your timeline, and what success looks like..." rows="5" required class="form-input resize-none"></textarea>
                        </div>

                        <button type="submit" class="w-full bg-white text-black font-bold font-albert text-[15px] py-4 rounded-[14px] hover:bg-gray-200 transition-all hover:scale-[1.02] flex items-center justify-center gap-2">
                            Send Message via WhatsApp
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                        </button>
                        
                        <p class="font-jetbrains text-[10px] text-zinc-500 text-center mt-4">
                            You will be redirected to WhatsApp.
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER SECTION -->
    @include('partials.footer')
</div>

<!-- Tambahkan library Three.js dari CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r134/three.min.js"></script>

<script>
    // =============================================
    // CARD LIGHTBOX DENGAN MORPH ANIMATION LENGKAP
    // =============================================
    const cardLightbox = document.getElementById('card-lightbox');
    const cardLightboxModal = document.getElementById('card-lightbox-modal');
    
    // Variabel untuk menyimpan element dan posisi asal
    let activeCardEl = null;
    let morphOriginX = 0;
    let morphOriginY = 0;

    // Fungsi sekarang hanya menerima element 'el'
    window.openCardLightbox = function(el) {
        
        // --- 1. Tangkap Elemen & Koordinat ---
        activeCardEl = el;
        const rect = activeCardEl.getBoundingClientRect();
        
        // Kalkulasi jarak dari titik tengah layar ke titik tengah card
        const viewportCenterX = window.innerWidth / 2;
        const viewportCenterY = window.innerHeight / 2;
        const cardCenterX = rect.left + (rect.width / 2);
        const cardCenterY = rect.top + (rect.height / 2);
        
        morphOriginX = cardCenterX - viewportCenterX;
        morphOriginY = cardCenterY - viewportCenterY;

        // --- 2. Update Konten dengan mengambil dari Data Attributes ---
        document.getElementById('card-lightbox-img').src = el.getAttribute('data-img');
        document.getElementById('card-lightbox-title').textContent = el.getAttribute('data-title');
        document.getElementById('card-lightbox-company').textContent = el.getAttribute('data-company');
        document.getElementById('card-lightbox-desc').textContent = el.getAttribute('data-desc');
        document.getElementById('lb-cat').textContent = el.getAttribute('data-category') + ' project';

        // --- 3. Set Posisi & Dimensi Awal Modal (Untuk ilusi morphing dari posisi klik) ---
        cardLightboxModal.style.transition = 'none'; // Matikan transisi untuk inisialisasi instan
        cardLightboxModal.style.transform = `translate(${morphOriginX}px, ${morphOriginY}px) scale(0.2)`;
        cardLightboxModal.style.opacity = '0';
        cardLightboxModal.style.borderRadius = '60px'; // Set radius agar mirip card saat membesar

        // --- 4. Tampilkan Backdrop dan Sembunyikan Card aslinya (Ilusi berubah wujud) ---
        cardLightbox.classList.remove('opacity-0', 'pointer-events-none');
        document.body.style.overflow = 'hidden';
        
        activeCardEl.style.transition = 'opacity 0.2s ease';
        activeCardEl.style.opacity = '0';

        // --- 5. Jalankan Transisi Morph (Ke arah tengah) ---
        // Request animation frame memastikan CSS diletakkan dulu sebelum transisi dibaca browser
        requestAnimationFrame(() => {
            requestAnimationFrame(() => {
                // Beri pengaturan transisi penuh (ease cubic yang sangat mulus)
                cardLightboxModal.style.transition = 'all 0.6s cubic-bezier(0.25, 1, 0.2, 1)';
                cardLightboxModal.style.transform = 'translate(0px, 0px) scale(1)';
                cardLightboxModal.style.opacity = '1';
                cardLightboxModal.style.borderRadius = '28px'; // Kembali ke default styling Modal Tailwind Anda
            });
        });
    };

    window.closeCardLightbox = function() {
        
        // --- 1. Jalankan Transisi Morph terbalik (Kembali ke card origin) ---
        cardLightboxModal.style.transform = `translate(${morphOriginX}px, ${morphOriginY}px) scale(0.2)`;
        cardLightboxModal.style.opacity = '0';
        cardLightboxModal.style.borderRadius = '60px';

        cardLightbox.classList.add('opacity-0', 'pointer-events-none');
        document.body.style.overflow = '';
        
        // --- 2. Kembalikan Visibilitas Card Asli sebelum modal benar-benar tertutup ---
        if (activeCardEl) {
            setTimeout(() => {
                activeCardEl.style.opacity = '1';
                activeCardEl = null; // Reset
            }, 300); // 300ms agar terjadi hand-off transisi yang halus
        }

        // --- 3. Bersihkan sisa gambar ---
        setTimeout(() => { 
            document.getElementById('card-lightbox-img').src = ''; 
        }, 600);
    };

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && !cardLightbox.classList.contains('opacity-0')) {
            closeCardLightbox();
        }
    });
</script>

<script>
    // =============================================
    // WHATSAPP REDIRECT LOGIC
    // =============================================
    document.addEventListener('DOMContentLoaded', () => {
        const contactForm = document.getElementById('contactForm');
        
        if (contactForm) {
            contactForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const name = document.getElementById('wa-name').value;
                const email = document.getElementById('wa-email').value;
                const project = document.getElementById('wa-project').value;
                const desc = document.getElementById('wa-desc').value;

                const textMsg = `Name : ${name}\nEmail : ${email}\nProject type : ${project}\nTell me about your project : ${desc}`;
                const encodedText = encodeURIComponent(textMsg);

                const nomorWhatsApp = '6281234567890'; // <-- GANTI NOMOR INI
                const waUrl = `https://wa.me/${nomorWhatsApp}?text=${encodedText}`;

                window.open(waUrl, '_blank');
            });
        }

        const btnLetsWork = document.getElementById('btn-lets-work');
        if (btnLetsWork) {
            btnLetsWork.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.getElementById('contact');
                if (target) {
                    if (window.lenis) {
                        window.lenis.scrollTo(target, { duration: 1.2, easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)) });
                    } else {
                        target.scrollIntoView({ behavior: 'smooth' });
                    }
                }
            });
        }
    });

    // =============================================
    // DOTTED SURFACE BACKGROUND (Three.js)
    // =============================================
    (function initDottedSurface() {
        const container = document.getElementById('dotted-surface');
        if (!container || typeof THREE === 'undefined') return;

        const SEPARATION = 150;
        const AMOUNTX = 40;
        const AMOUNTY = 60;

        const scene = new THREE.Scene();

        const camera = new THREE.PerspectiveCamera(60, window.innerWidth / window.innerHeight, 1, 10000);
        camera.position.set(0, 355, 1220);

        const renderer = new THREE.WebGLRenderer({ alpha: true, antialias: true });
        renderer.setPixelRatio(window.devicePixelRatio);
        renderer.setSize(window.innerWidth, window.innerHeight);
        renderer.setClearColor(0x000000, 0);
        container.appendChild(renderer.domElement);

        const positions = [];
        const colors = [];

        for (let ix = 0; ix < AMOUNTX; ix++) {
            for (let iy = 0; iy < AMOUNTY; iy++) {
                positions.push(
                    ix * SEPARATION - (AMOUNTX * SEPARATION) / 2,
                    0,
                    iy * SEPARATION - (AMOUNTY * SEPARATION) / 2
                );
                colors.push(180, 180, 180);
            }
        }

        const geometry = new THREE.BufferGeometry();
        geometry.setAttribute('position', new THREE.Float32BufferAttribute(positions, 3));
        geometry.setAttribute('color', new THREE.Float32BufferAttribute(colors, 3));

        const material = new THREE.PointsMaterial({
            size: 6,
            vertexColors: true,
            transparent: true,
            opacity: 0.35,
            sizeAttenuation: true,
        });

        const points = new THREE.Points(geometry, material);
        scene.add(points);

        let count = 0;

        function animate() {
            requestAnimationFrame(animate);

            const posAttr = geometry.attributes.position;
            const pos = posAttr.array;
            let i = 0;

            for (let ix = 0; ix < AMOUNTX; ix++) {
                for (let iy = 0; iy < AMOUNTY; iy++) {
                    pos[i * 3 + 1] =
                        Math.sin((ix + count) * 0.3) * 50 +
                        Math.sin((iy + count) * 0.5) * 50;
                    i++;
                }
            }

            posAttr.needsUpdate = true;

            const heroHeight = window.innerHeight;
            const scrollY = window.scrollY;
            const clipTop = Math.max(0, heroHeight - scrollY);
            const clipHeight = window.innerHeight - clipTop;

            if (clipHeight > 0) {
                renderer.setScissorTest(true);
                renderer.setScissor(0, 0, window.innerWidth, clipHeight);
                renderer.setViewport(0, 0, window.innerWidth, window.innerHeight);
                renderer.render(scene, camera);
                renderer.setScissorTest(false);
            }

            count += 0.07;
        }

        animate();

        window.addEventListener('resize', () => {
            camera.aspect = window.innerWidth / window.innerHeight;
            camera.updateProjectionMatrix();
            renderer.setSize(window.innerWidth, window.innerHeight);
        });
    })();
</script>

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
                    menuIcon.style.transform = 'rotate(90deg) scale(0.5)';
                    menuIcon.style.opacity = '0';
                    setTimeout(() => {
                        menuIcon.textContent = '✕';
                        menuIcon.style.transform = 'rotate(0deg) scale(1)';
                        menuIcon.style.opacity = '1';
                    }, 150);

                    mobileMenu.classList.remove('opacity-0', 'pointer-events-none', '-translate-y-4');
                    mobileMenu.classList.add('opacity-100', 'pointer-events-auto', 'translate-y-0');
                } else {
                    menuIcon.style.transform = 'rotate(-90deg) scale(0.5)';
                    menuIcon.style.opacity = '0';
                    setTimeout(() => {
                        menuIcon.textContent = '@';
                        menuIcon.style.transform = 'rotate(0deg) scale(1)';
                        menuIcon.style.opacity = '1';
                    }, 150);

                    mobileMenu.classList.remove('opacity-100', 'pointer-events-auto', 'translate-y-0');
                    mobileMenu.classList.add('opacity-0', 'pointer-events-none', '-translate-y-4');
                }
            });

            document.addEventListener('click', (e) => {
                if (isMenuOpen && !menuBtn.contains(e.target) && !mobileMenu.contains(e.target)) {
                    menuBtn.click();
                }
            });
        }

        // --- Minecraft Cursor & Glow Logic ---
        const cursor = document.getElementById('minecraft-cursor');
        const glow = document.getElementById('cursor-glow');
        let targetX = 0, targetY = 0, currentX = 0, currentY = 0, glowX = 0, glowY = 0;

        document.addEventListener('mousemove', (e) => {
            targetX = e.clientX; targetY = e.clientY;
            createParticle(e.clientX, e.clientY);
        });

        function createParticle(x, y) {
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

        // --- Reveal Observer (Animasi saat di-scroll) ---
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => { 
                if (entry.isIntersecting) {
                    entry.target.classList.add('active');
                }
            });
        }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });
        
        document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

        // --- Animasi Filter Sempurna ---
        const filterBtns = document.querySelectorAll('.filter-btn');
        const projectItems = document.querySelectorAll('.project-item');
        let isAnimating = false; 

        filterBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                if (isAnimating || btn.classList.contains('bg-white/10')) return;

                isAnimating = true; 

                filterBtns.forEach(b => {
                    b.classList.remove('bg-white/10', 'text-white', 'shadow-sm');
                    b.classList.add('text-white/50');
                });
                btn.classList.remove('text-white/50');
                btn.classList.add('bg-white/10', 'text-white', 'shadow-sm');

                const filterValue = btn.getAttribute('data-filter');
                
                const currentlyVisible = Array.from(projectItems).filter(item => item.style.display !== 'none');
                const itemsToShow = Array.from(projectItems).filter(item => {
                    return filterValue === 'all' || item.getAttribute('data-category') === filterValue;
                });

                currentlyVisible.forEach(item => {
                    item.style.transitionDelay = '0ms'; 
                    item.classList.remove('filter-hide-up');
                    item.classList.add('filter-hide-down');
                });

                const hideDuration = currentlyVisible.length > 0 ? 400 : 0;

                setTimeout(() => {
                    projectItems.forEach(item => {
                        item.style.display = 'none';
                        item.classList.remove('filter-hide-down', 'filter-hide-up');
                    });

                    let enterDelay = 0; 

                    itemsToShow.forEach(item => {
                        item.classList.add('filter-hide-up', 'no-transition');
                        item.style.display = 'block';

                        void item.offsetWidth;

                        item.style.transitionDelay = `${enterDelay * 75}ms`;
                        enterDelay++;

                        item.classList.remove('no-transition', 'filter-hide-up');
                    });

                    setTimeout(() => {
                        isAnimating = false;
                    }, (enterDelay * 75) + 500);

                }, hideDuration);
            });
        });

        // --- THREE.JS GLSL Hills Logic (Hero Background) ---
        const glslContainer = document.getElementById('glsl-hills-container');
        if (glslContainer && typeof THREE !== 'undefined') {
            
            class Plane {
                constructor() {
                    this.uniforms = {
                        time: { type: 'f', value: 0 },
                    };
                    this.time = 0.5; 
                    this.mesh = this.createMesh();
                }

                createMesh() {
                    return new THREE.Mesh(
                        new THREE.PlaneGeometry(256, 256, 256, 256),
                        new THREE.RawShaderMaterial({
                            uniforms: this.uniforms,
                            vertexShader: `
                              #define GLSLIFY 1
                              attribute vec3 position;
                              uniform mat4 projectionMatrix;
                              uniform mat4 modelViewMatrix;
                              uniform float time;
                              varying vec3 vPosition;

                              mat4 rotateMatrixX(float radian) {
                                return mat4(
                                  1.0, 0.0, 0.0, 0.0,
                                  0.0, cos(radian), -sin(radian), 0.0,
                                  0.0, sin(radian), cos(radian), 0.0,
                                  0.0, 0.0, 0.0, 1.0
                                );
                              }

                              vec3 mod289(vec3 x) { return x - floor(x * (1.0 / 289.0)) * 289.0; }
                              vec4 mod289(vec4 x) { return x - floor(x * (1.0 / 289.0)) * 289.0; }
                              vec4 permute(vec4 x) { return mod289(((x*34.0)+1.0)*x); }
                              vec4 taylorInvSqrt(vec4 r) { return 1.79284291400159 - 0.85373472095314 * r; }
                              vec3 fade(vec3 t) { return t*t*t*(t*(t*6.0-15.0)+10.0); }

                              float cnoise(vec3 P) {
                                vec3 Pi0 = floor(P);
                                vec3 Pi1 = Pi0 + vec3(1.0);
                                Pi0 = mod289(Pi0);
                                Pi1 = mod289(Pi1);
                                vec3 Pf0 = fract(P);
                                vec3 Pf1 = Pf0 - vec3(1.0);
                                vec4 ix = vec4(Pi0.x, Pi1.x, Pi0.x, Pi1.x);
                                vec4 iy = vec4(Pi0.yy, Pi1.yy);
                                vec4 iz0 = Pi0.zzzz;
                                vec4 iz1 = Pi1.zzzz;

                                vec4 ixy = permute(permute(ix) + iy);
                                vec4 ixy0 = permute(ixy + iz0);
                                vec4 ixy1 = permute(ixy + iz1);

                                vec4 gx0 = ixy0 * (1.0 / 7.0);
                                vec4 gy0 = fract(floor(gx0) * (1.0 / 7.0)) - 0.5;
                                gx0 = fract(gx0);
                                vec4 gz0 = vec4(0.5) - abs(gx0) - abs(gy0);
                                vec4 sz0 = step(gz0, vec4(0.0));
                                gx0 -= sz0 * (step(0.0, gx0) - 0.5);
                                gy0 -= sz0 * (step(0.0, gy0) - 0.5);

                                vec4 gx1 = ixy1 * (1.0 / 7.0);
                                vec4 gy1 = fract(floor(gx1) * (1.0 / 7.0)) - 0.5;
                                gx1 = fract(gx1);
                                vec4 gz1 = vec4(0.5) - abs(gx1) - abs(gy1);
                                vec4 sz1 = step(gz1, vec4(0.0));
                                gx1 -= sz1 * (step(0.0, gx1) - 0.5);
                                gy1 -= sz1 * (step(0.0, gy1) - 0.5);

                                vec3 g000 = vec3(gx0.x,gy0.x,gz0.x);
                                vec3 g100 = vec3(gx0.y,gy0.y,gz0.y);
                                vec3 g010 = vec3(gx0.z,gy0.z,gz0.z);
                                vec3 g110 = vec3(gx0.w,gy0.w,gz0.w);
                                vec3 g001 = vec3(gx1.x,gy1.x,gz1.x);
                                vec3 g101 = vec3(gx1.y,gy1.y,gz1.y);
                                vec3 g011 = vec3(gx1.z,gy1.z,gz1.z);
                                vec3 g111 = vec3(gx1.w,gy1.w,gz1.w);

                                vec4 norm0 = taylorInvSqrt(vec4(dot(g000, g000), dot(g010, g010), dot(g100, g100), dot(g110, g110)));
                                g000 *= norm0.x;
                                g010 *= norm0.y;
                                g100 *= norm0.z;
                                g110 *= norm0.w;
                                vec4 norm1 = taylorInvSqrt(vec4(dot(g001, g001), dot(g011, g011), dot(g101, g101), dot(g111, g111)));
                                g001 *= norm1.x;
                                g011 *= norm1.y;
                                g101 *= norm1.z;
                                g111 *= norm1.w;

                                float n000 = dot(g000, Pf0);
                                float n100 = dot(g100, vec3(Pf1.x, Pf0.yz));
                                float n010 = dot(g010, vec3(Pf0.x, Pf1.y, Pf0.z));
                                float n110 = dot(g110, vec3(Pf1.xy, Pf0.z));
                                float n001 = dot(g001, vec3(Pf0.xy, Pf1.z));
                                float n101 = dot(g101, vec3(Pf1.x, Pf0.y, Pf1.z));
                                float n011 = dot(g011, vec3(Pf0.x, Pf1.yz));
                                float n111 = dot(g111, Pf1);

                                vec3 fade_xyz = fade(Pf0);
                                vec4 n_z = mix(vec4(n000, n100, n010, n110), vec4(n001, n101, n011, n111), fade_xyz.z);
                                vec2 n_yz = mix(n_z.xy, n_z.zw, fade_xyz.y);
                                float n_xyz = mix(n_yz.x, n_yz.y, fade_xyz.x);
                                return 2.2 * n_xyz;
                              }

                              void main(void) {
                                vec3 updatePosition = (rotateMatrixX(radians(90.0)) * vec4(position, 1.0)).xyz;
                                float sin1 = sin(radians(updatePosition.x / 128.0 * 90.0));
                                vec3 noisePosition = updatePosition + vec3(0.0, 0.0, time * -30.0);
                                float noise1 = cnoise(noisePosition * 0.08);
                                float noise2 = cnoise(noisePosition * 0.06);
                                float noise3 = cnoise(noisePosition * 0.4);
                                vec3 lastPosition = updatePosition + vec3(0.0,
                                  noise1 * sin1 * 8.0
                                  + noise2 * sin1 * 8.0
                                  + noise3 * (abs(sin1) * 2.0 + 0.5)
                                  + pow(sin1, 2.0) * 40.0, 0.0);

                                vPosition = lastPosition;
                                gl_Position = projectionMatrix * modelViewMatrix * vec4(lastPosition, 1.0);
                              }
                            `,
                            fragmentShader: `
                              precision highp float;
                              #define GLSLIFY 1
                              varying vec3 vPosition;

                              void main(void) {
                                float opacity = (96.0 - length(vPosition)) / 256.0 * 0.6;
                                vec3 color = vec3(0.6);
                                gl_FragColor = vec4(color, opacity);
                              }
                            `,
                            transparent: true
                        })
                    );
                }

                render(timeDelta) {
                    this.uniforms.time.value += timeDelta * this.time;
                }
            }

            const renderer = new THREE.WebGLRenderer({ antialias: false, alpha: true });
            const scene = new THREE.Scene();
            const camera = new THREE.PerspectiveCamera(45, glslContainer.clientWidth / glslContainer.clientHeight, 1, 10000);
            const clock = new THREE.Clock();
            const plane = new Plane();

            const resize = () => {
                const width = glslContainer.clientWidth;
                const height = glslContainer.clientHeight;
                camera.aspect = width / height;
                camera.updateProjectionMatrix();
                renderer.setSize(width, height);
            };

            const init = () => {
                renderer.setPixelRatio(window.devicePixelRatio);
                renderer.setSize(glslContainer.clientWidth, glslContainer.clientHeight);
                renderer.setClearColor(0x000000, 0); 
                glslContainer.appendChild(renderer.domElement);
                
                camera.position.set(0, 16, 125);
                camera.lookAt(new THREE.Vector3(0, 28, 0));
                
                scene.add(plane.mesh);
                window.addEventListener('resize', resize);
                resize();
                renderLoop();
            };

            const renderLoop = () => {
                plane.render(clock.getDelta());
                renderer.render(scene, camera);
                requestAnimationFrame(renderLoop);
            };

            init();
        }

    });
</script>
@endsection