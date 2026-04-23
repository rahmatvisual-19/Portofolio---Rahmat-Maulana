<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Add Story Block</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Albert+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body { font-family: 'Albert Sans', sans-serif; background-color: #0a0a0a; color: #ffffff; }
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #171717; }
        ::-webkit-scrollbar-thumb { background: #333; border-radius: 4px; }
    </style>
</head>
<body class="antialiased selection:bg-white selection:text-black flex min-h-screen">

    @include('admin.partials.sidebar')

    <main class="flex-1 overflow-y-auto bg-[#0a0a0a] relative">
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full max-w-3xl h-[300px] bg-blue-500/10 blur-[120px] rounded-full pointer-events-none -z-10"></div>

        <div class="p-6 md:p-12 lg:p-16 max-w-5xl mx-auto">
            
            <div class="mb-10">
                <div class="flex items-center gap-2 text-sm text-zinc-500 font-medium mb-3">
                    <a href="/admin/about" class="hover:text-white transition-colors">About Me</a>
                    <span>/</span>
                    <span class="text-white">Create New Block</span>
                </div>
                <h1 class="text-3xl md:text-4xl font-bold tracking-tight text-white">Add Story Block</h1>
                <p class="text-zinc-400 mt-2">Add a new photo and story paragraph. Max 6 blocks recommended for the best layout.</p>
            </div>

            <form id="createAboutForm" action="#" method="POST" enctype="multipart/form-data" class="bg-[#141414] border border-white/10 rounded-3xl p-8 md:p-10 shadow-2xl relative overflow-hidden">
                @csrf
                <div class="absolute top-0 left-0 w-full h-[1px] bg-gradient-to-r from-transparent via-white/20 to-transparent"></div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    
                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-semibold text-zinc-300 mb-2">Heading Title (Optional)</label>
                            <input type="text" id="title" name="title" placeholder="e.g. My background in Architecture." class="w-full bg-[#0a0a0a] border border-white/10 rounded-xl px-4 py-3 text-white placeholder-zinc-600 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-zinc-300 mb-2">Story Content</label>
                            <textarea id="content" name="content" rows="8" placeholder="Write your story paragraph here. Press Enter to create new paragraphs..." required class="w-full bg-[#0a0a0a] border border-white/10 rounded-xl px-4 py-3 text-white placeholder-zinc-600 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all resize-none"></textarea>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-zinc-300 mb-2">Portrait Photo</label>
                        <div class="relative group border-2 border-dashed border-white/10 rounded-xl bg-[#0a0a0a] hover:bg-white/5 hover:border-white/20 transition-all p-6 text-center cursor-pointer h-full min-h-[300px] flex flex-col items-center justify-center">
                            <input type="file" id="photo" name="photo" accept="image/*" required class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                            
                            <div class="w-16 h-20 border-2 border-white/10 rounded-lg flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                            <div>
                                <p class="text-sm text-white font-medium">Upload Story Photo</p>
                                <p class="text-xs text-zinc-500 mt-2 max-w-[200px] mx-auto leading-relaxed">For the best zig-zag look, use portrait images (Ratio 10:13).</p>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="h-px w-full bg-gradient-to-r from-transparent via-white/10 to-transparent my-8"></div>

                <div class="flex justify-end gap-4">
                    <a href="/admin/about" class="px-6 py-3 rounded-full text-sm font-bold text-zinc-400 hover:text-white hover:bg-white/5 transition-all">Cancel</a>
                    <button type="submit" class="px-8 py-3 rounded-full text-sm font-bold bg-white text-black hover:bg-gray-200 hover:scale-105 transition-all shadow-[0_0_20px_rgba(255,255,255,0.2)]">Publish Block</button>
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

        document.getElementById('createAboutForm').addEventListener('submit', function(e) {
            e.preventDefault(); 
            swalDark.fire({
                icon: 'success', title: 'Block Added!', text: 'Your story block has been saved.',
                showConfirmButton: false, timer: 2000
            }).then(() => { window.location.href = '/admin/about'; });
        });
    </script>
</body>
</html>