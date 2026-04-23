<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Add Showcase</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Albert+Sans:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body { font-family: 'Albert Sans', sans-serif; background-color: #0a0a0a; color: #ffffff; }
        .font-jetbrains { font-family: 'JetBrains Mono', monospace; }
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #171717; }
        ::-webkit-scrollbar-thumb { background: #333; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #444; }
    </style>
</head>
<body class="antialiased selection:bg-white selection:text-black flex min-h-screen">

    @include('admin.partials.sidebar')

    <main class="flex-1 overflow-y-auto bg-[#0a0a0a] relative">
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full max-w-3xl h-[300px] bg-blue-500/10 blur-[120px] rounded-full pointer-events-none -z-10"></div>

        <div class="p-6 md:p-12 lg:p-16 max-w-5xl mx-auto">
            
            <div class="mb-10">
                <div class="flex items-center gap-2 text-sm text-zinc-500 font-medium mb-3">
                    <a href="/admin/showcase" class="hover:text-white transition-colors">Showcase</a>
                    <span>/</span>
                    <span class="text-white">Create New</span>
                </div>
                <h1 class="text-3xl md:text-4xl font-bold tracking-tight text-white">Add New Project</h1>
                <p class="text-zinc-400 mt-2">Publish a new project to your portfolio showcase.</p>
            </div>

            <!-- Form Create -->
            <form id="createProjectForm" action="#" method="POST" enctype="multipart/form-data" class="bg-[#141414] border border-white/10 rounded-3xl p-8 md:p-10 shadow-2xl relative overflow-hidden">
                @csrf
                <div class="absolute top-0 left-0 w-full h-[1px] bg-gradient-to-r from-transparent via-white/20 to-transparent"></div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-semibold text-zinc-300 mb-2">Project Title</label>
                            <input type="text" name="title" placeholder="e.g. Nexus Platform" required class="w-full bg-[#0a0a0a] border border-white/10 rounded-xl px-4 py-3 text-white placeholder-zinc-600 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-zinc-300 mb-2">Company & Year</label>
                            <input type="text" name="company" placeholder="e.g. Google, '23" required class="w-full bg-[#0a0a0a] border border-white/10 rounded-xl px-4 py-3 text-white placeholder-zinc-600 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all font-jetbrains text-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-zinc-300 mb-2">Category</label>
                            <div class="flex gap-3">
                                <div class="relative flex-1">
                                    <select id="categorySelect" name="category" required class="w-full bg-[#0a0a0a] border border-white/10 rounded-xl px-4 py-3 text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all appearance-none cursor-pointer">
                                        <option value="" disabled selected>Select category...</option>
                                        <option value="design">Design</option>
                                        <option value="dev">Development</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none text-zinc-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </div>
                                </div>
                                <button type="button" onclick="openCategoryModal()" class="px-4 bg-white/5 hover:bg-white/10 border border-white/10 rounded-xl text-sm font-medium transition-colors text-white whitespace-nowrap flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                    New
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-semibold text-zinc-300 mb-2">Short Description</label>
                            <textarea name="desc" rows="4" placeholder="e.g. Membangun ekosistem yang berkelanjutan." required class="w-full bg-[#0a0a0a] border border-white/10 rounded-xl px-4 py-3 text-white placeholder-zinc-600 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all resize-none"></textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-zinc-300 mb-2">Project Image</label>
                            <div class="relative group border-2 border-dashed border-white/10 rounded-xl bg-[#0a0a0a] hover:bg-white/5 hover:border-white/20 transition-all p-6 text-center cursor-pointer">
                                <input type="file" name="img" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                                <div class="flex flex-col items-center justify-center space-y-3 pointer-events-none">
                                    <div class="w-12 h-12 rounded-full bg-blue-500/10 flex items-center justify-center text-blue-400 group-hover:scale-110 transition-transform">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                    <div>
                                        <p class="text-sm text-white font-medium">Click to upload or drag and drop</p>
                                        <p class="text-xs text-zinc-500 mt-1">SVG, PNG, JPG (MAX. 2MB)</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="h-px w-full bg-gradient-to-r from-transparent via-white/10 to-transparent my-8"></div>

                <div class="flex justify-end gap-4">
                    <a href="/admin/showcase" class="px-6 py-3 rounded-full text-sm font-bold text-zinc-400 hover:text-white hover:bg-white/5 transition-all">Cancel</a>
                    <button type="submit" class="px-8 py-3 rounded-full text-sm font-bold bg-white text-black hover:bg-gray-200 hover:scale-105 transition-all shadow-[0_0_20px_rgba(255,255,255,0.2)]">Publish Project</button>
                </div>
            </form>
        </div>
    </main>

    <!-- MODAL ADD CATEGORY -->
    <div id="categoryModal" class="fixed inset-0 z-[60] flex items-center justify-center bg-black/70 backdrop-blur-sm opacity-0 pointer-events-none transition-opacity duration-300">
        <div id="categoryModalContent" class="bg-[#141414] border border-white/10 rounded-3xl p-8 w-full max-w-sm transform scale-95 transition-transform duration-300 shadow-[0_20px_50px_rgba(0,0,0,0.5)]">
            <h3 class="text-xl font-bold text-white mb-4">Add New Category</h3>
            <div class="mb-6">
                <label class="block text-sm font-medium text-zinc-400 mb-2">Category Name</label>
                <input type="text" id="newCategoryInput" placeholder="e.g. UI/UX, 3D Art" class="w-full bg-[#0a0a0a] border border-white/10 rounded-xl px-4 py-3 text-white placeholder-zinc-600 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all">
            </div>
            <div class="flex gap-3 justify-end">
                <button type="button" onclick="closeCategoryModal()" class="px-5 py-2.5 rounded-xl text-sm font-medium text-zinc-400 hover:text-white hover:bg-white/5 transition-all">Cancel</button>
                <button type="button" onclick="saveCategory()" class="px-5 py-2.5 rounded-xl text-sm font-bold bg-blue-500/20 text-blue-400 hover:bg-blue-500 hover:text-white border border-blue-500/20 transition-all">Save Category</button>
            </div>
        </div>
    </div>

    <!-- JS Logic & SweetAlert -->
    <script>
        // --- Tema Kustom SweetAlert Dark ---
        const swalDark = Swal.mixin({
            background: '#141414',
            color: '#ffffff',
            customClass: {
                popup: 'border border-white/10 rounded-3xl shadow-2xl',
                confirmButton: 'px-8 py-3 rounded-full text-sm font-bold bg-white text-black hover:bg-gray-200 transition-all focus:outline-none focus:ring-0',
            },
            buttonsStyling: false
        });

        // --- Fitur Modal Kategori ---
        const modal = document.getElementById('categoryModal');
        const modalContent = document.getElementById('categoryModalContent');
        const selectBox = document.getElementById('categorySelect');
        const inputField = document.getElementById('newCategoryInput');

        function openCategoryModal() {
            inputField.value = ''; 
            modal.classList.remove('opacity-0', 'pointer-events-none');
            modalContent.classList.remove('scale-95');
            setTimeout(() => inputField.focus(), 100);
        }

        function closeCategoryModal() {
            modal.classList.add('opacity-0', 'pointer-events-none');
            modalContent.classList.add('scale-95');
        }

        function saveCategory() {
            const newCat = inputField.value.trim();
            if (newCat !== '') {
                const newCatValue = newCat.toLowerCase().replace(/[^a-z0-9]/g, '-');
                const newOption = new Option(newCat, newCatValue);
                selectBox.add(newOption);
                selectBox.value = newCatValue; 
                closeCategoryModal();

                // Alert Kategori Berhasil Dibuat
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    background: '#141414',
                    color: '#fff',
                    iconColor: '#3b82f6',
                    customClass: { popup: 'border border-white/10 rounded-xl shadow-lg' }
                });

                Toast.fire({
                    icon: 'success',
                    title: `Category "${newCat}" added!`
                });
            }
        }

        // --- Simulasi Simpan Project dengan SweetAlert ---
        document.getElementById('createProjectForm').addEventListener('submit', function(e) {
            e.preventDefault(); // Mencegah pindah halaman sebelum alert muncul

            swalDark.fire({
                icon: 'success',
                title: 'Project Published!',
                text: 'Your new showcase project has been successfully created.',
                showConfirmButton: false, // Sembunyikan tombol agar terlihat otomatis
                timer: 2000 // Otomatis hilang dalam 2 detik
            }).then(() => {
                // Simulasi redirect kembali ke halaman Index
                window.location.href = '/admin/showcase';
            });
        });
    </script>
</body>
</html>