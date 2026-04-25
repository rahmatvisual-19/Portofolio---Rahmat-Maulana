@extends('layouts.app')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Albert+Sans:ital,wght@0,100..900;1,100..900&family=JetBrains+Mono:ital,wght@0,100..800;1,100..800&display=swap');

    :root {
        --primary: #ffffff;
        --bg: #050505;
        --accent-blue: rgba(59, 130, 246, 1);
        --accent-blue-glow: rgba(59, 130, 246, 0.5);
    }

    .font-albert { font-family: 'Albert Sans', sans-serif; }
    .font-jetbrains { font-family: 'JetBrains Mono', monospace; }

    /* Sembunyikan kursor asli */
    html, body, a, button {
        cursor: none !important;
    }

    /* Override cursor Tailwind agar tidak menimpa custom cursor */
    .cursor-pointer, .cursor-grab, .cursor-grabbing,
    [class*="cursor-"] {
        cursor: none !important;
    }

    /* --- Dasar Latar Belakang (Gelap tanpa warna-warni berlebih) --- */
    .bg-main {
        background-color: var(--bg);
        background-image: radial-gradient(ellipse at top, rgba(255,255,255,0.08) 0%, transparent 60%);
        position: fixed;
        inset: 0;
        z-index: -2;
    }

    /* ===== Minecraft Cursor & Effects ===== */
    #minecraft-cursor { position: fixed; top: 0; left: 0; width: 44px; height: 44px; background-image: url('https://cur.cursors-4u.net/games/gam-13/gam1282.png'); background-size: contain; background-repeat: no-repeat; pointer-events: none; z-index: 2147483647; transform: rotate(-15deg); filter: drop-shadow(0 0 8px var(--accent-blue-glow)); }
    #cursor-glow { position: fixed; width: 160px; height: 160px; background: radial-gradient(circle, rgba(59, 130, 246, 0.3) 0%, rgba(139, 92, 246, 0.1) 40%, transparent 75%); border-radius: 50%; pointer-events: none; z-index: 2147483646; transform: translate(-50%, -50%); transition: width 0.4s ease, height 0.4s ease; }
    .particle { position: fixed; background: radial-gradient(circle, #fff 0%, var(--accent-blue) 60%, transparent 100%); border-radius: 50%; pointer-events: none; z-index: 2147483645; box-shadow: 0 0 10px rgba(59, 130, 246, 0.8); animation: particleLife 0.8s forwards ease-out; }
    @keyframes particleLife { 0% { opacity: 1; transform: scale(1); } 100% { opacity: 0; transform: scale(0) translateY(20px); } }

    /* --- Premium Blur Reveal Animasi --- */
    html { scroll-behavior: smooth; }
    
    .reveal { 
        opacity: 0; 
        filter: blur(12px);
        transform: translateY(30px) scale(0.95); 
        transition: all 1s cubic-bezier(0.16, 1, 0.3, 1); 
        will-change: opacity, transform, filter; 
    }
    .reveal.active { 
        opacity: 1; 
        filter: blur(0px);
        transform: translateY(0) scale(1); 
    }

    /* --- Animasi Stagger Untuk Bento Items --- */
    .stagger-item {
        opacity: 0;
        transform: translateY(30px) scale(0.95);
        transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .stagger-item.active {
        opacity: 1;
        transform: translateY(0) scale(1);
    }

    /* --- Gallery Layout Helpers --- */
    .hide-scrollbar::-webkit-scrollbar { display: none; }
    .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

    /* Bento Grid System: Meniru struktur grid-flow-col dari Tailwind React */
    .bento-grid {
        display: grid;
        grid-template-rows: repeat(2, 280px);
        grid-auto-flow: column;
        grid-auto-columns: minmax(18rem, 1fr);
        gap: 16px;
    }
    
    @media (max-width: 768px) {
        .bento-grid {
            grid-template-rows: repeat(2, 220px);
            grid-auto-columns: minmax(15rem, 1fr);
        }
    }

    /* ===== Footer Section ===== */
    .footer-section { padding: 100px 8vw 60px; border-top: 1px solid rgba(255,255,255,0.08); background: #030303; position: relative; z-index: 10; }
    @media (min-width: 768px) { .footer-section { padding: 100px 15vw 60px; } }
</style>

<!-- Latar Belakang Hitam -->
<div class="bg-main"></div>

<!-- Dotted Surface Background 3D (Lapisan paling belakang z-[-1]) -->
<div id="dotted-surface-container" class="pointer-events-none fixed inset-0 z-[-1] opacity-70"></div>

<!-- Custom Cursor & Aura -->
<div id="cursor-glow"></div>
<div id="minecraft-cursor"></div>

<div class="relative z-10 text-white selection:bg-white selection:text-black font-albert min-h-screen flex flex-col">
    
    <!-- HEADER NAVBAR -->
    @include('partials.navbar')

    <!-- BENTO GALLERY SECTION -->
    <main class="flex-grow pt-32 md:pt-48 pb-24 overflow-hidden relative">
        
        <!-- Header Text -->
        <div class="container mx-auto px-6 md:px-12 text-center reveal mb-12">
            <h1 class="text-4xl md:text-[3.5rem] font-bold tracking-tight text-white mb-4">
                Curated Moments
            </h1>
            <p class="mx-auto max-w-2xl text-[17px] text-zinc-400 leading-relaxed font-albert">
                A collection of stunning landscapes. Drag to explore, click to expand.
            </p>
        </div>

        <!-- Draggable Gallery Container -->
        <div class="relative w-full cursor-grab active:cursor-grabbing reveal" id="gallery-drag-container">
            
            <!-- Area Scroll Horizontal -->
            <div id="gallery-scroll-area" class="w-full overflow-x-auto hide-scrollbar select-none pb-12 pt-4 px-4 md:px-8">
                <div class="w-max bento-grid mx-auto">
                    
                    @forelse($images as $index => $item)
                    @php
                        // Pola span bento otomatis berdasarkan posisi (mengulang setiap 6 item)
                        $spanPatterns = [
                            'md:col-span-2 md:row-span-2',
                            'md:row-span-1',
                            'md:row-span-1',
                            'md:row-span-2',
                            'md:row-span-1',
                            'md:col-span-2 md:row-span-1',
                        ];
                        $span = $spanPatterns[$index % 6];
                    @endphp
                        <!-- Bento Item Card -->
                        <div class="stagger-item group relative flex h-full w-full min-w-[15rem] cursor-pointer items-end overflow-hidden rounded-xl border border-white/10 bg-[#111] p-4 shadow-sm transition-all duration-500 ease-out hover:shadow-[0_8px_30px_rgba(0,0,0,0.5)] hover:border-white/30 {{ $span }}"
                             onclick="openGalleryModal('{{ asset('storage/' . $item->image_path) }}')"
                             style="transition-delay: {{ $index * 100 }}ms;">

                            <!-- Image Background -->
                            <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->title }}" class="absolute inset-0 h-full w-full object-cover transition-transform duration-700 ease-[cubic-bezier(0.16,1,0.3,1)] group-hover:scale-105 pointer-events-none" draggable="false" />

                            <!-- Gradient Overlay -->
                            <div class="pointer-events-none absolute inset-0 bg-gradient-to-t from-black/90 via-black/30 to-transparent opacity-0 transition-opacity duration-500 group-hover:opacity-100"></div>

                            <!-- Text Details (Reveal on Hover) -->
                            <div class="relative z-10 translate-y-4 opacity-0 transition-all duration-500 ease-[cubic-bezier(0.16,1,0.3,1)] group-hover:translate-y-0 group-hover:opacity-100 w-full pointer-events-none">
                                <h3 class="text-xl font-bold text-white tracking-tight">{{ $item->title }}</h3>
                                <p class="mt-1 text-sm text-white/80 font-medium">{{ $item->description }}</p>
                            </div>

                        </div>
                    @empty
                        <div class="stagger-item flex items-center justify-center min-w-[15rem] h-full rounded-xl border border-dashed border-white/10 bg-[#111] p-8 text-zinc-600 text-sm">
                            Belum ada foto. Tambahkan melalui admin panel.
                        </div>
                    @endforelse

                </div>
            </div>
            
        </div>

    </main>

    <!-- FOOTER SECTION -->
    @include('partials.footer')
</div>

<!-- ==========================================
     MODAL LIGHTBOX (Zoom Image)
     ========================================== -->
<div id="gallery-modal" class="fixed inset-0 z-[99999] flex items-center justify-center bg-black/80 backdrop-blur-md opacity-0 pointer-events-none transition-opacity duration-500" onclick="closeGalleryModal()">
    
    <!-- Tombol Close -->
    <button class="absolute top-6 right-6 md:top-8 md:right-8 text-white/80 hover:text-white transition-colors bg-white/5 hover:bg-white/10 p-3 rounded-full z-50">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
    </button>

    <!-- Konten Modal Gambar -->
    <div id="gallery-modal-content" class="relative w-full max-w-5xl p-4 transform scale-90 translate-y-10 transition-all duration-500 ease-[cubic-bezier(0.16,1,0.3,1)]" onclick="event.stopPropagation()">
        <img id="gallery-modal-img" src="" alt="Expanded View" class="w-full h-auto max-h-[90vh] object-contain rounded-xl shadow-2xl" draggable="false" />
    </div>
</div>

<!-- Tambahkan library Three.js dari CDN untuk Dotted Surface -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r134/three.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', () => {

        // =============================================
        // KURSOR MINECRAFT & GLOW
        // =============================================
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
            particle.style.background = 'radial-gradient(circle, #fff 0%, rgba(59, 130, 246, 0.8) 60%, transparent 100%)';
            particle.style.left = (x + (Math.random() - 0.5) * 12) + 'px'; 
            particle.style.top = (y + (Math.random() - 0.5) * 12) + 'px';
            document.body.appendChild(particle);
            setTimeout(() => particle.remove(), 800);
        }

        const animateCursor = () => {
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
            requestAnimationFrame(animateCursor);
        };
        animateCursor();

        // =============================================
        // REVEAL OBSERVER (Animasi Scroll & Stagger)
        // =============================================
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => { 
                if (entry.isIntersecting) {
                    entry.target.classList.add('active');
                    
                    // Trigger animasi bento items saat container masuk viewport
                    const staggers = entry.target.querySelectorAll('.stagger-item');
                    if(staggers.length > 0) {
                        staggers.forEach((stagger) => stagger.classList.add('active'));
                    }
                } 
            });
        }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });
        
        document.querySelectorAll('.reveal, #gallery-drag-container').forEach(el => observer.observe(el));

        // Pemicu otomatis jika ada elemen di atas lipatan layar
        setTimeout(() => {
            document.querySelectorAll('.stagger-item').forEach((el) => el.classList.add('active'));
        }, 400); 

        // =============================================
        // DRAG TO SCROLL LOGIC
        // =============================================
        const scrollArea = document.getElementById('gallery-scroll-area');
        const container = document.getElementById('gallery-drag-container');
        
        if (scrollArea && container) {
            let isDown = false;
            let startX;
            let scrollLeft;

            container.addEventListener('mousedown', (e) => {
                isDown = true;
                container.classList.add('cursor-grabbing');
                container.classList.remove('cursor-grab');
                startX = e.pageX - scrollArea.offsetLeft;
                scrollLeft = scrollArea.scrollLeft;
            });
            
            container.addEventListener('mouseleave', () => {
                isDown = false;
                container.classList.remove('cursor-grabbing');
                container.classList.add('cursor-grab');
            });
            
            container.addEventListener('mouseup', () => {
                isDown = false;
                container.classList.remove('cursor-grabbing');
                container.classList.add('cursor-grab');
            });
            
            container.addEventListener('mousemove', (e) => {
                if (!isDown) return;
                e.preventDefault();
                const x = e.pageX - scrollArea.offsetLeft;
                const walk = (x - startX) * 2; // Mengalikan 2 agar lebih cepat (sensitivity)
                scrollArea.scrollLeft = scrollLeft - walk;
            });
        }
    });

    // =============================================
    // MODAL LIGHTBOX LOGIC
    // =============================================
    const modal = document.getElementById('gallery-modal');
    const modalContent = document.getElementById('gallery-modal-content');
    const modalImg = document.getElementById('gallery-modal-img');

    window.openGalleryModal = function(src) {
        modalImg.src = src;

        // Munculkan Modal Backdrop
        modal.classList.remove('opacity-0', 'pointer-events-none');
        
        // Animasikan Modal Box Scale-up (mirip Framer Motion spring)
        setTimeout(() => {
            modalContent.classList.remove('scale-90', 'translate-y-10');
            modalContent.classList.add('scale-100', 'translate-y-0');
        }, 50);
    };

    window.closeGalleryModal = function() {
        // Animasikan Modal Box Scale-down
        modalContent.classList.add('scale-90', 'translate-y-10');
        modalContent.classList.remove('scale-100', 'translate-y-0');
        
        // Hilangkan Backdrop
        setTimeout(() => {
            modal.classList.add('opacity-0', 'pointer-events-none');
            setTimeout(() => { modalImg.src = ''; }, 300); // Bersihkan cache gambar
        }, 300);
    };

    // Tombol ESC untuk tutup modal
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && !modal.classList.contains('opacity-0')) {
            closeGalleryModal();
        }
    });

    // =============================================
    // THREE.JS DOTTED SURFACE BACKGROUND
    // =============================================
    (function initDottedSurface() {
        const container = document.getElementById('dotted-surface-container');
        if (!container || typeof THREE === 'undefined') return;

        const SEPARATION = 150;
        const AMOUNTX = 40;
        const AMOUNTY = 60;

        const scene = new THREE.Scene();
        // Fog disesuaikan agar menyatu dengan background gelap
        scene.fog = new THREE.Fog(0x050505, 2000, 10000); 

        const camera = new THREE.PerspectiveCamera(60, window.innerWidth / window.innerHeight, 1, 10000);
        camera.position.set(0, 355, 1220);

        const renderer = new THREE.WebGLRenderer({ alpha: true, antialias: true });
        renderer.setPixelRatio(window.devicePixelRatio);
        renderer.setSize(window.innerWidth, window.innerHeight);
        renderer.setClearColor(0x000000, 0); // Transparan agar div bg-main terlihat
        container.appendChild(renderer.domElement);

        const positions = [];
        const colors = [];

        // Generate Partikel
        for (let ix = 0; ix < AMOUNTX; ix++) {
            for (let iy = 0; iy < AMOUNTY; iy++) {
                positions.push(
                    ix * SEPARATION - (AMOUNTX * SEPARATION) / 2,
                    0,
                    iy * SEPARATION - (AMOUNTY * SEPARATION) / 2
                );
                // RGB Putih/Abu-abu (0-1 range untuk BufferAttribute Float32)
                colors.push(0.78, 0.78, 0.78);
            }
        }

        const geometry = new THREE.BufferGeometry();
        geometry.setAttribute('position', new THREE.Float32BufferAttribute(positions, 3));
        geometry.setAttribute('color', new THREE.Float32BufferAttribute(colors, 3));

        const material = new THREE.PointsMaterial({
            size: 8, // Set setara dengan React
            vertexColors: true,
            transparent: true,
            opacity: 0.6,
            sizeAttenuation: true,
        });

        const points = new THREE.Points(geometry, material);
        scene.add(points);

        let count = 0;

        function animateDotted() {
            requestAnimationFrame(animateDotted);

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
            count += 0.1; // Kecepatan gelombang
        }

        animateDotted();

        window.addEventListener('resize', () => {
            camera.aspect = window.innerWidth / window.innerHeight;
            camera.updateProjectionMatrix();
            renderer.setSize(window.innerWidth, window.innerHeight);
        });
    })();
</script>
@endsection