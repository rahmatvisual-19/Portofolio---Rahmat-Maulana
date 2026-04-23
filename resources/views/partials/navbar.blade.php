<!-- HEADER NAVBAR -->
<style>
    .nav-pill { position: relative; }
    .nav-pill-indicator {
        position: absolute;
        top: 0.25rem;
        height: calc(100% - 0.5rem);
        left: 0;
        width: 0;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 999px;
        /* Menggunakan cubic-bezier untuk pergeseran animasi yang sangat smooth dan elegan */
        transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
        pointer-events: none;
        z-index: 0;
    }

    /* --- Efek Tirai Transisi Halaman --- */
    #page-transition-overlay {
        position: fixed;
        inset: 0;
        background-color: #171717; /* Sesuai warna background tema gelap kita */
        z-index: 999999;
        pointer-events: none;
        transition: opacity 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        opacity: 1; /* Saat memuat pertama kali, layar sengaja digelapkan agar tidak ada flicker */
    }
</style>

<!-- Tirai Gelap Transisi -->
<div id="page-transition-overlay"></div>

<!-- Padding diubah dari px-6 md:px-12 lg:px-24 menjadi px-4 md:px-8 lg:px-8 agar menempel ke pinggir -->
<header id="navbar-header" class="fixed top-0 w-full z-50 px-4 md:px-8 lg:px-8 py-6 md:py-8 pointer-events-none">
    <div class="w-full max-w-screen-2xl mx-auto flex items-center justify-between pointer-events-auto relative">
        
        <!-- Logo Minimalis -->
        <div class="hidden md:flex flex-col">
            <a href="/" class="text-lg font-semibold tracking-tight text-white hover:text-gray-200 transition-colors leading-tight">Rahmat Maulana</a>
            <span class="text-[13px] text-zinc-400 font-medium">The Maestro</span>
        </div>

        <!-- Tengah: Kapsul Navigasi Minimalis (Hanya Bergeser Saat Diklik) -->
        <div class="flex items-center gap-6 md:absolute md:left-1/2 md:-translate-x-1/2">
            <nav class="nav-pill flex items-center p-1 rounded-full bg-white/[0.04] border border-white/[0.08] backdrop-blur-md">
                <span id="nav-pill-indicator" class="nav-pill-indicator"></span>
                <!-- Background statis (bg-white/10) dihapus agar digantikan dengan indicator dinamis -->
                <a href="{{ route('portofolio') }}" class="relative z-10 px-6 py-2 rounded-full text-[13px] font-medium transition-colors duration-300 {{ request()->routeIs('portofolio') ? 'active text-white' : 'text-zinc-400 hover:text-white' }}">
                    Work
                </a>
                <a href="{{ route('info') }}" class="relative z-10 px-6 py-2 rounded-full text-[13px] font-medium transition-colors duration-300 {{ request()->routeIs('info') ? 'active text-white' : 'text-zinc-400 hover:text-white' }}">
                    Info
                </a>
            </nav>
        </div>

        <!-- Kanan: Link Desktop & Tombol @ Dropdown -->
        <div class="relative flex items-center gap-6">
            <!-- Link Desktop dengan Efek Garis & Glow -->
            <div class="hidden md:flex gap-8">
                <a href="https://linkedin.com" target="_blank" class="group relative text-[13px] font-medium text-zinc-300 hover:text-white transition-all duration-300 flex items-center gap-1.5 hover:drop-shadow-[0_0_10px_rgba(255,255,255,0.6)]">
                    LinkedIn <span class="font-light text-zinc-500 group-hover:text-white transition-colors duration-300 text-sm">↗</span>
                    <!-- Garis Bawah Dinamis -->
                    <span class="absolute -bottom-1 left-0 w-0 h-[1.5px] bg-white transition-all duration-300 group-hover:w-full group-hover:shadow-[0_0_8px_rgba(255,255,255,0.9)] rounded-full"></span>
                </a>
                <a href="/resume.pdf" download class="group relative text-[13px] font-medium text-zinc-300 hover:text-white transition-all duration-300 flex items-center gap-1.5 hover:drop-shadow-[0_0_10px_rgba(255,255,255,0.6)]">
                    Resume <span class="font-light text-zinc-500 group-hover:text-white transition-colors duration-300 text-sm">↗</span>
                    <!-- Garis Bawah Dinamis -->
                    <span class="absolute -bottom-1 left-0 w-0 h-[1.5px] bg-white transition-all duration-300 group-hover:w-full group-hover:shadow-[0_0_8px_rgba(255,255,255,0.9)] rounded-full"></span>
                </a>
            </div>
            
            <!-- Smooth Mobile Toggle Button -->
            <button id="navbar-toggle-btn" class="relative overflow-hidden flex items-center justify-center w-11 h-11 rounded-full bg-white/5 border border-white/10 backdrop-blur-md text-white md:hidden cursor-pointer">
                <span id="navbar-icon-at" class="absolute transition-all duration-500 ease-[cubic-bezier(0.34,1.56,0.64,1)] transform rotate-0 scale-100 opacity-100 font-medium">@</span>
                <span id="navbar-icon-x" class="absolute transition-all duration-500 ease-[cubic-bezier(0.34,1.56,0.64,1)] transform -rotate-90 scale-50 opacity-0 font-medium">✕</span>
            </button>

            <!-- Smooth Dropdown Menu -->
            <div id="navbar-mobile-menu" class="absolute top-[60px] right-0 bg-[#141414]/90 border border-white/10 backdrop-blur-xl rounded-2xl p-2 w-[160px] flex flex-col gap-1 opacity-0 pointer-events-none transform -translate-y-4 scale-95 transition-all duration-500 ease-[cubic-bezier(0.22,1,0.36,1)] origin-top-right md:hidden">
                <a href="https://linkedin.com" target="_blank" class="px-4 py-3 rounded-xl hover:bg-white/10 text-sm font-medium flex justify-between items-center transition-colors text-white/90">
                    LinkedIn <span class="opacity-50">↗</span>
                </a>
                <a href="/resume.pdf" download class="px-4 py-3 rounded-xl hover:bg-white/10 text-sm font-medium flex justify-between items-center transition-colors text-white/90">
                    Resume <span class="opacity-50">↗</span>
                </a>
            </div>
        </div>

    </div>
</header>

<!-- JavaScript khusus Navbar -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // --- Transisi Halaman Logic ---
        const pageOverlay = document.getElementById('page-transition-overlay');
        
        // Perlahan hilangkan overlay gelap sesaat setelah dokumen selesai dimuat (Fade In)
        setTimeout(() => {
            if(pageOverlay) pageOverlay.style.opacity = '0';
        }, 50);

        // Safari/Chrome BFCache handler: Pastikan overlay hilang jika user menekan tombol "Back" di browser
        window.addEventListener('pageshow', (event) => {
            if (event.persisted && pageOverlay) {
                pageOverlay.style.opacity = '0';
            }
        });


        // --- Smooth Pill Indicator Logic ---
        const navPill = document.querySelector('.nav-pill');
        const indicator = document.getElementById('nav-pill-indicator');
        const navLinks = document.querySelectorAll('.nav-pill a');
        const activeLink = document.querySelector('.nav-pill a.active');

        function moveIndicator(link) {
            if (!link || !indicator) return;
            indicator.style.left = `${link.offsetLeft}px`;
            indicator.style.width = `${link.offsetWidth}px`;
        }

        if (activeLink && indicator) {
            setTimeout(() => moveIndicator(activeLink), 50); 
        }

        // HANYA bergeser ketika link diklik dan MENCEGAH FLICKER dengan animasi overlay
        navLinks.forEach(link => {
            link.addEventListener('click', (e) => {
                const targetUrl = link.href;

                // Abaikan jika user mengeklik tab yang sama dengan yang sedang dibuka
                if (targetUrl === window.location.href) return;

                e.preventDefault(); // Mencegah browser melakukan reload halaman kasar secara instan
                
                moveIndicator(link);
                
                // Ubah gaya teks
                navLinks.forEach(l => l.classList.remove('active', 'text-white'));
                link.classList.add('active', 'text-white');

                // Tarik Tirai (Gelapkan Layar - Fade Out)
                if (pageOverlay) {
                    pageOverlay.style.opacity = '1';
                }

                // Tunggu 450ms agar animasi bergeser dan animasi tirai gelap hampir selesai, barulah navigasi berjalan secara gaib
                setTimeout(() => {
                    window.location.href = targetUrl;
                }, 450); 
            });
        });

        // --- Mobile Menu Dropdown Logic ---
        const toggleBtn = document.getElementById('navbar-toggle-btn');
        const iconAt = document.getElementById('navbar-icon-at');
        const iconX = document.getElementById('navbar-icon-x');
        const mobileMenu = document.getElementById('navbar-mobile-menu');
        let isNavbarMenuOpen = false;

        if (toggleBtn && iconAt && iconX && mobileMenu) {
            toggleBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                isNavbarMenuOpen = !isNavbarMenuOpen;
                
                if (isNavbarMenuOpen) {
                    iconAt.classList.replace('rotate-0', 'rotate-90');
                    iconAt.classList.replace('scale-100', 'scale-50');
                    iconAt.classList.replace('opacity-100', 'opacity-0');
                    
                    iconX.classList.replace('-rotate-90', 'rotate-0');
                    iconX.classList.replace('scale-50', 'scale-100');
                    iconX.classList.replace('opacity-0', 'opacity-100');

                    mobileMenu.classList.remove('opacity-0', 'pointer-events-none', '-translate-y-4', 'scale-95');
                    mobileMenu.classList.add('opacity-100', 'pointer-events-auto', 'translate-y-0', 'scale-100');
                } else {
                    iconAt.classList.replace('rotate-90', 'rotate-0');
                    iconAt.classList.replace('scale-50', 'scale-100');
                    iconAt.classList.replace('opacity-0', 'opacity-100');

                    iconX.classList.replace('rotate-0', '-rotate-90');
                    iconX.classList.replace('scale-100', 'scale-50');
                    iconX.classList.replace('opacity-100', 'opacity-0');

                    mobileMenu.classList.remove('opacity-100', 'pointer-events-auto', 'translate-y-0', 'scale-100');
                    mobileMenu.classList.add('opacity-0', 'pointer-events-none', '-translate-y-4', 'scale-95');
                }
            });

            document.addEventListener('click', (e) => {
                if (isNavbarMenuOpen && !toggleBtn.contains(e.target) && !mobileMenu.contains(e.target)) {
                    toggleBtn.click();
                }
            });
        }
    });
</script>