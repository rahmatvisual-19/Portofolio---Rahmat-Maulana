<!-- SIDEBAR ADMIN KOMPONEN -->
<aside class="w-64 bg-[#121212] border-r border-white/5 flex flex-col hidden md:flex h-screen sticky top-0 z-50">
    
    <!-- Custom Scrollbar Style -->
    <style>
        .admin-sidebar-scroll::-webkit-scrollbar {
            width: 5px;
        }
        .admin-sidebar-scroll::-webkit-scrollbar-track {
            background: transparent;
        }
        .admin-sidebar-scroll::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 20px;
        }
        .admin-sidebar-scroll::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.2);
        }
        /* Smooth scrolling */
        .admin-sidebar-scroll {
            scrollbar-width: thin;
            scrollbar-color: rgba(255, 255, 255, 0.1) transparent;
            scroll-behavior: smooth;
            -webkit-overflow-scrolling: touch;
        }
    </style>
    
    <!-- Logo Admin (Tetap di atas / Sticky) -->
    <div class="p-8 border-b border-white/5 shrink-0">
        <a href="/admin/work/showcase" class="text-xl font-bold tracking-tight text-white flex items-center gap-2">
            <div class="w-3 h-3 rounded-full bg-blue-500 shadow-[0_0_10px_rgba(59,130,246,0.6)] animate-pulse"></div>
            Admin Panel
        </a>
    </div>

    <!-- Area Menu Utama (Bisa di-scroll dengan mudah) -->
    <div class="flex-1 overflow-y-auto overflow-x-hidden admin-sidebar-scroll">
        <nav class="p-4 flex flex-col gap-8 mt-2 mb-4">
            
            <!-- ================= GROUP: NAVBAR ================= -->
            <div>
                <span class="text-[10px] font-bold tracking-widest text-zinc-500 uppercase px-4 mb-3 block">Navbar Links</span>
                <div class="flex flex-col gap-1">
                    
                    <!-- 1. LinkedIn -->
                    <a href="/admin/navbar/linkedin" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300 {{ request()->is('admin/navbar/linkedin*') ? 'bg-white/10 text-white font-medium border border-white/5 shadow-lg' : 'text-zinc-400 hover:bg-white/5 hover:text-white' }}">
                        <svg class="w-5 h-5 {{ request()->is('admin/navbar/linkedin*') ? 'text-blue-400' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                        </svg>
                        LinkedIn
                    </a>

                    <!-- 2. Resume -->
                    <a href="/admin/navbar/resume" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300 {{ request()->is('admin/navbar/resume*') ? 'bg-white/10 text-white font-medium border border-white/5 shadow-lg' : 'text-zinc-400 hover:bg-white/5 hover:text-white' }}">
                        <svg class="w-5 h-5 {{ request()->is('admin/navbar/resume*') ? 'text-blue-400' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Resume
                    </a>

                    <!-- 3. CV -->
                    <a href="/admin/navbar/cv" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300 {{ request()->is('admin/navbar/cv*') ? 'bg-white/10 text-white font-medium border border-white/5 shadow-lg' : 'text-zinc-400 hover:bg-white/5 hover:text-white' }}">
                        <svg class="w-5 h-5 {{ request()->is('admin/navbar/cv*') ? 'text-blue-400' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path>
                        </svg>
                        CV
                    </a>

                </div>
            </div>

            <!-- ================= GROUP: WORK ================= -->
            <div>
                <span class="text-[10px] font-bold tracking-widest text-zinc-500 uppercase px-4 mb-3 block">Work</span>
                <div class="flex flex-col gap-1">
                    
                    <!-- 1. Showcase -->
                    <a href="/admin/work/showcase" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300 {{ request()->is('admin/work/showcase*') ? 'bg-white/10 text-white font-medium border border-white/5 shadow-lg' : 'text-zinc-400 hover:bg-white/5 hover:text-white' }}">
                        <svg class="w-5 h-5 {{ request()->is('admin/work/showcase*') ? 'text-blue-400' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                        </svg>
                        Showcase
                    </a>
                    
                    <!-- 2. Selected Clients -->
                    <a href="/admin/work/selected-client" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300 {{ request()->is('admin/work/selected-client*') ? 'bg-white/10 text-white font-medium border border-white/5 shadow-lg' : 'text-zinc-400 hover:bg-white/5 hover:text-white' }}">
                        <svg class="w-5 h-5 {{ request()->is('admin/work/selected-client*') ? 'text-blue-400' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                        Selected Clients
                    </a>

                </div>
            </div>

            <!-- ================= GROUP: INFO ================= -->
            <div>
                <span class="text-[10px] font-bold tracking-widest text-zinc-500 uppercase px-4 mb-3 block">Info</span>
                <div class="flex flex-col gap-1">
                    
                    <!-- 1. About Me -->
                    <a href="/admin/info/about-me" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300 {{ request()->is('admin/info/about-me*') ? 'bg-white/10 text-white font-medium border border-white/5 shadow-lg' : 'text-zinc-400 hover:bg-white/5 hover:text-white' }}">
                        <svg class="w-5 h-5 {{ request()->is('admin/info/about-me*') ? 'text-blue-400' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        About Me
                    </a>

                    <!-- 2. Experience -->
                    <a href="/admin/info/experience" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300 {{ request()->is('admin/info/experience*') ? 'bg-white/10 text-white font-medium border border-white/5 shadow-lg' : 'text-zinc-400 hover:bg-white/5 hover:text-white' }}">
                        <svg class="w-5 h-5 {{ request()->is('admin/info/experience*') ? 'text-blue-400' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                        Experience
                    </a>

                    <!-- 3. Tools -->
                    <a href="/admin/info/tools" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300 {{ request()->is('admin/info/tools*') ? 'bg-white/10 text-white font-medium border border-white/5 shadow-lg' : 'text-zinc-400 hover:bg-white/5 hover:text-white' }}">
                        <svg class="w-5 h-5 {{ request()->is('admin/info/tools*') ? 'text-blue-400' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 004.486-6.336l-3.276 3.277a3.004 3.004 0 01-2.25-2.25l3.276-3.276a4.5 4.5 0 00-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437l1.745-1.437m6.615 8.206L15.75 15.75M4.867 19.125h.008v.008h-.008v-.008z"></path>
                        </svg>
                        Tools
                    </a>

                </div>
            </div>

            <!-- ================= GROUP: GALLERY ================= -->
            <div>
                <span class="text-[10px] font-bold tracking-widest text-zinc-500 uppercase px-4 mb-3 block">Gallery</span>
                <div class="flex flex-col gap-1">
                    
                    <!-- 1. Gallery -->
                    <a href="/admin/gallery" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300 {{ request()->is('admin/gallery*') ? 'bg-white/10 text-white font-medium border border-white/5 shadow-lg' : 'text-zinc-400 hover:bg-white/5 hover:text-white' }}">
                        <svg class="w-5 h-5 {{ request()->is('admin/gallery*') ? 'text-blue-400' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        Gallery
                    </a>

                </div>
            </div>

        </nav>
    </div>

    <!-- Profil / Logout (Tetap di bawah / Sticky) -->
    <div class="p-6 border-t border-white/5 shrink-0">
        <a href="/" class="flex items-center gap-3 w-full p-2 rounded-xl text-zinc-400 hover:text-white hover:bg-white/5 transition-colors text-sm font-medium mb-2 group">
            <svg class="w-5 h-5 text-zinc-500 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Back to Website
        </a>
        <form action="/logout" method="POST" class="w-full">
            @csrf
            <button type="submit" class="flex items-center gap-3 w-full p-2 rounded-xl text-zinc-400 hover:text-white hover:bg-red-500/10 transition-colors text-sm font-medium group">
                <svg class="w-5 h-5 text-red-500/60 group-hover:text-red-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                Logout
            </button>
        </form>
    </div>
</aside>