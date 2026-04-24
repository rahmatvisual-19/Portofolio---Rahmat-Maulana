<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - LinkedIn Link</title>
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
        
        /* Modal Transition Utilities */
        .modal-active { opacity: 1 !important; pointer-events: auto !important; }
        .modal-content-active { transform: scale(1) !important; }
    </style>
</head>
<body class="antialiased selection:bg-white selection:text-black flex h-screen overflow-hidden">

    <!-- Memanggil Sidebar yang sudah kita perbarui sebelumnya -->
    @include('admin.partials.sidebar')

    <main class="flex-1 overflow-y-auto bg-[#0a0a0a] relative">
        <!-- Latar Belakang Efek Glow Biru -->
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full max-w-3xl h-[300px] bg-blue-500/10 blur-[120px] rounded-full pointer-events-none -z-10"></div>

        <div class="p-6 md:p-12 lg:p-16 max-w-6xl mx-auto">
            
            <!-- Bagian Header Utama -->
            <div class="mb-10 flex flex-col md:flex-row md:items-end justify-between gap-6">
                <div>
                    <div class="flex items-center gap-2 text-sm text-zinc-500 font-medium mb-3">
                        <span class="text-white">Admin</span>
                        <span>/</span>
                        <span class="text-white">Navbar Links</span>
                        <span>/</span>
                        <span class="text-white">LinkedIn</span>
                    </div>
                    <h1 class="text-3xl md:text-4xl font-bold tracking-tight text-white">LinkedIn Settings</h1>
                    <p class="text-zinc-400 mt-2">Manage the LinkedIn profile URL connected to your website's navbar.</p>
                </div>
                
                <!-- Tombol Panggil Modal Create -->
                <button type="button" onclick="openModal('createModal')" class="px-6 py-3 rounded-full text-sm font-bold bg-white text-black hover:bg-gray-200 transition-all flex items-center gap-2 shadow-[0_0_15px_rgba(255,255,255,0.15)] w-fit">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Add LinkedIn URL
                </button>
            </div>

            <!-- Tabel Data -->
            <div class="bg-[#141414] border border-white/10 rounded-3xl overflow-hidden shadow-2xl">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-white/[0.02] border-b border-white/10 text-xs uppercase tracking-widest text-zinc-500">
                                <th class="p-6 font-semibold w-1/4">Platform</th>
                                <th class="p-6 font-semibold w-1/2">Active URL</th>
                                <th class="p-6 font-semibold text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="linkedinTableBody" class="divide-y divide-white/5 text-sm">
                            
                            <!-- Item Dummy -->
                            <tr id="row-1" class="hover:bg-white/[0.02] transition-colors group">
                                <td class="p-6">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-blue-500/10 flex items-center justify-center text-blue-400 border border-blue-500/20">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                                        </div>
                                        <div class="font-bold text-white text-base">LinkedIn</div>
                                    </div>
                                </td>
                                <td class="p-6">
                                    <a href="https://linkedin.com/in/yourusername" target="_blank" class="text-zinc-400 font-jetbrains hover:text-blue-400 transition-colors truncate block max-w-sm">
                                        https://linkedin.com/in/yourusername
                                    </a>
                                </td>
                                <td class="p-6">
                                    <div class="flex items-center justify-end gap-3 opacity-100 md:opacity-0 group-hover:opacity-100 transition-opacity">
                                        <!-- View -->
                                        <button type="button" onclick="openViewModal('https://linkedin.com/in/yourusername')" class="w-8 h-8 rounded-full bg-white/5 flex items-center justify-center text-zinc-400 hover:text-white hover:bg-white/10 transition-colors" title="View">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        </button>
                                        <!-- Edit -->
                                        <button type="button" onclick="openEditModal('https://linkedin.com/in/yourusername', 'row-1')" class="w-8 h-8 rounded-full bg-blue-500/10 flex items-center justify-center text-blue-400 hover:text-white hover:bg-blue-500/30 transition-colors" title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                        </button>
                                        <!-- Delete -->
                                        <button type="button" onclick="openDeleteModal('row-1')" class="w-8 h-8 rounded-full bg-red-500/10 flex items-center justify-center text-red-400 hover:text-white hover:bg-red-500/30 transition-colors" title="Delete">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <!-- ==========================================
         SEMUA MODAL POP-UP
         ========================================== -->

    <!-- 1. MODAL CREATE -->
    <div id="createModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm opacity-0 pointer-events-none transition-opacity duration-300">
        <div class="bg-[#141414] border border-white/10 rounded-3xl p-8 w-full max-w-md transform scale-95 transition-transform duration-300 shadow-2xl relative modal-content">
            <button type="button" onclick="closeModal('createModal')" class="absolute top-6 right-6 w-8 h-8 rounded-full bg-white/5 flex items-center justify-center text-zinc-400 hover:text-white hover:bg-white/10 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
            <h3 class="text-2xl font-bold text-white mb-2">Add LinkedIn URL</h3>
            <p class="text-zinc-400 text-sm mb-6">Enter your new LinkedIn profile link.</p>
            
            <form id="formCreate" onsubmit="handleCreate(event)">
                @csrf
                <div class="mb-8">
                    <label class="block text-sm font-semibold text-zinc-300 mb-2">Profile URL</label>
                    <input type="url" name="linkedin_url" placeholder="https://linkedin.com/in/username" required class="w-full bg-[#0a0a0a] border border-white/10 rounded-xl px-4 py-3.5 text-white placeholder-zinc-600 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all font-jetbrains text-sm">
                </div>
                <button type="submit" class="w-full px-6 py-3.5 rounded-xl text-sm font-bold bg-white text-black hover:bg-gray-200 transition-all shadow-[0_0_15px_rgba(255,255,255,0.15)]">Save Link</button>
            </form>
        </div>
    </div>

    <!-- 2. MODAL UPDATE/EDIT -->
    <div id="editModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm opacity-0 pointer-events-none transition-opacity duration-300">
        <div class="bg-[#141414] border border-white/10 rounded-3xl p-8 w-full max-w-md transform scale-95 transition-transform duration-300 shadow-2xl relative modal-content">
            <button type="button" onclick="closeModal('editModal')" class="absolute top-6 right-6 w-8 h-8 rounded-full bg-white/5 flex items-center justify-center text-zinc-400 hover:text-white hover:bg-white/10 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
            <h3 class="text-2xl font-bold text-white mb-2">Edit LinkedIn URL</h3>
            <p class="text-zinc-400 text-sm mb-6">Update your existing profile link.</p>
            
            <form id="formEdit" onsubmit="handleEdit(event)">
                @csrf
                @method('PUT')
                <input type="hidden" id="editRowId">
                <div class="mb-8">
                    <label class="block text-sm font-semibold text-zinc-300 mb-2">Profile URL</label>
                    <input type="url" id="editInputUrl" name="linkedin_url" required class="w-full bg-[#0a0a0a] border border-white/10 rounded-xl px-4 py-3.5 text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all font-jetbrains text-sm">
                </div>
                <button type="submit" class="w-full px-6 py-3.5 rounded-xl text-sm font-bold bg-blue-600 text-white hover:bg-blue-500 transition-all shadow-[0_0_15px_rgba(37,99,235,0.4)]">Update Link</button>
            </form>
        </div>
    </div>

    <!-- 3. MODAL VIEW -->
    <div id="viewModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm opacity-0 pointer-events-none transition-opacity duration-300">
        <div class="bg-[#141414] border border-white/10 rounded-3xl p-8 w-full max-w-md transform scale-95 transition-transform duration-300 shadow-2xl relative text-center modal-content">
            <button type="button" onclick="closeModal('viewModal')" class="absolute top-4 right-4 w-8 h-8 rounded-full bg-white/5 flex items-center justify-center text-zinc-400 hover:text-white hover:bg-white/10 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>

            <div class="w-16 h-16 rounded-2xl bg-blue-500/10 flex items-center justify-center text-blue-400 border border-blue-500/20 mx-auto mb-6">
                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
            </div>
            
            <h3 class="text-2xl font-bold text-white mb-2">LinkedIn Profile</h3>
            <p class="text-[10px] uppercase tracking-widest text-zinc-500 font-bold mb-4">Active URL</p>
            
            <a id="viewDisplayUrl" href="#" target="_blank" class="block p-4 rounded-xl bg-[#0a0a0a] border border-white/10 text-blue-400 font-jetbrains text-sm hover:bg-white/5 transition-colors break-all">
                https://linkedin.com/...
            </a>
        </div>
    </div>

    <!-- 4. MODAL DELETE -->
    <div id="deleteModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm opacity-0 pointer-events-none transition-opacity duration-300">
        <div class="bg-[#141414] border border-white/10 rounded-3xl p-8 w-full max-w-md transform scale-95 transition-transform duration-300 shadow-2xl text-center modal-content">
            <div class="w-16 h-16 rounded-full bg-red-500/10 flex items-center justify-center text-red-500 mx-auto mb-6">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            </div>
            <h3 class="text-2xl font-bold text-white mb-2">Are you sure?</h3>
            <p class="text-zinc-400 text-sm mb-8">You are about to remove this LinkedIn link from your navigation bar.</p>
            
            <div class="flex gap-4 justify-center">
                <button type="button" onclick="closeModal('deleteModal')" class="px-6 py-2.5 rounded-full text-sm font-bold text-zinc-400 hover:text-white hover:bg-white/5 transition-all w-1/2 border border-white/5">Cancel</button>
                <form id="formDelete" onsubmit="handleDelete(event)" class="w-1/2">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" id="deleteRowId">
                    <button type="submit" class="w-full px-6 py-2.5 rounded-full text-sm font-bold bg-red-500/20 text-red-400 border border-red-500/20 hover:bg-red-500 hover:text-white transition-all shadow-[0_0_15px_rgba(239,68,68,0.2)]">Delete</button>
                </form>
            </div>
        </div>
    </div>

    <!-- SCRIPT LOGIKA MODAL & CRUD ALERT -->
    <script>
        const swalDark = Swal.mixin({
            background: '#141414', color: '#ffffff',
            customClass: { popup: 'border border-white/10 rounded-3xl shadow-2xl' }
        });

        // FUNGSI UMUM BUKA/TUTUP MODAL
        function openModal(modalId) {
            const modal = document.getElementById(modalId);
            const content = modal.querySelector('.modal-content');
            modal.classList.add('modal-active');
            content.classList.add('modal-content-active');
        }

        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            const content = modal.querySelector('.modal-content');
            modal.classList.remove('modal-active');
            content.classList.remove('modal-content-active');
        }

        // --- View Logic ---
        function openViewModal(url) {
            document.getElementById('viewDisplayUrl').href = url;
            document.getElementById('viewDisplayUrl').textContent = url;
            openModal('viewModal');
        }

        // --- Edit Logic ---
        function openEditModal(url, rowId) {
            document.getElementById('editInputUrl').value = url;
            document.getElementById('editRowId').value = rowId;
            openModal('editModal');
        }

        // --- Delete Logic ---
        function openDeleteModal(rowId) {
            document.getElementById('deleteRowId').value = rowId;
            openModal('deleteModal');
        }

        // --- SUBMIT HANDLERS (Simulasi dengan SweetAlert) ---
        function handleCreate(e) {
            e.preventDefault();
            closeModal('createModal');
            swalDark.fire({
                icon: 'success', title: 'Link Added!', text: 'LinkedIn URL has been added.',
                showConfirmButton: false, timer: 1500
            }).then(() => location.reload()); // Refresh page di environment nyata
        }

        function handleEdit(e) {
            e.preventDefault();
            closeModal('editModal');
            swalDark.fire({
                icon: 'success', title: 'Link Updated!', text: 'LinkedIn URL has been successfully updated.',
                showConfirmButton: false, timer: 1500
            }).then(() => location.reload());
        }

        function handleDelete(e) {
            e.preventDefault();
            closeModal('deleteModal');
            swalDark.fire({
                icon: 'success', title: 'Deleted!', text: 'The link has been removed.',
                showConfirmButton: false, timer: 1500
            }).then(() => {
                // Hapus baris secara visual
                const rowId = document.getElementById('deleteRowId').value;
                const rowElement = document.getElementById(rowId);
                if(rowElement) {
                    rowElement.style.transition = 'all 0.4s';
                    rowElement.style.opacity = '0';
                    rowElement.style.transform = 'translateX(-20px)';
                    setTimeout(() => rowElement.remove(), 400);
                }
            });
        }
    </script>
</body>
</html>