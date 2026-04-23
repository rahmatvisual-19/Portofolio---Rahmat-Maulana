<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Add Tool</title>
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

        <div class="p-6 md:p-12 lg:p-16 max-w-2xl mx-auto">
            
            <div class="mb-10">
                <div class="flex items-center gap-2 text-sm text-zinc-500 font-medium mb-3">
                    <a href="/admin/friends" class="hover:text-white transition-colors">Tools</a>
                    <span>/</span>
                    <span class="text-white">Add New</span>
                </div>
                <h1 class="text-3xl md:text-4xl font-bold tracking-tight text-white">Add New Tool</h1>
                <p class="text-zinc-400 mt-2">Add a new technology to your "proficient in" list.</p>
            </div>

            <form id="createToolForm" action="#" method="POST" class="bg-[#141414] border border-white/10 rounded-3xl p-8 md:p-10 shadow-2xl relative overflow-hidden">
                @csrf
                <div class="absolute top-0 left-0 w-full h-[1px] bg-gradient-to-r from-transparent via-white/20 to-transparent"></div>

                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-semibold text-zinc-300 mb-2">Tool Name</label>
                        <input type="text" name="name" placeholder="e.g. React, Laravel, Figma" required class="w-full bg-[#0a0a0a] border border-white/10 rounded-xl px-4 py-3 text-white placeholder-zinc-600 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all font-jetbrains">
                    </div>
                </div>

                <div class="h-px w-full bg-gradient-to-r from-transparent via-white/10 to-transparent my-8"></div>

                <div class="flex justify-end gap-4">
                    <a href="/admin/friends" class="px-6 py-3 rounded-full text-sm font-bold text-zinc-400 hover:text-white hover:bg-white/5 transition-all">Cancel</a>
                    <button type="submit" class="px-8 py-3 rounded-full text-sm font-bold bg-white text-black hover:bg-gray-200 hover:scale-105 transition-all shadow-[0_0_20px_rgba(255,255,255,0.2)]">Save Tool</button>
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

        document.getElementById('createToolForm').addEventListener('submit', function(e) {
            e.preventDefault(); 
            swalDark.fire({
                icon: 'success', title: 'Tool Added!', text: 'Successfully added to your tech stack.',
                showConfirmButton: false, timer: 2000
            }).then(() => { window.location.href = '/admin/friends'; });
        });
    </script>
</body>
</html>