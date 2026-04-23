<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Edit Client</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Albert+Sans:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
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

        <div class="p-6 md:p-12 lg:p-16 max-w-4xl mx-auto">
            
            <div class="mb-10">
                <div class="flex items-center gap-2 text-sm text-zinc-500 font-medium mb-3">
                    <a href="/admin/clients" class="hover:text-white transition-colors">Selected Clients</a>
                    <span>/</span>
                    <span class="text-white">Edit Client</span>
                </div>
                <h1 class="text-3xl md:text-4xl font-bold tracking-tight text-white">Edit Client</h1>
                <p class="text-zinc-400 mt-2">Update the information for this client.</p>
            </div>

            <form id="editClientForm" action="#" method="POST" enctype="multipart/form-data" class="bg-[#141414] border border-white/10 rounded-3xl p-8 md:p-10 shadow-2xl relative overflow-hidden">
                @csrf
                @method('PUT')
                <div class="absolute top-0 left-0 w-full h-[1px] bg-gradient-to-r from-transparent via-white/20 to-transparent"></div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                    
                    <!-- Kiri: Client Name -->
                    <div class="flex flex-col justify-center">
                        <label class="block text-sm font-semibold text-zinc-300 mb-2">Client Name</label>
                        <!-- Anggap Data Dummy-nya Spotify -->
                        <input type="text" id="clientName" name="name" value="Spotify" placeholder="e.g. Spotify" class="w-full bg-[#0a0a0a] border border-white/10 rounded-xl px-4 py-3 text-white placeholder-zinc-600 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all">
                        <p class="text-xs text-zinc-500 mt-3 leading-relaxed">Leave blank if you only want to display the company's logo.</p>
                    </div>

                    <!-- Kanan: Client Logo Update -->
                    <div>
                        <label class="block text-sm font-semibold text-zinc-300 mb-2">Client Logo</label>
                        
                        <!-- Menampilkan Logo Aktif -->
                        <div class="mb-3 w-full max-w-[240px] mx-auto h-24 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center p-3 relative">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/1/19/Spotify_logo_without_text.svg" alt="Current Logo" class="h-full object-contain filter invert opacity-70">
                            <span class="absolute top-2 right-2 text-[8px] uppercase tracking-widest font-bold bg-white/10 px-2 py-1 rounded-md text-zinc-400">Current</span>
                        </div>

                        <div class="relative group border-2 border-dashed border-white/10 rounded-xl bg-[#0a0a0a] hover:bg-white/5 hover:border-white/20 transition-all p-4 text-center cursor-pointer max-w-[240px] mx-auto">
                            <input type="file" id="clientLogo" name="logo" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                            <p class="text-sm text-zinc-400 font-medium group-hover:text-white transition-colors">Select new logo to replace</p>
                        </div>
                    </div>
                </div>

                <div class="h-px w-full bg-gradient-to-r from-transparent via-white/10 to-transparent my-8"></div>

                <div class="flex justify-end gap-4">
                    <a href="/admin/clients" class="px-6 py-3 rounded-full text-sm font-bold text-zinc-400 hover:text-white hover:bg-white/5 transition-all">Cancel</a>
                    <button type="submit" class="px-8 py-3 rounded-full text-sm font-bold bg-blue-600 text-white hover:bg-blue-500 hover:scale-105 transition-all shadow-[0_0_20px_rgba(37,99,235,0.4)]">Save Changes</button>
                </div>
            </form>
        </div>
    </main>

    <script>
        const swalDark = Swal.mixin({
            background: '#141414',
            color: '#ffffff',
            customClass: {
                popup: 'border border-white/10 rounded-3xl shadow-2xl',
                confirmButton: 'px-8 py-3 rounded-full text-sm font-bold bg-blue-600 text-white hover:bg-blue-500 transition-all focus:outline-none focus:ring-0',
            },
            buttonsStyling: false
        });

        document.getElementById('editClientForm').addEventListener('submit', function(e) {
            e.preventDefault(); 
            
            const name = document.getElementById('clientName').value.trim();
            // Logo dikosongkan tidak apa-apa karena mungkin user hanya ingin ganti nama (logo lama masih di DB)
            // Tapi jika nama juga dikosongkan dan kita hapus di DB, maka harus ada validasi server nanti.
            // Di sisi UI, kita pastikan Name tidak diubah jadi kosong melompong (kecuali memang tujuannya logo only)

            swalDark.fire({
                icon: 'success',
                title: 'Changes Saved!',
                text: 'Client details have been successfully updated.',
                showConfirmButton: false,
                timer: 2000
            }).then(() => {
                window.location.href = '/admin/clients';
            });
        });
    </script>
</body>
</html>