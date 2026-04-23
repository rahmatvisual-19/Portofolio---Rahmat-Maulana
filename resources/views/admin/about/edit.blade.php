<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Edit Story Block</title>
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
                    <span class="text-white">Edit Block</span>
                </div>
                <h1 class="text-3xl md:text-4xl font-bold tracking-tight text-white">Edit Story Block</h1>
                <p class="text-zinc-400 mt-2">Update the photo or text content for this section.</p>
            </div>

            <form id="editAboutForm" action="#" method="POST" enctype="multipart/form-data" class="bg-[#141414] border border-white/10 rounded-3xl p-8 md:p-10 shadow-2xl relative overflow-hidden">
                @csrf
                @method('PUT')
                <div class="absolute top-0 left-0 w-full h-[1px] bg-gradient-to-r from-transparent via-white/20 to-transparent"></div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    
                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-semibold text-zinc-300 mb-2">Heading Title (Optional)</label>
                            <input type="text" name="title" value="My background in Architecture." class="w-full bg-[#0a0a0a] border border-white/10 rounded-xl px-4 py-3 text-white focus:border-blue-500 outline-none transition-all">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-zinc-300 mb-2">Story Content</label>
                            <textarea name="content" rows="8" required class="w-full bg-[#0a0a0a] border border-white/10 rounded-xl px-4 py-3 text-white focus:border-blue-500 outline-none transition-all resize-none">In June of 2022, I graduated from architecture school at the University of Toronto. There, I became obsessed with architectural visualization.

I was deeply fascinated in the concepts of modularity and adaptability.</textarea>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-zinc-300 mb-2">Portrait Photo (Current)</label>
                        
                        <div class="mb-3 w-32 mx-auto h-40 rounded-xl overflow-hidden border border-white/10 flex items-center justify-center relative">
                            <img src="https://images.unsplash.com/photo-1490806843957-31f4c9a91c65?q=80&w=300" alt="Current Photo" class="w-full h-full object-cover opacity-80">
                            <span class="absolute top-2 right-2 text-[8px] uppercase tracking-widest font-bold bg-black/50 backdrop-blur-md px-2 py-1 rounded-md text-white">Current</span>
                        </div>

                        <div class="relative group border-2 border-dashed border-white/10 rounded-xl bg-[#0a0a0a] hover:bg-white/5 transition-all p-6 text-center cursor-pointer max-w-sm mx-auto flex flex-col justify-center items-center">
                            <input type="file" name="photo" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                            <p class="text-sm text-zinc-400 font-medium group-hover:text-white transition-colors mb-1">Select new image to replace</p>
                            <p class="text-[10px] text-zinc-600">Leave blank to keep current photo.</p>
                        </div>
                    </div>

                </div>

                <div class="h-px w-full bg-gradient-to-r from-transparent via-white/10 to-transparent my-8"></div>

                <div class="flex justify-end gap-4">
                    <a href="/admin/about" class="px-6 py-3 rounded-full text-sm font-bold text-zinc-400 hover:text-white hover:bg-white/5 transition-all">Cancel</a>
                    <button type="submit" class="px-8 py-3 rounded-full text-sm font-bold bg-blue-600 text-white hover:bg-blue-500 hover:scale-105 transition-all shadow-[0_0_20px_rgba(37,99,235,0.4)]">Save Changes</button>
                </div>
            </form>
        </div>
    </main>

    <script>
        const swalDark = Swal.mixin({
            background: '#141414', color: '#ffffff',
            customClass: {
                popup: 'border border-white/10 rounded-3xl shadow-2xl',
                confirmButton: 'px-8 py-3 rounded-full text-sm font-bold bg-blue-600 text-white hover:bg-blue-500',
            },
            buttonsStyling: false
        });

        document.getElementById('editAboutForm').addEventListener('submit', function(e) {
            e.preventDefault(); 
            swalDark.fire({
                icon: 'success', title: 'Changes Saved!', text: 'Your story block has been updated.',
                showConfirmButton: false, timer: 2000
            }).then(() => { window.location.href = '/admin/about'; });
        });
    </script>
</body>
</html>