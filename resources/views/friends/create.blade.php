<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Add Friend</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Albert+Sans:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body { font-family: 'Albert Sans', sans-serif; background-color: #0a0a0a; color: #ffffff; }
        .font-jetbrains { font-family: 'JetBrains Mono', monospace; }
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #171717; }
        ::-webkit-scrollbar-thumb { background: #333; border-radius: 4px; }
    </style>
</head>
<body class="antialiased selection:bg-white selection:text-black flex h-screen overflow-hidden">

    @include('admin.partials.sidebar')

    <main class="flex-1 overflow-y-auto bg-[#0a0a0a] relative">
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full max-w-3xl h-[300px] bg-blue-500/10 blur-[120px] rounded-full pointer-events-none -z-10"></div>

        <div class="p-6 md:p-12 lg:p-16 max-w-4xl mx-auto">
            
            <div class="mb-10">
                <div class="flex items-center gap-2 text-sm text-zinc-500 font-medium mb-3">
                    <a href="/admin/friends" class="hover:text-white transition-colors">Friends</a>
                    <span>/</span>
                    <span class="text-white">Add New</span>
                </div>
                <h1 class="text-3xl md:text-4xl font-bold tracking-tight text-white">Add New Friend</h1>
                <p class="text-zinc-400 mt-2">Add a colleague or partner to your network list.</p>
            </div>

            <form id="createFriendForm" action="#" method="POST" class="bg-[#141414] border border-white/10 rounded-3xl p-8 md:p-10 shadow-2xl relative overflow-hidden">
                @csrf
                <div class="absolute top-0 left-0 w-full h-[1px] bg-gradient-to-r from-transparent via-white/20 to-transparent"></div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    
                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-semibold text-zinc-300 mb-2">Name</label>
                            <input type="text" name="name" placeholder="e.g. Xavier Woo" required class="w-full bg-[#0a0a0a] border border-white/10 rounded-xl px-4 py-3 text-white placeholder-zinc-600 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-zinc-300 mb-2">Position / Role</label>
                            <input type="text" name="role" placeholder="e.g. Founding Designer" required class="w-full bg-[#0a0a0a] border border-white/10 rounded-xl px-4 py-3 text-white placeholder-zinc-600 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all">
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-semibold text-zinc-300 mb-2">Company / Status</label>
                            <input type="text" name="company" placeholder="e.g. Blockus" required class="w-full bg-[#0a0a0a] border border-white/10 rounded-xl px-4 py-3 text-white placeholder-zinc-600 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-zinc-300 mb-2">Social / Work Link</label>
                            <input type="url" name="link" placeholder="e.g. https://xavierw.ca" required class="w-full bg-[#0a0a0a] border border-white/10 rounded-xl px-4 py-3 text-white placeholder-zinc-600 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all font-jetbrains text-sm text-blue-400">
                            <p class="text-[11px] text-zinc-500 mt-2">The actual website link (include https://).</p>
                        </div>
                    </div>

                </div>

                <div class="h-px w-full bg-gradient-to-r from-transparent via-white/10 to-transparent my-8"></div>

                <div class="flex justify-end gap-4">
                    <a href="/admin/friends" class="px-6 py-3 rounded-full text-sm font-bold text-zinc-400 hover:text-white hover:bg-white/5 transition-all">Cancel</a>
                    <button type="submit" class="px-8 py-3 rounded-full text-sm font-bold bg-white text-black hover:bg-gray-200 hover:scale-105 transition-all shadow-[0_0_20px_rgba(255,255,255,0.2)]">Save Friend</button>
                </div>
            </form>
        </div>
    </main>

    <script>
        const swalDark = Swal.mixin({
            background: '#141414', color: '#ffffff',
            customClass: {
                popup: 'border border-white/10 rounded-3xl shadow-2xl',
                confirmButton: 'px-8 py-3 rounded-full text-sm font-bold bg-white text-black hover:bg-gray-200',
            },
            buttonsStyling: false
        });

        document.getElementById('createFriendForm').addEventListener('submit', function(e) {
            e.preventDefault(); 
            swalDark.fire({
                icon: 'success', title: 'Friend Added!', text: 'Successfully added to your network.',
                showConfirmButton: false, timer: 2000
            }).then(() => { window.location.href = '/admin/friends'; });
        });
    </script>
</body>
</html>