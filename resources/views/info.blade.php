@extends('layouts.app')

@section('content')

<!-- 
    INFO PAGE - PERRY WANG INSPIRED
    - Layout gambar & teks bergantian (zig-zag)
    - List Experience & Skills
    - Efek Frame pada gambar dengan Bezel & Blur Reveal
-->

<style>
    :root {
        --primary: #ffffff;
        --bg: #050505; /* Disamakan dengan halaman portofolio */
        --accent-blue: rgba(59, 130, 246, 1);
        --accent-purple: rgba(139, 92, 246, 1);
        --accent-blue-glow: rgba(59, 130, 246, 0.5);
        --accent-purple-glow: rgba(139, 92, 246, 0.5);
        --glass-bg: rgba(255, 255, 255, 0.03);
        --glass-border: rgba(255, 255, 255, 0.08);
    }

    /* Sembunyikan kursor asli */
    html, body, a, button {
        cursor: none !important;
    }

    /* --- Animasi Dasar --- */
    .bg-main {
        background-color: var(--bg);
        /* Meniru efek blur radial gradient dari komponen referensi */
        background-image: radial-gradient(ellipse at top, rgba(255,255,255,0.08) 0%, transparent 60%);
        position: fixed;
        inset: 0;
        z-index: -2;
    }

    @keyframes drift {
        from { transform: translate(-10%, -10%) scale(1); }
        to { transform: translate(10%, 10%) scale(1.2); }
    }

    /* --- Efek Kaca Bias --- */
    .glass-card {
        background: var(--glass-bg);
        backdrop-filter: blur(25px) saturate(150%);
        border: 1px solid var(--glass-border);
    }

    /* ===== Minecraft Cursor & Effects ===== */
    #minecraft-cursor { position: fixed; top: 0; left: 0; width: 44px; height: 44px; background-image: url('https://cur.cursors-4u.net/games/gam-13/gam1282.png'); background-size: contain; background-repeat: no-repeat; pointer-events: none; z-index: 2147483647; transform: rotate(-15deg); filter: drop-shadow(0 0 8px var(--accent-blue-glow)); }
    #cursor-glow { position: fixed; width: 160px; height: 160px; background: radial-gradient(circle, rgba(59, 130, 246, 0.3) 0%, rgba(139, 92, 246, 0.1) 40%, transparent 75%); border-radius: 50%; pointer-events: none; z-index: 2147483646; transform: translate(-50%, -50%); transition: width 0.4s ease, height 0.4s ease; }
    .particle { position: fixed; background: radial-gradient(circle, #fff 0%, var(--accent-blue) 60%, transparent 100%); border-radius: 50%; pointer-events: none; z-index: 2147483645; box-shadow: 0 0 10px rgba(59, 130, 246, 0.8); animation: particleLife 0.8s forwards ease-out; }
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

    /* --- Typography Utilities --- */
    .section-label {
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 0.15em;
        text-transform: uppercase;
        color: rgba(255, 255, 255, 0.4);
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 2rem;
    }

    /* Animasi Denyut Glow untuk Titik */
    @keyframes pulse-dot {
        0%, 100% { 
            box-shadow: 0 0 8px 1px rgba(255, 255, 255, 0.4); 
            background-color: rgba(255, 255, 255, 0.8);
        }
        50% { 
            box-shadow: 0 0 12px 4px rgba(255, 255, 255, 0.9), 0 0 20px 2px var(--accent-blue-glow); 
            background-color: #ffffff;
        }
    }

    .section-label::before {
        content: '';
        display: block;
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background-color: #fff;
        /* Tambahkan animasi pulse-dot di sini */
        animation: pulse-dot 3s infinite ease-in-out;
    }
    
    .divider {
        height: 1px;
        background: linear-gradient(90deg, rgba(255,255,255,0.05) 0%, rgba(255,255,255,0.1) 50%, rgba(255,255,255,0.05) 100%);
        width: 100%;
        margin: 6rem 0;
    }

    /* Layout Zig-Zag Image (Efek Frame Premium) */
    .frame-wrapper {
        position: relative;
        display: block; /* Menyesuaikan dengan kolom Grid */
        width: 100%;
        height: 100%;
        border-radius: 28px;
    }

    /* Outer Glow Border */
    .frame-wrapper::before {
        content: "";
        position: absolute;
        inset: -2px;
        border-radius: 30px;
        background: linear-gradient(
            120deg,
            rgba(255,255,255,0.3),
            transparent 30%,
            transparent 70%,
            rgba(255,255,255,0.3)
        );
        filter: blur(5px);
        opacity: 0.6;
        z-index: 0;
        transition: opacity 0.5s ease, filter 0.5s ease;
    }

    /* Main Card (Dengan Bezel Hitam & Glow Abu-abu) */
    .frame-card {
        position: relative;
        width: 100%;
        height: 100%;
        border-radius: 28px;
        overflow: hidden;
        /* Gradasi abu-abu ke hitam dengan efek cahaya (glow) dari atas */
        background: radial-gradient(
            circle at 50% 0%, 
            rgba(90, 90, 90, 0.7) 0%, 
            rgba(25, 25, 25, 0.85) 40%, 
            rgba(5, 5, 5, 0.95) 100%
        );
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255,255,255,0.1);
        box-shadow: 
            0 30px 80px rgba(0,0,0,0.6), /* Depth shadow floating */
            inset 0 1px 1px rgba(255,255,255,0.2), /* Highlight tipis di sudut atas */
            inset 0 10px 20px rgba(255,255,255,0.05); /* Inner glow tambahan di bezel */
        z-index: 1;
        transition: transform 0.5s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.5s ease;
        padding: 8px; /* MEMBERIKAN EFEK BEZEL / CELAH SEPERTI DI GAMBAR MERAH */
    }

    /* Image */
    .frame-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        border-radius: 20px; /* Lengkungan mulus di dalam bezel */
        transition: transform 0.7s ease;
    }

    /* Edge Light (Highlight Kiri-Kanan) */
    .edge-glow {
        position: absolute;
        inset: 0;
        border-radius: 28px;
        pointer-events: none;
        background: linear-gradient(
            to right,
            rgba(255,255,255,0.2) 0%,
            transparent 15%,
            transparent 85%,
            rgba(255,255,255,0.2) 100%
        );
        opacity: 0.4;
        mix-blend-mode: overlay;
        z-index: 2;
    }

    /* Inner subtle border */
    .frame-card::after {
        content: "";
        position: absolute;
        inset: 0;
        border-radius: 28px;
        border: 1px solid rgba(255,255,255,0.06);
        pointer-events: none;
        z-index: 3;
    }

    /* Efek Hover Animasi Floating (Kartu keseluruhan membesar, tanpa merusak batas gambar) */
    .frame-wrapper:hover .frame-card {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 
            0 40px 100px -10px rgba(0,0,0,0.9),
            inset 0 1px 1px rgba(255,255,255,0.2),
            inset 0 10px 20px rgba(255,255,255,0.08);
    }
    .frame-wrapper:hover::before {
        opacity: 1;
        filter: blur(8px);
    }

    /* --- Utilities Khusus --- */
    .hide-scrollbar::-webkit-scrollbar { 
        display: none; /* Sembunyikan scrollbar di Chrome/Safari */
    }
    .hide-scrollbar { 
        -ms-overflow-style: none; /* Sembunyikan scrollbar di IE/Edge */
        scrollbar-width: none; /* Sembunyikan scrollbar di Firefox */
    }

    /* ==========================================
       STYLES KHUSUS UNTUK SKILLS SECTION (BAR BARU)
       ========================================== */
    .skill-bar-track {
        width: 100%;
        height: 6px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 999px;
        overflow: hidden;
        position: relative;
    }
    
    .skill-bar-fill {
        height: 100%;
        width: 0%; /* Default 0, dianimasikan oleh JS */
        border-radius: 999px;
        transition: width 1.2s cubic-bezier(0.16, 1, 0.3, 1);
    }

    /* ===== Footer Section ===== */
    .footer-section { padding: 80px 8vw 60px; background: #030303; position: relative; z-index: 10; border-top: 1px solid var(--glass-border);}
    @media (min-width: 768px) { .footer-section { padding: 100px 15vw 60px; } }
</style>

<!-- Background -->
<div class="bg-main"></div>

<!-- Dotted Surface Background -->
<div id="dotted-surface" class="pointer-events-none fixed inset-0 z-[-1]"></div>

<!-- Custom Cursor & Aura -->
<div id="cursor-glow"></div>
<div id="minecraft-cursor"></div>

<div class="relative z-10 text-white selection:bg-white selection:text-black font-sans">
    
    <!-- HEADER NAVBAR -->
    @include('partials.navbar')

    <!-- HERO ABOUT SECTION -->
    <section class="pt-40 md:pt-48 px-6 md:px-16 lg:px-48 max-w-[1600px] mx-auto reveal">
        <!-- HEADER ABOUT ME BARU -->
        <div class="mb-16 md:mb-24">
            <div class="section-label mb-5">ABOUT ME</div>
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-black tracking-tighter uppercase leading-none font-albert text-white">
                    Products that <br class="hidden md:block"/>
                    <span class="italic text-zinc-400 font-serif font-normal lowercase pr-2">
                        empower.
                    </span>
                </h1>
                <p class="text-[15px] text-zinc-400 max-w-sm font-albert leading-relaxed">
                    I'm passionate about creating beautiful digital experiences that connect with people.
                </p>
            </div>
        </div>

        <!-- Story Blocks dari Database -->
        @forelse($stories as $index => $story)
        @php $isEven = $index % 2 === 0; @endphp
        <div class="grid grid-cols-1 md:grid-cols-12 gap-10 md:gap-24 items-center mb-16 md:mb-32 reveal">

            @if($isEven)
            {{-- Gambar kiri, teks kanan --}}
            <div class="md:col-span-6 aspect-[10/13] frame-wrapper">
                <div class="frame-card">
                    <img src="{{ asset('storage/' . $story->image_path) }}" alt="{{ $story->title }}" class="frame-image">
                    <div class="edge-glow"></div>
                </div>
            </div>
            <div class="md:col-span-6">
                @if($story->title)
                <h3 class="text-xl font-bold mb-6">{{ $story->title }}</h3>
                @endif
                <div class="space-y-6 text-zinc-400 text-base leading-relaxed">
                    <p>{{ $story->content }}</p>
                </div>
            </div>
            @else
            {{-- Teks kiri, gambar kanan (zig-zag) --}}
            <div class="md:col-span-5 md:col-start-2 order-2 md:order-1">
                @if($story->title)
                <h3 class="text-xl font-bold mb-6">{{ $story->title }}</h3>
                @endif
                <div class="space-y-6 text-zinc-400 text-base leading-relaxed">
                    <p>{{ $story->content }}</p>
                </div>
            </div>
            <div class="md:col-span-6 order-1 md:order-2 aspect-[10/13] frame-wrapper">
                <div class="frame-card">
                    <img src="{{ asset('storage/' . $story->image_path) }}" alt="{{ $story->title }}" class="frame-image">
                    <div class="edge-glow"></div>
                </div>
            </div>
            @endif

        </div>
        @empty
        {{-- Fallback jika database kosong: tampilkan placeholder --}}
        <div class="grid grid-cols-1 md:grid-cols-12 gap-10 md:gap-24 items-center mb-16 md:mb-32 reveal">
            <div class="md:col-span-6 aspect-[10/13] frame-wrapper">
                <div class="frame-card bg-white/5 flex items-center justify-center">
                    <span class="text-zinc-600 text-sm">Tambahkan story melalui admin panel</span>
                </div>
            </div>
            <div class="md:col-span-6">
                <p class="text-xl md:text-2xl font-medium leading-relaxed max-w-md text-zinc-600">
                    Belum ada story. Tambahkan melalui admin panel.
                </p>
            </div>
        </div>
        @endforelse
    </section>

    <!-- DIVIDER -->
    <div class="px-6 md:px-16 lg:px-48 max-w-[1600px] mx-auto reveal">
        <div class="divider"></div>
    </div>

    <!-- EXPERIENCE SECTION (DRAGGABLE SLIDER) -->
    <section class="px-6 md:px-16 lg:px-48 max-w-[1600px] mx-auto mb-32 reveal select-none">
        
        <!-- HEADER EXPERIENCE BARU -->
        <div class="mb-16 pointer-events-none">
            <div class="section-label mb-5">EXPERIENCE</div>
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                <h2 class="text-4xl md:text-5xl lg:text-6xl font-black tracking-tighter uppercase leading-none font-albert text-white">
                    Places I've <br class="hidden md:block"/>
                    <span class="italic text-zinc-400 font-serif font-normal lowercase pr-2">
                        worked.
                    </span>
                </h2>
                <p class="text-[15px] text-zinc-400 max-w-sm font-albert leading-relaxed">
                    A timeline of my professional journey, collaborating with amazing teams and companies.
                </p>
            </div>
        </div>
        
        <!-- Wadah Slider (Mencegah text blok ter-highlight saat di-drag) -->
        <div class="relative w-full overflow-hidden" id="exp-slider-container">
            <div class="flex transition-transform duration-500 ease-out will-change-transform" id="exp-slider-track">

                @forelse($experiences->chunk(3) as $pageIndex => $chunk)
                <div class="w-full flex-shrink-0 flex flex-col gap-12 md:gap-16 px-1">
                    @foreach($chunk as $exp)
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-6 md:gap-12 items-start pointer-events-none">
                        <div class="md:col-span-4">
                            <h2 class="text-3xl md:text-4xl font-bold">{{ $exp->company }}</h2>
                        </div>
                        <div class="md:col-span-6 md:col-start-6">
                            <h3 class="text-xl md:text-2xl font-medium mb-2">{{ $exp->role }}</h3>
                            <span class="text-sm text-zinc-500 block mb-6">{{ $exp->start_year }} — {{ $exp->end_year }}</span>
                            @if($exp->description)
                            <p class="text-zinc-400 leading-relaxed text-base">{{ $exp->description }}</p>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
                @empty
                <div class="w-full flex-shrink-0 flex flex-col gap-12 md:gap-16 px-1">
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-6 md:gap-12 items-start pointer-events-none">
                        <div class="md:col-span-4">
                            <h2 class="text-3xl md:text-4xl font-bold text-zinc-700">—</h2>
                        </div>
                        <div class="md:col-span-6 md:col-start-6">
                            <p class="text-zinc-600 text-base">Belum ada experience. Tambahkan melalui admin panel.</p>
                        </div>
                    </div>
                </div>
                @endforelse

            </div>
        </div>

        <!-- Pagination Dots (dinamis sesuai jumlah halaman) -->
        <div class="flex justify-center gap-3 mt-12 md:mt-16" id="exp-dots">
            @foreach($experiences->chunk(3) as $pageIndex => $chunk)
            <button class="exp-dot {{ $pageIndex === 0 ? 'w-8 h-2 bg-white' : 'w-2 h-2 bg-white/20 hover:bg-white/50' }} rounded-full transition-all duration-300 pointer-events-auto" data-index="{{ $pageIndex }}"></button>
            @endforeach
            @if($experiences->isEmpty())
            <button class="exp-dot w-8 h-2 rounded-full bg-white transition-all duration-300 pointer-events-auto" data-index="0"></button>
            @endif
        </div>
    </section>

    <!-- DIVIDER -->
    <div class="px-6 md:px-16 lg:px-48 max-w-[1600px] mx-auto reveal">
        <div class="divider"></div>
    </div>

    <!-- ==========================================
         SKILLS SECTION (MENGGANTIKAN FRIENDS) 
         ========================================== -->
    <section id="skills-section" class="py-12 px-6 md:px-16 lg:px-48 max-w-[1600px] mx-auto relative overflow-hidden mb-32 reveal">
        
        <!-- Tambahan Background Bias Ungu khusus area Skills -->
        <div class="absolute inset-0 pointer-events-none" style="background: radial-gradient(ellipse at 70% 50%, rgba(155, 109, 255, 0.05) 0%, transparent 60%);" aria-hidden="true"></div>

        <div class="relative z-10 w-full">
            
            <!-- Header Skills (Diperbarui agar sinkron dengan Section Label) -->
            <div class="mb-16">
                <div class="section-label mb-5">SKILLS & STACK</div>
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                    <h2 class="text-4xl md:text-5xl lg:text-6xl font-black tracking-tighter uppercase leading-none font-albert text-white">
                        Tools I use to <br class="hidden md:block"/>
                        <span class="italic text-zinc-400 font-serif font-normal lowercase pr-2">
                            ship.
                        </span>
                    </h2>
                    <p class="text-[15px] text-zinc-400 max-w-sm font-albert leading-relaxed">
                        Carefully chosen for performance, developer experience, and real-world results.
                    </p>
                </div>
            </div>

            <!-- Bento Grid (Kategori Skills) — hardcode, tidak dari database -->
            @php
            $skillCategories = [
              [
                'title' => 'Core Languages',
                'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.25 6.75L22.5 12l-3.75 5.25m-7.5-10.5L6.75 12l3.75 5.25m-7.5-10.5L3 12l3.75 5.25"/></svg>',
                'iconColor' => '#4F8EF7',
                'accent' => 'rgba(79, 142, 247, 0.15)',
                'skills' => [
                  ['name' => 'TypeScript', 'level' => 97, 'color' => '#4F8EF7'],
                  ['name' => 'JavaScript (ES2024)', 'level' => 99, 'color' => '#4F8EF7'],
                  ['name' => 'HTML / CSS / SVG', 'level' => 98, 'color' => '#4F8EF7'],
                ],
              ],
              [
                'title' => 'React Ecosystem',
                'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>',
                'iconColor' => '#9B6DFF',
                'accent' => 'rgba(155, 109, 255, 0.15)',
                'skills' => [
                  ['name' => 'React 19', 'level' => 98, 'color' => '#9B6DFF'],
                  ['name' => 'Next.js 15', 'level' => 96, 'color' => '#9B6DFF'],
                  ['name' => 'Zustand / Redux', 'level' => 90, 'color' => '#9B6DFF'],
                ],
              ],
              [
                'title' => 'Animation',
                'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 00-2.456 2.456zM16.894 20.567L16.5 21.75l-.394-1.183a2.25 2.25 0 00-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 001.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 001.423 1.423l1.183.394-1.183.394a2.25 2.25 0 00-1.423 1.423z" /></svg>',
                'iconColor' => '#22D3EE',
                'accent' => 'rgba(34, 211, 238, 0.15)',
                'skills' => [
                  ['name' => 'Framer Motion', 'level' => 95, 'color' => '#22D3EE'],
                  ['name' => 'GSAP', 'level' => 88, 'color' => '#22D3EE'],
                ],
              ],
              [
                'title' => 'Styling',
                'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9.53 16.122a3 3 0 00-5.78 1.128 2.25 2.25 0 01-2.4 2.245 4.5 4.5 0 008.4-2.245c0-.399-.078-.78-.22-1.128zm0 0a15.998 15.998 0 003.388-1.62m-5.043-.025a15.994 15.994 0 011.622-3.395m3.42 3.42a15.995 15.995 0 004.764-4.648l3.876-5.814a1.151 1.151 0 00-1.597-1.597L14.146 6.32a15.996 15.996 0 00-4.649 4.763m3.42 3.42a6.776 6.776 0 00-3.42-3.42" /></svg>',
                'iconColor' => '#F472B6',
                'accent' => 'rgba(244, 114, 182, 0.15)',
                'skills' => [
                  ['name' => 'Tailwind CSS', 'level' => 99, 'color' => '#F472B6'],
                  ['name' => 'CSS Modules / Sass', 'level' => 92, 'color' => '#F472B6'],
                ],
              ],
              [
                'title' => 'Performance',
                'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z" /></svg>',
                'iconColor' => '#FCD34D',
                'accent' => 'rgba(252, 211, 77, 0.12)',
                'skills' => [
                  ['name' => 'Core Web Vitals', 'level' => 96, 'color' => '#FCD34D'],
                  ['name' => 'Bundle Optimization', 'level' => 91, 'color' => '#FCD34D'],
                ],
              ],
              [
                'title' => 'Tooling',
                'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 004.486-6.336l-3.276 3.277a3.004 3.004 0 01-2.25-2.25l3.276-3.276a4.5 4.5 0 00-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437l1.745-1.437m6.615 8.206L15.75 15.75M4.867 19.125h.008v.008h-.008v-.008z" /></svg>',
                'iconColor' => '#4F8EF7',
                'accent' => 'rgba(79, 142, 247, 0.1)',
                'skills' => [
                  ['name' => 'Vite / Webpack', 'level' => 88, 'color' => '#4F8EF7'],
                ],
              ],
            ];
            @endphp
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-16">
                @foreach($skillCategories as $idx => $cat)
                <div class="skill-bento-card glass-card rounded-[28px] p-7 shadow-2xl opacity-0 translate-y-[20px] scale-[0.95]" style="transition: opacity 0.6s cubic-bezier(0.16, 1, 0.3, 1), transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);">
                    <div class="flex items-center gap-4 mb-8">
                        <div class="w-12 h-12 rounded-[14px] flex items-center justify-center" style="background: {{ $cat['accent'] }}; color: {{ $cat['iconColor'] }};">
                            <div class="w-6 h-6">{!! $cat['icon'] !!}</div>
                        </div>
                        <span class="font-albert text-lg font-bold text-white tracking-tight">{{ $cat['title'] }}</span>
                    </div>
                    <div class="space-y-5">
                        @foreach($cat['skills'] as $s_idx => $skill)
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <span class="font-mono text-[12px] text-zinc-400 tracking-wide">{{ $skill['name'] }}</span>
                                <span class="font-mono text-[12px] font-bold" style="color: {{ $skill['color'] }}">{{ $skill['level'] }}%</span>
                            </div>
                            <div class="skill-bar-track">
                                <div class="skill-bar-fill"
                                     data-width="{{ $skill['level'] }}%"
                                     style="background: linear-gradient(90deg, {{ $skill['color'] }}40, {{ $skill['color'] }}); transition-delay: {{ ($idx * 0.1) + ($s_idx * 0.1) }}s;">
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Tools dari Database -->
            <div class="glass-card rounded-[28px] p-8 md:p-10 shadow-2xl">
                <div class="font-mono text-[11px] text-zinc-500 uppercase tracking-widest mb-6">
                    Tools & Technologies
                </div>
                <div class="flex flex-wrap gap-3">
                    @forelse($tools as $i => $tool)
                    <span class="tech-tag px-4 py-2 rounded-full font-mono text-[13px] font-medium text-zinc-400 bg-white/[0.03] border border-white/[0.06] cursor-default opacity-0 -translate-x-3 transition-all duration-300 hover:bg-[#4F8EF7]/10 hover:text-[#4F8EF7] hover:border-[#4F8EF7]/30" style="transition: opacity 0.4s ease, transform 0.4s ease, background 0.2s ease, color 0.2s ease, border-color 0.2s ease;">
                        {{ $tool->name }}
                    </span>
                    @empty
                    <span class="text-zinc-600 text-sm italic">Belum ada tools. Tambahkan melalui admin panel.</span>
                    @endforelse
                </div>
            </div>

        </div>
    </section>

    <!-- FOOTER SECTION -->
    @include('partials.footer')
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {

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

        // --- Reveal Observer ---
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => { if (entry.isIntersecting) entry.target.classList.add('active'); });
        }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });
        
        document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

        // --- Drag to Scroll Logic (Experience Section) ---
        const expTrack = document.getElementById('exp-slider-track');
        const expContainer = document.getElementById('exp-slider-container');
        const dots = document.querySelectorAll('.exp-dot');
        
        let isDragging = false;
        let startPos = 0;
        let currentTranslate = 0;
        let prevTranslate = 0;
        let currentIndex = 0;
        const totalPages = 2; 
        
        if (expTrack && expContainer) {

            const updateDots = () => {
                dots.forEach((dot, index) => {
                    if(index === currentIndex) {
                        dot.classList.add('bg-white', 'w-8');
                        dot.classList.remove('bg-white/20', 'w-2');
                    } else {
                        dot.classList.remove('bg-white', 'w-8');
                        dot.classList.add('bg-white/20', 'w-2');
                    }
                });
            }

            const setPositionByIndex = () => {
                currentTranslate = currentIndex * -expContainer.offsetWidth;
                prevTranslate = currentTranslate;
                expTrack.style.transition = 'transform 0.5s cubic-bezier(0.25, 1, 0.5, 1)';
                expTrack.style.transform = `translateX(${currentTranslate}px)`;
                updateDots();
            }

            const getPositionX = (event) => {
                return event.type.includes('mouse') ? event.pageX : event.touches[0].clientX;
            }

            const dragStart = (e) => {
                isDragging = true;
                startPos = getPositionX(e);
                expTrack.style.transition = 'none'; 
            }

            const drag = (e) => {
                if (!isDragging) return;
                e.preventDefault(); 
                const currentPosition = getPositionX(e);
                const diff = currentPosition - startPos;
                currentTranslate = prevTranslate + diff;
                expTrack.style.transform = `translateX(${currentTranslate}px)`;
            }

            const dragEnd = () => {
                if (!isDragging) return;
                isDragging = false;
                
                const movedBy = currentTranslate - prevTranslate;
                
                if (movedBy < -100 && currentIndex < totalPages - 1) {
                    currentIndex += 1;
                } else if (movedBy > 100 && currentIndex > 0) {
                    currentIndex -= 1;
                }
                
                setPositionByIndex(); 
            }

            expContainer.addEventListener('mousedown', dragStart);
            expContainer.addEventListener('touchstart', dragStart, {passive: true});
            
            window.addEventListener('mousemove', drag);
            window.addEventListener('touchmove', drag, {passive: false});
            window.addEventListener('mouseup', dragEnd);
            window.addEventListener('touchend', dragEnd);

            window.addEventListener('resize', setPositionByIndex);

            dots.forEach(dot => {
                dot.addEventListener('click', (e) => {
                    currentIndex = parseInt(e.target.getAttribute('data-index'));
                    setPositionByIndex();
                });
            });
        }

        // --- Intersection Observer KHUSUS Animasi Skills ---
        const skillsSection = document.getElementById('skills-section');
        let hasAnimatedSkills = false;

        if (skillsSection) {
            const skillObserver = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting && !hasAnimatedSkills) {
                        hasAnimatedSkills = true;

                        // 1. Tampilkan Bento Cards secara bergantian (Stagger Reveal)
                        const cards = skillsSection.querySelectorAll('.skill-bento-card');
                        cards.forEach((card, i) => {
                            setTimeout(() => {
                                card.style.opacity = '1';
                                card.style.transform = 'scale(1) translateY(0)';
                            }, i * 80);
                        });

                        // 2. Animasikan Skill Bars melebar sesuai persentase
                        setTimeout(() => {
                            const bars = skillsSection.querySelectorAll('.skill-bar-fill');
                            bars.forEach((bar) => {
                                bar.style.width = bar.getAttribute('data-width');
                            });
                        }, 400);

                        // 3. Munculkan Tech Tags satu per satu (Stagger Tags)
                        const tags = skillsSection.querySelectorAll('.tech-tag');
                        tags.forEach((tag, i) => {
                            setTimeout(() => {
                                tag.style.opacity = '1';
                                tag.style.transform = 'translateX(0)';
                            }, i * 30);
                        });

                        skillObserver.disconnect();
                    }
                });
            }, { threshold: 0.1 });

            skillObserver.observe(skillsSection);
        }

    });
</script>

<!-- Three.js Dotted Surface Background -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r134/three.min.js"></script>
<script>
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
            renderer.render(scene, camera);
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
@endsection