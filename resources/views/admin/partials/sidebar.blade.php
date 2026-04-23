<!-- SIDEBAR ADMIN KOMPONEN -->
<aside class="w-64 bg-[#121212] border-r border-white/5 flex flex-col justify-between hidden md:flex h-screen sticky top-0 z-50">
    <div class="overflow-y-auto hide-scrollbar">
        <!-- Logo Admin -->
        <div class="p-8 border-b border-white/5">
            <a href="/admin/showcase" class="text-xl font-bold tracking-tight text-white flex items-center gap-2">
                <div class="w-3 h-3 rounded-full bg-blue-500 shadow-[0_0_10px_rgba(59,130,246,0.6)] animate-pulse"></div>
                Admin Panel
            </a>
        </div>

        <!-- Menu Navigasi Utama -->
        <nav class="p-4 flex flex-col gap-8 mt-2">
            
            <!-- ================= GROUP: WORK ================= -->
            <div>
                <span class="text-[10px] font-bold tracking-widest text-zinc-500 uppercase px-4 mb-3 block">Work</span>
                <div class="flex flex-col gap-1">
                    
                    <!-- 1. Showcase -->
                    <a href="/admin/showcase" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300 {{ request()->is('admin/showcase*') ? 'bg-white/10 text-white font-medium border border-white/5 shadow-lg' : 'text-zinc-400 hover:bg-white/5 hover:text-white' }}">
                        <svg class="w-5 h-5 {{ request()->is('admin/showcase*') ? 'text-blue-400' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                        </svg>
                        Showcase
                    </a>
                    
                    <!-- 2. Selected Clients -->
                    <a href="/admin/clients" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300 {{ request()->is('admin/clients*') ? 'bg-white/10 text-white font-medium border border-white/5 shadow-lg' : 'text-zinc-400 hover:bg-white/5 hover:text-white' }}">
                        <svg class="w-5 h-5 {{ request()->is('admin/clients*') ? 'text-blue-400' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                    
                    <!-- 1. About Me (6 Photos) -->
                    <a href="/admin/about" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300 {{ request()->is('admin/about*') ? 'bg-white/10 text-white font-medium border border-white/5 shadow-lg' : 'text-zinc-400 hover:bg-white/5 hover:text-white' }}">
                        <svg class="w-5 h-5 {{ request()->is('admin/about*') ? 'text-blue-400' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        About Me
                    </a>

                    <!-- 2. Experience -->
                    <a href="/admin/experience" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300 {{ request()->is('admin/experience*') ? 'bg-white/10 text-white font-medium border border-white/5 shadow-lg' : 'text-zinc-400 hover:bg-white/5 hover:text-white' }}">
                        <svg class="w-5 h-5 {{ request()->is('admin/experience*') ? 'text-blue-400' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                        Experience
                    </a>

                    <!-- 3. Friends -->
                    <a href="/admin/friends" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300 {{ request()->is('admin/friends*') ? 'bg-white/10 text-white font-medium border border-white/5 shadow-lg' : 'text-zinc-400 hover:bg-white/5 hover:text-white' }}">
                        <svg class="w-5 h-5 {{ request()->is('admin/friends*') ? 'text-blue-400' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        Friends
                    </a>

                </div>
            </div>

        </nav>
    </div>

    <!-- Profil / Logout -->
    <div class="p-6 border-t border-white/5 mt-auto">
        <a href="/" class="flex items-center gap-3 w-full p-2 rounded-xl text-zinc-400 hover:text-white hover:bg-white/5 transition-colors text-sm font-medium mb-2 group">
            <svg class="w-5 h-5 text-zinc-500 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Back to Website
        </a>
        <a href="/login" class="flex items-center gap-3 w-full p-2 rounded-xl text-zinc-400 hover:text-white hover:bg-red-500/10 transition-colors text-sm font-medium group">
            <svg class="w-5 h-5 text-red-500/60 group-hover:text-red-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
            Logout
        </a>
    </div>
</aside>