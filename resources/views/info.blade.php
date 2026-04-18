@extends('layouts.app')

@section('content')
<!-- 
    INFO PAGE - PERRY WANG INSPIRED
    - Layout gambar & teks bergantian (zig-zag)
    - List Experience & Friends
    - Efek Frame pada gambar
-->

<style>
    :root {
        --primary: #ffffff;
        --bg: #030303;
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

    /* --- Reveal --- */
    html { scroll-behavior: smooth; }
    .reveal { opacity: 0; transform: translateY(30px); transition: all 1s cubic-bezier(0.16, 1, 0.3, 1); }
    .reveal.active { opacity: 1; transform: translateY(0); }

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
    .section-label::before {
        content: '';
        display: block;
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background-color: rgba(255, 255, 255, 0.8);
    }
    
    .divider {
        height: 1px;
        background: linear-gradient(90deg, rgba(255,255,255,0.05) 0%, rgba(255,255,255,0.1) 50%, rgba(255,255,255,0.05) 100%);
        width: 100%;
        margin: 6rem 0;
    }

    /* Layout Zig-Zag Image (Efek Frame) */
    .story-img-container {
        border-radius: 24px;
        padding: 6px; /* Memberikan ruang antara gambar dan border luar */
        border: 1px solid rgba(255, 255, 255, 0.15); /* Garis bingkai luar */
        background: #080808; /* Warna latar belakang bingkai */
        box-shadow: 0 20px 40px -10px rgba(0,0,0,0.6); /* Sedikit bayangan untuk kedalaman */
    }

    .story-img-container img {
        border-radius: 18px; /* Sudut gambar sedikit lebih kecil dari bingkai luar (24 - 6 = 18) */
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* ===== Footer Section ===== */
    .footer-section { padding: 80px 8vw 60px; background: #030303; position: relative; z-index: 10; border-top: 1px solid var(--glass-border);}
    @media (min-width: 768px) { .footer-section { padding: 100px 15vw 60px; } }
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

    <!-- HERO ABOUT SECTION -->
    <section class="pt-40 md:pt-48 px-6 md:px-16 lg:px-48 max-w-[1600px] mx-auto reveal">
        <div class="mb-16 md:mb-24">
            <span class="section-label">ABOUT ME</span>
            <h1 class="text-4xl md:text-5xl lg:text-[4.5rem] font-medium leading-[1.1] tracking-tight max-w-4xl">
                I'm passionate about creating beautiful products that <span class="italic text-zinc-400 font-serif">empower people.</span>
            </h1>
        </div>

        <!-- Story Block 1 -->
        <div class="grid grid-cols-1 md:grid-cols-12 gap-10 md:gap-24 items-center mb-16 md:mb-32">
            <div class="md:col-span-6 story-img-container h-[400px] md:h-[600px]">
                <img src="https://images.unsplash.com/photo-1493246507139-91e8fad9978e?q=80&w=1000" alt="Mountain View">
            </div>
            <div class="md:col-span-6">
                <p class="text-xl md:text-2xl font-medium leading-relaxed max-w-md">
                    This is my story — alongside some flicks from my recent trip to Japan.
                </p>
            </div>
        </div>

        <!-- Story Block 2 (Zig-Zag) -->
        <div class="grid grid-cols-1 md:grid-cols-12 gap-10 md:gap-24 items-center mb-16 md:mb-32">
            <!-- Teks di kiri pada Desktop, ditukar posisinya -->
            <div class="md:col-span-5 md:col-start-2 order-2 md:order-1">
                <h3 class="text-xl font-bold mb-6">My background in Architecture.</h3>
                <div class="space-y-6 text-zinc-400 text-base leading-relaxed">
                    <p>In June of 2022, I graduated from architecture school at the University of Toronto. There, I became obsessed with architectural visualization.</p>
                    <p>I was deeply fascinated in the concepts of modularity and adaptability — how our built environment could organically evolve in conjunction with humanity.</p>
                </div>
            </div>
            <div class="md:col-span-6 order-1 md:order-2 story-img-container h-[400px] md:h-[600px]">
                <img src="https://images.unsplash.com/photo-1490806843957-31f4c9a91c65?q=80&w=1000" alt="Japan Street">
            </div>
        </div>

        <!-- Story Block 3 -->
        <div class="grid grid-cols-1 md:grid-cols-12 gap-10 md:gap-24 items-center mb-16 md:mb-32">
            <div class="md:col-span-6 md:col-start-2 story-img-container h-[500px] md:h-[700px]">
                <img src="https://images.unsplash.com/photo-1542051812-df29141beeb7?q=80&w=1000" alt="Playground">
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
        <div class="grid grid-cols-1 md:grid-cols-12 gap-10 md:gap-24 items-center mb-16 md:mb-32">
            <div class="md:col-span-4 md:col-start-2 order-2 md:order-1">
                <h3 class="text-xl font-bold mb-6">This thing called UX?</h3>
                <div class="space-y-6 text-zinc-400 text-base leading-relaxed">
                    <p>When the pandemic struck, I took it as an opportunity to explore new things. I came across UX design competitions, and thought it might be fun to just give it a go (several times).</p>
                    <p>Long story short, my failures eventually turned into successes, and the rest was history.</p>
                </div>
            </div>
            <div class="md:col-span-6 order-1 md:order-2 story-img-container h-[400px] md:h-[600px]">
                <img src="https://images.unsplash.com/photo-1528340326071-7f8e3f6848d7?q=80&w=1000" alt="Fisherman">
            </div>
        </div>
        
        <!-- Story Block 5 -->
        <div class="grid grid-cols-1 md:grid-cols-12 gap-10 md:gap-24 items-center mb-16 md:mb-32">
            <div class="md:col-span-6 story-img-container h-[500px] md:h-[700px]">
                <img src="https://images.unsplash.com/photo-1492571350019-22de08371fd3?q=80&w=1000" alt="Cityscape">
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
        <div class="grid grid-cols-1 md:grid-cols-12 gap-10 md:gap-24 items-center mb-16 md:mb-24">
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
            <div class="md:col-span-6 order-1 md:order-2 story-img-container h-[400px] md:h-[600px]">
                <img src="https://images.unsplash.com/photo-1511407397940-d57f68e81203?q=80&w=1000" alt="Camera Guy">
            </div>
        </div>
    </section>

    <!-- DIVIDER -->
    <div class="px-6 md:px-16 lg:px-48 max-w-[1600px] mx-auto reveal">
        <div class="divider"></div>
    </div>

    <!-- EXPERIENCE SECTION -->
    <section class="px-6 md:px-16 lg:px-48 max-w-[1600px] mx-auto mb-32 reveal">
        <span class="section-label">EXPERIENCE</span>
        
        <div class="flex flex-col gap-16 md:gap-24 mt-12">
            <!-- Job 1 -->
            <div class="grid grid-cols-1 md:grid-cols-12 gap-6 md:gap-12 items-start">
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
            <div class="grid grid-cols-1 md:grid-cols-12 gap-6 md:gap-12 items-start">
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
            <div class="grid grid-cols-1 md:grid-cols-12 gap-6 md:gap-12 items-start">
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
    </section>

    <!-- DIVIDER -->
    <div class="px-6 md:px-16 lg:px-48 max-w-[1600px] mx-auto reveal">
        <div class="divider"></div>
    </div>

    <!-- FRIENDS SECTION -->
    <section class="px-6 md:px-16 lg:px-48 max-w-[1600px] mx-auto mb-32 reveal">
        <span class="section-label">FRIENDS</span>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-y-16 gap-x-8 mt-12">
            
            <!-- Friend Item -->
            <div>
                <h3 class="text-xl font-bold mb-2">Xavier Woo</h3>
                <p class="text-zinc-400 text-sm mb-4">Founding Designer — Blockus</p>
                <a href="#" class="text-zinc-500 hover:text-white transition-colors text-sm flex items-center gap-1 w-fit">
                    xavierw.ca <span class="text-xs">↗</span>
                </a>
            </div>
            
            <div>
                <h3 class="text-xl font-bold mb-2">Allyson Arrogante</h3>
                <p class="text-zinc-400 text-sm mb-4">Designer — Disney</p>
                <a href="#" class="text-zinc-500 hover:text-white transition-colors text-sm flex items-center gap-1 w-fit">
                    allydsgn.com <span class="text-xs">↗</span>
                </a>
            </div>

            <div>
                <h3 class="text-xl font-bold mb-2">James Chu</h3>
                <p class="text-zinc-400 text-sm mb-4">Designer — Apple</p>
                <a href="#" class="text-zinc-500 hover:text-white transition-colors text-sm flex items-center gap-1 w-fit">
                    jc.works <span class="text-xs">↗</span>
                </a>
            </div>

            <div>
                <h3 class="text-xl font-bold mb-2">Yichen He</h3>
                <p class="text-zinc-400 text-sm mb-4">Product Designer — CrowdStrike</p>
                <a href="#" class="text-zinc-500 hover:text-white transition-colors text-sm flex items-center gap-1 w-fit">
                    yichenhe.com <span class="text-xs">↗</span>
                </a>
            </div>

            <div>
                <h3 class="text-xl font-bold mb-2">Ben Ellsworth</h3>
                <p class="text-zinc-400 text-sm mb-4">Senior Product Designer — Upwork</p>
                <a href="#" class="text-zinc-500 hover:text-white transition-colors text-sm flex items-center gap-1 w-fit">
                    bellsworth.com <span class="text-xs">↗</span>
                </a>
            </div>

            <div>
                <h3 class="text-xl font-bold mb-2">Jordan Winick</h3>
                <p class="text-zinc-400 text-sm mb-4">Sr. Director of Product Design — Recurly</p>
                <a href="#" class="text-zinc-500 hover:text-white transition-colors text-sm flex items-center gap-1 w-fit">
                    jordanwinick.com <span class="text-xs">↗</span>
                </a>
            </div>
            
            <div>
                <h3 class="text-xl font-bold mb-2">Evan Quan</h3>
                <p class="text-zinc-400 text-sm mb-4">UX Designer — GoDaddy</p>
                <a href="#" class="text-zinc-500 hover:text-white transition-colors text-sm flex items-center gap-1 w-fit">
                    in/evqu <span class="text-xs">↗</span>
                </a>
            </div>

            <div>
                <h3 class="text-xl font-bold mb-2">Shawn</h3>
                <p class="text-zinc-400 text-sm mb-4">Sr. Staff Product Designer — Discord</p>
                <a href="#" class="text-zinc-500 hover:text-white transition-colors text-sm flex items-center gap-1 w-fit">
                    designbyroka.com <span class="text-xs">↗</span>
                </a>
            </div>

            <div>
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

        // Reveal Observer
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => { if (entry.isIntersecting) entry.target.classList.add('active'); });
        }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });
        document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
    });
</script>
@endsection