<!-- HEADER NAVBAR -->
<style>
    .nav-pill { position: relative; }
    .nav-pill-indicator {
        position: absolute;
        top: 0.25rem;
        height: calc(100% - 0.5rem);
        left: 0;
        width: 0;
        background: rgba(255, 255, 255, 0.08);
        border-radius: 999px;
        transition: left 0.35s ease, width 0.35s ease;
        pointer-events: none;
    }
</style>
<header id="navbar-header" class="fixed top-0 w-full z-50 px-6 md:px-12 lg:px-24 py-6 md:py-8 pointer-events-none">
    <div class="max-w-screen-2xl mx-auto flex items-center justify-between pointer-events-auto relative">
        
        <!-- Logo Minimalis -->
        <div class="hidden md:flex flex-col">
            <a href="/" class="text-lg font-semibold tracking-tight text-white hover:text-gray-200 transition-colors leading-tight">Perry Wang</a>
            <span class="text-[13px] text-zinc-400 font-medium">Product Designer</span>
        </div>

        <!-- Tengah: Kapsul Navigasi Minimalis (Glow Active State) -->
        <div class="flex items-center gap-6 md:absolute md:left-1/2 md:-translate-x-1/2">
            <nav class="nav-pill flex items-center p-1 rounded-full bg-white/[0.04] border border-white/[0.08] backdrop-blur-md">
                <span id="nav-pill-indicator" class="nav-pill-indicator"></span>
                <a href="{{ route('portofolio') }}" class="relative z-10 px-6 py-2 rounded-full text-[13px] font-medium transition-all duration-300 {{ request()->routeIs('portofolio') ? 'active text-white bg-white/10' : 'text-zinc-400 hover:text-white hover:bg-white/5' }}">
                    Work
                </a>
                <a href="{{ route('info') }}" class="relative z-10 px-6 py-2 rounded-full text-[13px] font-medium transition-all duration-300 {{ request()->routeIs('info') ? 'active text-white bg-white/10' : 'text-zinc-400 hover:text-white hover:bg-white/5' }}">
                    Info
                </a>
            </nav>
        </div>

        <!-- Kanan: Link Desktop & Tombol @ Dropdown -->
        <div class="relative flex items-center gap-6">
            <div class="hidden md:flex gap-8">
                <a href="https://linkedin.com" target="_blank" class="text-[13px] font-medium text-white hover:text-zinc-300 transition-colors flex items-center gap-1.5">
                    LinkedIn <span class="font-light text-zinc-400 text-sm">↗</span>
                </a>
                <a href="/resume.pdf" download class="text-[13px] font-medium text-white hover:text-zinc-300 transition-colors flex items-center gap-1.5">
                    Resume <span class="font-light text-zinc-400 text-sm">↗</span>
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
                    // Animasi dari @ ke ✕
                    iconAt.classList.replace('rotate-0', 'rotate-90');
                    iconAt.classList.replace('scale-100', 'scale-50');
                    iconAt.classList.replace('opacity-100', 'opacity-0');
                    
                    iconX.classList.replace('-rotate-90', 'rotate-0');
                    iconX.classList.replace('scale-50', 'scale-100');
                    iconX.classList.replace('opacity-0', 'opacity-100');

                    // Munculkan menu
                    mobileMenu.classList.remove('opacity-0', 'pointer-events-none', '-translate-y-4', 'scale-95');
                    mobileMenu.classList.add('opacity-100', 'pointer-events-auto', 'translate-y-0', 'scale-100');
                } else {
                    // Animasi kembali ke @
                    iconAt.classList.replace('rotate-90', 'rotate-0');
                    iconAt.classList.replace('scale-50', 'scale-100');
                    iconAt.classList.replace('opacity-0', 'opacity-100');

                    iconX.classList.replace('rotate-0', '-rotate-90');
                    iconX.classList.replace('scale-100', 'scale-50');
                    iconX.classList.replace('opacity-100', 'opacity-0');

                    // Sembunyikan menu
                    mobileMenu.classList.remove('opacity-100', 'pointer-events-auto', 'translate-y-0', 'scale-100');
                    mobileMenu.classList.add('opacity-0', 'pointer-events-none', '-translate-y-4', 'scale-95');
                }
            });

            // Tutup menu jika klik di luar
            document.addEventListener('click', (e) => {
                if (isNavbarMenuOpen && !toggleBtn.contains(e.target) && !mobileMenu.contains(e.target)) {
                    toggleBtn.click();
                }
            });
        }
    });
</script>