@extends('layouts.app')

@section('content')
<!-- 
    INFO PAGE - PERRY WANG INSPIRED
    - Layout gambar & teks bergantian (zig-zag)
    - List Experience & Friends
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
        opacity: 0.20;
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
        background: var(--glass-bg);
        backdrop-filter: blur(25px) saturate(150%);
        border: 1px solid var(--glass-border);
    }

    /* ===== Minecraft Cursor & Effects ===== */
    #minecraft-cursor { position: fixed; top: 0; left: 0; width: 44px; height: 44px; background-image: url('https://cur.cursors-4u.net/games/gam-13/gam1282.png'); background-size: contain; background-repeat: no-repeat; pointer-events: none; z-index: 10000; transform: rotate(-15deg); filter: drop-shadow(0 0 8px var(--accent-blue-glow)); }
    #cursor-glow { position: fixed; width: 160px; height: 160px; background: radial-gradient(circle, rgba(59, 130, 246, 0.3) 0%, rgba(139, 92, 246, 0.1) 40%, transparent 75%); border-radius: 50%; pointer-events: none; z-index: 9999; transform: translate(-50%, -50%); transition: width 0.4s ease, height 0.4s ease; }
    .particle { position: fixed; background: radial-gradient(circle, #fff 0%, var(--accent-blue) 60%, transparent 100%); border-radius: 50%; pointer-events: none; z-index: 9998; box-shadow: 0 0 10px rgba(59, 130, 246, 0.8); animation: particleLife 0.8s forwards ease-out; }
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

    /* --- Friends Mobile Grid (3 Baris Horizontal) --- */
    .friends-grid {
        display: grid;
        grid-template-rows: repeat(3, minmax(0, 1fr));
        grid-auto-flow: column;
        grid-auto-columns: 80vw; /* Lebar item di mobile */
    }
    @media (min-width: 640px) {
        .friends-grid {
            grid-auto-columns: 45vw;
        }
    }
    @media (min-width: 768px) {
        .friends-grid {
            grid-template-rows: none;
            grid-auto-flow: row;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            grid-auto-columns: auto;
        }
    }

    /* ===== Footer Section ===== */
    .footer-section { padding: 80px 8vw 60px; background: #030303; position: relative; z-index: 10; border-top: 1px solid var(--glass-border);}
    @media (min-width: 768px) { .footer-section { padding: 100px 15vw 60px; } }
</style>

<!-- Background & Glow -->
<div class="bg-main"></div>
<div class="glow-blob blob-blue"></div>
<div class="glow-blob blob-purple"></div>

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
        <div class="mb-16 md:mb-24">
            <span class="section-label">ABOUT ME</span>
            <h1 class="text-4xl md:text-5xl lg:text-[4.5rem] font-medium leading-[1.1] tracking-tight max-w-4xl">
                I'm passionate about creating beautiful products that <span class="italic text-zinc-400 font-serif">empower people.</span>
            </h1>
        </div>

        <!-- Story Block 1 -->
        <div class="grid grid-cols-1 md:grid-cols-12 gap-10 md:gap-24 items-center mb-16 md:mb-32 reveal">
            <div class="md:col-span-6 aspect-[10/13] frame-wrapper">
                <div class="frame-card">
                    <img src="https://images.unsplash.com/photo-1493246507139-91e8fad9978e?q=80&w=1000" alt="Mountain View" class="frame-image">
                    <div class="edge-glow"></div>
                </div>
            </div>
            <div class="md:col-span-6">
                <p class="text-xl md:text-2xl font-medium leading-relaxed max-w-md">
                    This is my story — alongside some flicks from my recent trip to Japan.
                </p>
            </div>
        </div>

        <!-- Story Block 2 (Zig-Zag) -->
        <div class="grid grid-cols-1 md:grid-cols-12 gap-10 md:gap-24 items-center mb-16 md:mb-32 reveal">
            <!-- Teks di kiri pada Desktop, ditukar posisinya -->
            <div class="md:col-span-5 md:col-start-2 order-2 md:order-1">
                <h3 class="text-xl font-bold mb-6">My background in Architecture.</h3>
                <div class="space-y-6 text-zinc-400 text-base leading-relaxed">
                    <p>In June of 2022, I graduated from architecture school at the University of Toronto. There, I became obsessed with architectural visualization.</p>
                    <p>I was deeply fascinated in the concepts of modularity and adaptability — how our built environment could organically evolve in conjunction with humanity.</p>
                </div>
            </div>
            <div class="md:col-span-6 order-1 md:order-2 aspect-[10/13] frame-wrapper">
                <div class="frame-card">
                    <img src="https://images.unsplash.com/photo-1490806843957-31f4c9a91c65?q=80&w=1000" alt="Japan Street" class="frame-image">
                    <div class="edge-glow"></div>
                </div>
            </div>
        </div>

        <!-- Story Block 3 -->
        <div class="grid grid-cols-1 md:grid-cols-12 gap-10 md:gap-24 items-center mb-16 md:mb-32 reveal">
            <div class="md:col-span-6 md:col-start-2 aspect-[10/13] frame-wrapper">
                <div class="frame-card">
                    <img src="https://images.unsplash.com/photo-1542051812-df29141beeb7?q=80&w=1000" alt="Playground" class="frame-image">
                    <div class="edge-glow"></div>
                </div>
            </div>
            <div class="md:col-span-4">
                <h3 class="text-xl font-bold mb-6">But, I wanted more.</h3>
                <div class="space-y-6 text-zinc-400 text-base leading-relaxed">
                    <p>Though I loved the freedom of academic practice, I was greatly dissatisfied with just how slow the industry actually moved.</p>
                    <p>I wanted to push my design craft at a faster pace and have a positive impact on vastly more people.</p>
                </div>
            </div>
        </div>

        <!-- Story Block 4 (Zig-Zag) -->
        <div class="grid grid-cols-1 md:grid-cols-12 gap-10 md:gap-24 items-center mb-16 md:mb-32 reveal">
            <div class="md:col-span-4 md:col-start-2 order-2 md:order-1">
                <h3 class="text-xl font-bold mb-6">This thing called UX?</h3>
                <div class="space-y-6 text-zinc-400 text-base leading-relaxed">
                    <p>When the pandemic struck, I took it as an opportunity to explore new things. I came across UX design competitions, and thought it might be fun to just give it a go (several times).</p>
                    <p>Long story short, my failures eventually turned into successes, and the rest was history.</p>
                </div>
            </div>
            <div class="md:col-span-6 order-1 md:order-2 aspect-[10/13] frame-wrapper">
                <div class="frame-card">
                    <img src="https://images.unsplash.com/photo-1528340326071-7f8e3f6848d7?q=80&w=1000" alt="Fisherman" class="frame-image">
                    <div class="edge-glow"></div>
                </div>
            </div>
        </div>
        
        <!-- Story Block 5 -->
        <div class="grid grid-cols-1 md:grid-cols-12 gap-10 md:gap-24 items-center mb-16 md:mb-32 reveal">
            <div class="md:col-span-6 aspect-[10/13] frame-wrapper">
                <div class="frame-card">
                    <img src="https://images.unsplash.com/photo-1492571350019-22de08371fd3?q=80&w=1000" alt="Cityscape" class="frame-image">
                    <div class="edge-glow"></div>
                </div>
            </div>
            <div class="md:col-span-5">
                <h3 class="text-xl font-bold mb-6">Making it all happen.</h3>
                <div class="space-y-6 text-zinc-400 text-base leading-relaxed">
                    <p>To my advantage, I was able leverage a lot of the skills and design principles I had picked up during architecture school to greatly expedite my journey of self-learning UX Design.</p>
                    <p>I loved solving problems by making stuff, and really valued visual storytelling and paying meticulous attention to precision and craftsmanship.</p>
                </div>
            </div>
        </div>

        <!-- Story Block 6 (Zig Zag End) -->
        <div class="grid grid-cols-1 md:grid-cols-12 gap-10 md:gap-24 items-center mb-16 md:mb-24 reveal">
            <div class="md:col-span-4 md:col-start-2 order-2 md:order-1">
                <h3 class="text-xl font-bold mb-6">In my spare time,</h3>
                <div class="space-y-6 text-zinc-400 text-base leading-relaxed mb-10">
                    <p>I'm probably making tweaks to my portfolio or hanging out on Discord.</p>
                    <p>Other than that, you'll find me playing basketball and volleyball, hitting the gym, gaming, and trying to get my hands on the latest tech.</p>
                </div>
                <h3 class="text-xl font-bold mb-4">Thanks for stopping by!</h3>
                <!-- Signature (Placeholder) -->
                <div class="w-24 h-12 opacity-60">
                    <svg viewBox="0 0 100 50" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M10,40 C20,10 30,10 40,30 C50,50 60,10 70,20 C80,30 90,40 85,25" />
                    </svg>
                </div>
            </div>
            <div class="md:col-span-6 order-1 md:order-2 aspect-[10/13] frame-wrapper">
                <div class="frame-card">
                    <img src="https://images.unsplash.com/photo-1511407397940-d57f68e81203?q=80&w=1000" alt="Camera Guy" class="frame-image">
                    <div class="edge-glow"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- DIVIDER -->
    <div class="px-6 md:px-16 lg:px-48 max-w-[1600px] mx-auto reveal">
        <div class="divider"></div>
    </div>

    <!-- EXPERIENCE SECTION (DRAGGABLE SLIDER) -->
    <section class="px-6 md:px-16 lg:px-48 max-w-[1600px] mx-auto mb-32 reveal select-none">
        <span class="section-label pointer-events-none">EXPERIENCE</span>
        
        <!-- Wadah Slider (Mencegah text blok ter-highlight saat di-drag) -->
        <div class="relative w-full overflow-hidden mt-12" id="exp-slider-container">
            <!-- Track Slider yang Bergeser -->
            <div class="flex transition-transform duration-500 ease-out will-change-transform" id="exp-slider-track">
                
                <!-- HALAMAN 1 (3 Baris) -->
                <div class="w-full flex-shrink-0 flex flex-col gap-12 md:gap-16 px-1">
                    <!-- Job 1 -->
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-6 md:gap-12 items-start pointer-events-none">
                        <div class="md:col-span-4">
                            <h2 class="text-3xl md:text-4xl font-bold">Discord</h2>
                        </div>
                        <div class="md:col-span-6 md:col-start-6">
                            <h3 class="text-xl md:text-2xl font-medium mb-2">Sr. Product Designer, Core Product</h3>
                            <span class="text-sm text-zinc-500 block mb-6">07/'23 - Present</span>
                            <p class="text-zinc-400 leading-relaxed text-base">
                                I'm designing the future of Discord's messaging & core product experiences, amongst other top secret projects.
                            </p>
                        </div>
                    </div>

                    <!-- Job 2 -->
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-6 md:gap-12 items-start pointer-events-none">
                        <div class="md:col-span-4">
                            <h2 class="text-3xl md:text-4xl font-bold">Google</h2>
                        </div>
                        <div class="md:col-span-6 md:col-start-6">
                            <h3 class="text-xl md:text-2xl font-medium mb-2">Interaction Designer, Stadia</h3>
                            <span class="text-sm text-zinc-500 block mb-6">06/'22 - 04/'23</span>
                            <p class="text-zinc-400 leading-relaxed text-base">
                                I owned a product that was part of Stadia's developer suite, and led design on the website for enabling Bluetooth on Stadia Controllers post-sunset.
                            </p>
                        </div>
                    </div>

                    <!-- Job 3 -->
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-6 md:gap-12 items-start pointer-events-none">
                        <div class="md:col-span-4">
                            <h2 class="text-3xl md:text-4xl font-bold">RBC</h2>
                        </div>
                        <div class="md:col-span-6 md:col-start-6">
                            <h3 class="text-xl md:text-2xl font-medium mb-2">UX Design Intern, Innovation</h3>
                            <span class="text-sm text-zinc-500 block mb-6">Summer '21</span>
                            <p class="text-zinc-400 leading-relaxed text-base">
                                I championed the redesign of the bank's internal corporate cards portal, and designed a patented wealth management network visualizer.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- HALAMAN 2 (3 Baris Tambahan) -->
                <div class="w-full flex-shrink-0 flex flex-col gap-12 md:gap-16 px-1">
                    <!-- Job 4 -->
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-6 md:gap-12 items-start pointer-events-none">
                        <div class="md:col-span-4">
                            <h2 class="text-3xl md:text-4xl font-bold">Apple</h2>
                        </div>
                        <div class="md:col-span-6 md:col-start-6">
                            <h3 class="text-xl md:text-2xl font-medium mb-2">Product Design Intern</h3>
                            <span class="text-sm text-zinc-500 block mb-6">Fall '20</span>
                            <p class="text-zinc-400 leading-relaxed text-base">
                                Contributed to the design system and crafted internal tools used by thousands of engineers across the globe.
                            </p>
                        </div>
                    </div>

                    <!-- Job 5 -->
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-6 md:gap-12 items-start pointer-events-none">
                        <div class="md:col-span-4">
                            <h2 class="text-3xl md:text-4xl font-bold">Spotify</h2>
                        </div>
                        <div class="md:col-span-6 md:col-start-6">
                            <h3 class="text-xl md:text-2xl font-medium mb-2">UX Researcher</h3>
                            <span class="text-sm text-zinc-500 block mb-6">Spring '20</span>
                            <p class="text-zinc-400 leading-relaxed text-base">
                                Conducted A/B testing and qualitative research to improve user retention on the mobile application.
                            </p>
                        </div>
                    </div>

                    <!-- Job 6 -->
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-6 md:gap-12 items-start pointer-events-none">
                        <div class="md:col-span-4">
                            <h2 class="text-3xl md:text-4xl font-bold">Freelance</h2>
                        </div>
                        <div class="md:col-span-6 md:col-start-6">
                            <h3 class="text-xl md:text-2xl font-medium mb-2">UI/UX Designer</h3>
                            <span class="text-sm text-zinc-500 block mb-6">2018 - 2019</span>
                            <p class="text-zinc-400 leading-relaxed text-base">
                                Worked with various startups to define their digital identity from zero to one.
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Pagination Dots -->
        <div class="flex justify-center gap-3 mt-12 md:mt-16" id="exp-dots">
            <button class="exp-dot w-8 h-2 rounded-full bg-white transition-all duration-300 pointer-events-auto" data-index="0"></button>
            <button class="exp-dot w-2 h-2 rounded-full bg-white/20 hover:bg-white/50 transition-all duration-300 pointer-events-auto" data-index="1"></button>
        </div>
    </section>

    <!-- DIVIDER -->
    <div class="px-6 md:px-16 lg:px-48 max-w-[1600px] mx-auto reveal">
        <div class="divider"></div>
    </div>

    <!-- FRIENDS SECTION -->
    <section class="px-6 md:px-16 lg:px-48 max-w-[1600px] mx-auto mb-32 reveal">
        <span class="section-label">FRIENDS</span>
        
        <!-- Hapus class "-mx-6 px-6 md:mx-0 md:px-0" agar marginnya selaras rata kiri dengan section -->
        <div class="friends-grid overflow-x-auto md:overflow-visible snap-x snap-mandatory md:snap-none gap-y-10 gap-x-6 md:gap-y-16 md:gap-x-8 mt-12 pb-8 md:pb-0 hide-scrollbar">
            
            <!-- Friend Item -->
            <div class="snap-start md:snap-align-none w-full">
                <h3 class="text-xl font-bold mb-2">Xavier Woo</h3>
                <p class="text-zinc-400 text-sm mb-4">Founding Designer — Blockus</p>
                <a href="#" class="text-zinc-500 hover:text-white transition-colors text-sm flex items-center gap-1 w-fit">
                    xavierw.ca <span class="text-xs">↗</span>
                </a>
            </div>
            
            <div class="snap-start md:snap-align-none w-full">
                <h3 class="text-xl font-bold mb-2">Allyson Arrogante</h3>
                <p class="text-zinc-400 text-sm mb-4">Designer — Disney</p>
                <a href="#" class="text-zinc-500 hover:text-white transition-colors text-sm flex items-center gap-1 w-fit">
                    allydsgn.com <span class="text-xs">↗</span>
                </a>
            </div>

            <div class="snap-start md:snap-align-none w-full">
                <h3 class="text-xl font-bold mb-2">James Chu</h3>
                <p class="text-zinc-400 text-sm mb-4">Designer — Apple</p>
                <a href="#" class="text-zinc-500 hover:text-white transition-colors text-sm flex items-center gap-1 w-fit">
                    jc.works <span class="text-xs">↗</span>
                </a>
            </div>

            <div class="snap-start md:snap-align-none w-full">
                <h3 class="text-xl font-bold mb-2">Yichen He</h3>
                <p class="text-zinc-400 text-sm mb-4">Product Designer — CrowdStrike</p>
                <a href="#" class="text-zinc-500 hover:text-white transition-colors text-sm flex items-center gap-1 w-fit">
                    yichenhe.com <span class="text-xs">↗</span>
                </a>
            </div>

            <div class="snap-start md:snap-align-none w-full">
                <h3 class="text-xl font-bold mb-2">Ben Ellsworth</h3>
                <p class="text-zinc-400 text-sm mb-4">Senior Product Designer — Upwork</p>
                <a href="#" class="text-zinc-500 hover:text-white transition-colors text-sm flex items-center gap-1 w-fit">
                    bellsworth.com <span class="text-xs">↗</span>
                </a>
            </div>

            <div class="snap-start md:snap-align-none w-full">
                <h3 class="text-xl font-bold mb-2">Jordan Winick</h3>
                <p class="text-zinc-400 text-sm mb-4">Sr. Director of Product Design — Recurly</p>
                <a href="#" class="text-zinc-500 hover:text-white transition-colors text-sm flex items-center gap-1 w-fit">
                    jordanwinick.com <span class="text-xs">↗</span>
                </a>
            </div>
            
            <div class="snap-start md:snap-align-none w-full">
                <h3 class="text-xl font-bold mb-2">Evan Quan</h3>
                <p class="text-zinc-400 text-sm mb-4">UX Designer — GoDaddy</p>
                <a href="#" class="text-zinc-500 hover:text-white transition-colors text-sm flex items-center gap-1 w-fit">
                    in/evqu <span class="text-xs">↗</span>
                </a>
            </div>

            <div class="snap-start md:snap-align-none w-full">
                <h3 class="text-xl font-bold mb-2">Shawn</h3>
                <p class="text-zinc-400 text-sm mb-4">Sr. Staff Product Designer — Discord</p>
                <a href="#" class="text-zinc-500 hover:text-white transition-colors text-sm flex items-center gap-1 w-fit">
                    designbyroka.com <span class="text-xs">↗</span>
                </a>
            </div>

            <div class="snap-start md:snap-align-none w-full">
                <h3 class="text-xl font-bold mb-2">John Avent</h3>
                <p class="text-zinc-400 text-sm mb-4">Staff Product Designer — Discord</p>
                <a href="#" class="text-zinc-500 hover:text-white transition-colors text-sm flex items-center gap-1 w-fit">
                    johnnn.design <span class="text-xs">↗</span>
                </a>
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
        const totalPages = 2; // Karena kita punya 2 halaman data
        
        if (expTrack && expContainer) {

            // Fungsi memperbarui UI
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

            // Fungsi Drag Event
            const getPositionX = (event) => {
                return event.type.includes('mouse') ? event.pageX : event.touches[0].clientX;
            }

            const dragStart = (e) => {
                isDragging = true;
                startPos = getPositionX(e);
                expTrack.style.transition = 'none'; // Hapus delay animasi agar menempel di kursor
            }

            const drag = (e) => {
                if (!isDragging) return;
                e.preventDefault(); // Mencegah highlight teks yang tidak disengaja
                const currentPosition = getPositionX(e);
                const diff = currentPosition - startPos;
                currentTranslate = prevTranslate + diff;
                expTrack.style.transform = `translateX(${currentTranslate}px)`;
            }

            const dragEnd = () => {
                if (!isDragging) return;
                isDragging = false;
                
                const movedBy = currentTranslate - prevTranslate;
                
                // Jika digeser lebih dari 100px ke kiri atau kanan, ganti halaman
                if (movedBy < -100 && currentIndex < totalPages - 1) {
                    currentIndex += 1;
                } else if (movedBy > 100 && currentIndex > 0) {
                    currentIndex -= 1;
                }
                
                setPositionByIndex(); // Kembali nge-snap ke tempat semestinya
            }

            // Pasang event listener ke Container
            expContainer.addEventListener('mousedown', dragStart);
            expContainer.addEventListener('touchstart', dragStart, {passive: true});
            
            // Mouse gerak & up dipasang di window agar tidak error saat kursor keluar batas kotak
            window.addEventListener('mousemove', drag);
            window.addEventListener('touchmove', drag, {passive: false});
            window.addEventListener('mouseup', dragEnd);
            window.addEventListener('touchend', dragEnd);

            // Jika jendela di-resize, atur ulang lebarnya agar tidak rusak
            window.addEventListener('resize', setPositionByIndex);

            // Klik langsung di titik (dots) untuk pindah halaman
            dots.forEach(dot => {
                dot.addEventListener('click', (e) => {
                    currentIndex = parseInt(e.target.getAttribute('data-index'));
                    setPositionByIndex();
                });
            });
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