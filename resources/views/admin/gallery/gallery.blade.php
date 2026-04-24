<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Gallery</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Albert+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        body { font-family: 'Albert Sans', sans-serif; background-color: #0a0a0a; color: #ffffff; }
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #171717; }
        ::-webkit-scrollbar-thumb { background: #333; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #444; }
        .hide-scrollbar::-webkit-scrollbar { display: none; }
        .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="antialiased selection:bg-white selection:text-black flex min-h-screen">

    <!-- Memanggil Sidebar Admin -->
    @include('admin.partials.sidebar')

    <main class="flex-1 overflow-y-auto bg-[#0a0a0a] relative">
        <!-- Efek Blur Background -->
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full max-w-3xl h-[300px] bg-blue-500/10 blur-[120px] rounded-full pointer-events-none -z-10"></div>

        <div class="p-6 md:p-12 lg:p-16 max-w-6xl mx-auto">
            
            <!-- Bagian Header -->
            <div class="mb-10 flex flex-col md:flex-row md:items-end justify-between gap-6">
                <div>
                    <div class="flex items-center gap-2 text-sm text-zinc-500 font-medium mb-3">
                        <span class="text-white">Admin</span>
                        <span>/</span>
                        <span class="text-white">Gallery</span>
                    </div>
                    <h1 class="text-3xl md:text-4xl font-bold tracking-tight text-white">Photo Gallery</h1>
                    <p class="text-zinc-400 mt-2">Kelola koleksi foto, karya, atau momen di galeri Anda.</p>
                </div>
                
                <!-- Tombol Trigger Modal Tambah (Create) -->
                <button type="button" onclick="openCreateModal()" class="px-6 py-3 rounded-full text-sm font-bold bg-white text-black hover:bg-gray-200 transition-all flex items-center gap-2 shadow-[0_0_15px_rgba(255,255,255,0.15)] w-fit">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Tambah Foto Baru
                </button>
            </div>

            <!-- Bagian Tabel -->
            <div class="bg-[#141414] border border-white/10 rounded-3xl overflow-hidden shadow-2xl">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-white/[0.02] border-b border-white/10 text-xs uppercase tracking-widest text-zinc-500">
                                <th class="p-6 font-semibold w-32">Gambar</th>
                                <th class="p-6 font-semibold">Judul</th>
                                <th class="p-6 font-semibold hidden md:table-cell">Deskripsi Singkat</th>
                                <th class="p-6 font-semibold text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="galleryTableBody" class="divide-y divide-white/5 text-sm">
                            
                            <!-- Baris Dummy Data 1 -->
                            <tr id="row-1" class="hover:bg-white/[0.02] transition-colors group">
                                <td class="p-6">
                                    <!-- Menampilkan Gambar -->
                                    <div class="w-24 h-16 rounded-lg overflow-hidden border border-white/10 bg-white/5">
                                        <img src="https://images.unsplash.com/photo-1682687220742-aba13b6e50ba?q=80&w=300" class="w-full h-full object-cover opacity-90 hover:scale-110 transition-transform duration-500" alt="Mountain Landscape">
                                    </div>
                                </td>
                                <td class="p-6 font-bold text-white text-base">Mountain Landscape</td>
                                <td class="p-6 text-zinc-400 max-w-xs truncate hidden md:table-cell">
                                    Pemandangan gunung di pagi hari dengan kabut tipis dan cahaya matahari yang hangat.
                                </td>
                                <td class="p-6">
                                    <div class="flex items-center justify-end gap-3 opacity-100 md:opacity-0 group-hover:opacity-100 transition-opacity">
                                        <!-- Tombol View -->
                                        <button type="button" onclick="openViewModal('Mountain Landscape', 'Pemandangan gunung di pagi hari dengan kabut tipis dan cahaya matahari yang hangat. Diambil saat perjalanan musim dingin tahun lalu.', 'https://images.unsplash.com/photo-1682687220742-aba13b6e50ba?q=80&w=800')" class="w-8 h-8 rounded-full bg-white/5 flex items-center justify-center text-zinc-400 hover:text-white hover:bg-white/10 transition-colors" title="Lihat Detail">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        </button>
                                        <!-- Tombol Edit -->
                                        <button type="button" onclick="openEditModal('1', 'Mountain Landscape', 'Pemandangan gunung di pagi hari dengan kabut tipis dan cahaya matahari yang hangat. Diambil saat perjalanan musim dingin tahun lalu.', 'https://images.unsplash.com/photo-1682687220742-aba13b6e50ba?q=80&w=400')" class="w-8 h-8 rounded-full bg-blue-500/10 flex items-center justify-center text-blue-400 hover:text-white hover:bg-blue-500/30 transition-colors" title="Ubah Data">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                        </button>
                                        <!-- Tombol Delete -->
                                        <button type="button" onclick="openDeleteModal('Mountain Landscape', 'row-1')" class="w-8 h-8 rounded-full bg-red-500/10 flex items-center justify-center text-red-400 hover:text-white hover:bg-red-500/30 transition-colors" title="Hapus">
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

    <!-- ==================== BAGIAN MODALS ==================== -->

    <!-- 1. MODAL TAMBAH GAMBAR (CREATE) -->
    <div id="createModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm opacity-0 pointer-events-none transition-opacity duration-300 p-4">
        <div id="createModalContent" class="bg-[#141414] border border-white/10 rounded-3xl p-8 md:p-10 w-full max-w-2xl max-h-[90vh] overflow-y-auto transform scale-95 transition-transform duration-300 shadow-2xl relative">
            <button type="button" onclick="closeCreateModal()" class="absolute top-6 right-6 w-8 h-8 rounded-full bg-white/5 flex items-center justify-center text-zinc-400 hover:text-white hover:bg-white/10 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
            
            <div class="mb-8">
                <h2 class="text-3xl font-bold tracking-tight text-white">Tambah Foto ke Galeri</h2>
                <p class="text-zinc-400 mt-2">Unggah gambar baru beserta judul dan deskripsi singkat.</p>
            </div>

            <form id="createGalleryForm" action="#" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="space-y-6">
                    <!-- Input Gambar -->
                    <div>
                        <label class="block text-sm font-semibold text-zinc-300 mb-2">Unggah Gambar</label>
                        <div class="relative group border-2 border-dashed border-white/10 rounded-xl bg-[#0a0a0a] hover:bg-white/5 hover:border-white/20 transition-all p-6 text-center cursor-pointer min-h-[200px] flex flex-col items-center justify-center">
                            <input type="file" id="createPhoto" name="photo" accept="image/*" required class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                            
                            <div class="w-16 h-16 rounded-full bg-blue-500/10 flex items-center justify-center text-blue-400 mb-4 group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                            <div>
                                <p class="text-sm text-white font-medium">Klik untuk mengunggah atau tarik file ke sini</p>
                                <p class="text-xs text-zinc-500 mt-1 uppercase tracking-widest">SVG, PNG, JPG (MAX. 5MB)</p>
                            </div>
                        </div>
                    </div>

                    <!-- Input Judul -->
                    <div>
                        <label class="block text-sm font-semibold text-zinc-300 mb-2">Judul Gambar</label>
                        <input type="text" id="createTitle" name="title" placeholder="Contoh: Pemandangan Alam" required class="w-full bg-[#0a0a0a] border border-white/10 rounded-xl px-4 py-3 text-white placeholder-zinc-600 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all">
                    </div>

                    <!-- Input Deskripsi Singkat -->
                    <div>
                        <label class="block text-sm font-semibold text-zinc-300 mb-2">Deskripsi Singkat</label>
                        <textarea id="createDescription" name="description" rows="4" placeholder="Tuliskan deskripsi singkat mengenai gambar ini..." required class="w-full bg-[#0a0a0a] border border-white/10 rounded-xl px-4 py-3 text-white placeholder-zinc-600 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all resize-none"></textarea>
                    </div>
                </div>

                <div class="flex justify-end gap-4 mt-8 pt-6 border-t border-white/10">
                    <button type="button" onclick="closeCreateModal()" class="px-6 py-3 rounded-full text-sm font-bold text-zinc-400 hover:text-white hover:bg-white/5 transition-all">Batal</button>
                    <button type="submit" class="px-8 py-3 rounded-full text-sm font-bold bg-white text-black hover:bg-gray-200 hover:scale-105 transition-all shadow-[0_0_20px_rgba(255,255,255,0.2)]">Simpan Gambar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- 2. MODAL UBAH GAMBAR (UPDATE / EDIT) -->
    <div id="editModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm opacity-0 pointer-events-none transition-opacity duration-300 p-4">
        <div id="editModalContent" class="bg-[#141414] border border-white/10 rounded-3xl p-8 md:p-10 w-full max-w-2xl max-h-[90vh] overflow-y-auto transform scale-95 transition-transform duration-300 shadow-2xl relative">
            <button type="button" onclick="closeEditModal()" class="absolute top-6 right-6 w-8 h-8 rounded-full bg-white/5 flex items-center justify-center text-zinc-400 hover:text-white hover:bg-white/10 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
            
            <div class="mb-8">
                <h2 class="text-3xl font-bold tracking-tight text-white">Ubah Data Galeri</h2>
                <p class="text-zinc-400 mt-2">Perbarui gambar, judul, atau deskripsi singkat.</p>
            </div>

            <form id="editGalleryForm" action="#" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" id="editGalleryId" name="id">

                <div class="space-y-6">
                    <!-- Ubah Gambar -->
                    <div>
                        <label class="block text-sm font-semibold text-zinc-300 mb-2">Gambar Saat Ini</label>
                        <div class="mb-3 w-full h-40 rounded-xl overflow-hidden border border-white/10 relative bg-white/5">
                            <img id="editPhotoPreview" src="" alt="Current Photo" class="w-full h-full object-cover opacity-80">
                            <span class="absolute top-3 right-3 text-[10px] uppercase tracking-widest font-bold bg-black/60 backdrop-blur-md px-3 py-1.5 rounded-md text-white border border-white/10">Current Image</span>
                        </div>

                        <div class="relative group border-2 border-dashed border-white/10 rounded-xl bg-[#0a0a0a] hover:bg-white/5 transition-all p-4 text-center cursor-pointer flex flex-col justify-center items-center">
                            <input type="file" name="photo" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                            <p class="text-sm text-zinc-400 font-medium group-hover:text-white transition-colors mb-1">Pilih gambar baru untuk menggantikan (opsional)</p>
                            <p class="text-[10px] text-zinc-600">Biarkan kosong jika tidak ingin mengubah gambar.</p>
                        </div>
                    </div>

                    <!-- Ubah Judul -->
                    <div>
                        <label class="block text-sm font-semibold text-zinc-300 mb-2">Judul Gambar</label>
                        <input type="text" id="editTitle" name="title" required class="w-full bg-[#0a0a0a] border border-white/10 rounded-xl px-4 py-3 text-white focus:border-blue-500 outline-none transition-all">
                    </div>

                    <!-- Ubah Deskripsi -->
                    <div>
                        <label class="block text-sm font-semibold text-zinc-300 mb-2">Deskripsi Singkat</label>
                        <textarea id="editDescription" name="description" rows="4" required class="w-full bg-[#0a0a0a] border border-white/10 rounded-xl px-4 py-3 text-white focus:border-blue-500 outline-none transition-all resize-none"></textarea>
                    </div>
                </div>

                <div class="flex justify-end gap-4 mt-8 pt-6 border-t border-white/10">
                    <button type="button" onclick="closeEditModal()" class="px-6 py-3 rounded-full text-sm font-bold text-zinc-400 hover:text-white hover:bg-white/5 transition-all">Batal</button>
                    <button type="submit" class="px-8 py-3 rounded-full text-sm font-bold bg-blue-600 text-white hover:bg-blue-500 hover:scale-105 transition-all shadow-[0_0_20px_rgba(37,99,235,0.4)]">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- 3. MODAL LIHAT DETAIL (VIEW) -->
    <div id="viewModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm opacity-0 pointer-events-none transition-opacity duration-300 p-4">
        <!-- Layout View Galeri (Gambar di atas, teks di bawah) -->
        <div id="viewModalContent" class="bg-[#141414] border border-white/10 rounded-3xl p-0 w-full max-w-3xl transform scale-95 transition-transform duration-300 shadow-2xl overflow-hidden flex flex-col max-h-[90vh]">
            
            <!-- Area Gambar -->
            <div class="w-full h-64 md:h-80 relative bg-[#0a0a0a]">
                <img id="viewImage" src="" alt="Gallery Image" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-[#141414] via-transparent to-transparent"></div>
                <button type="button" onclick="closeViewModal()" class="absolute top-6 right-6 w-8 h-8 rounded-full bg-black/50 backdrop-blur-sm flex items-center justify-center text-zinc-300 hover:text-white border border-white/10 hover:bg-white/20 transition-colors z-10">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <!-- Area Teks Detail -->
            <div class="p-8 md:p-10 flex flex-col relative overflow-y-auto hide-scrollbar">
                <span class="text-[10px] font-bold tracking-widest text-zinc-500 uppercase mb-3 block">Detail Galeri</span>
                <h3 id="viewTitle" class="text-3xl font-bold text-white mb-4 leading-tight"></h3>
                <p id="viewDescription" class="text-zinc-400 text-sm leading-relaxed mb-8 whitespace-pre-line"></p>
                
                <div class="mt-auto border-t border-white/10 pt-6">
                    <button type="button" id="viewEditBtn" class="px-6 py-2.5 rounded-full text-sm font-bold bg-white text-black hover:bg-gray-200 transition-all text-center shadow-[0_0_15px_rgba(255,255,255,0.15)] w-fit">
                        Ubah Data Ini
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- 4. MODAL KONFIRMASI HAPUS (DELETE) -->
    <div id="deleteModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm opacity-0 pointer-events-none transition-opacity duration-300 p-4">
        <div id="deleteModalContent" class="bg-[#141414] border border-white/10 rounded-3xl p-8 w-full max-w-md transform scale-95 transition-transform duration-300 shadow-2xl text-center">
            <div class="w-16 h-16 rounded-full bg-red-500/10 flex items-center justify-center text-red-500 mx-auto mb-6">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            </div>
            <h3 class="text-2xl font-bold text-white mb-2">Apakah Anda yakin?</h3>
            <p class="text-zinc-400 text-sm mb-8">Anda akan menghapus gambar <span id="deleteGalleryName" class="font-bold text-white"></span>. Tindakan ini tidak dapat dibatalkan.</p>
            
            <div class="flex gap-4 justify-center">
                <button type="button" onclick="closeDeleteModal()" class="px-6 py-2.5 rounded-full text-sm font-bold text-zinc-400 hover:text-white hover:bg-white/5 transition-all w-1/2 border border-white/5">Batal</button>
                <form id="deleteGalleryForm" action="#" method="POST" class="w-1/2">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" id="deleteRowId" value="">
                    <button type="submit" class="w-full px-6 py-2.5 rounded-full text-sm font-bold bg-red-500/20 text-red-400 border border-red-500/20 hover:bg-red-500 hover:text-white transition-all shadow-[0_0_15px_rgba(239,68,68,0.2)]">Hapus</button>
                </form>
            </div>
        </div>
    </div>

    <!-- JS Logic & Validasi SweetAlert -->
    <script>
        // Konfigurasi SweetAlert dengan tema gelap (Dark Mode)
        const swalDark = Swal.mixin({
            background: '#141414',
            color: '#ffffff',
            customClass: {
                popup: 'border border-white/10 rounded-3xl shadow-2xl',
                confirmButton: 'px-8 py-3 rounded-full text-sm font-bold bg-white text-black hover:bg-gray-200 transition-all focus:outline-none focus:ring-0',
            },
            buttonsStyling: false
        });

        // ==================== MODAL TAMBAH (CREATE) ====================
        const createModal = document.getElementById('createModal');
        const createModalContent = document.getElementById('createModalContent');
        const createForm = document.getElementById('createGalleryForm');

        function openCreateModal() {
            createForm.reset();
            createModal.classList.remove('opacity-0', 'pointer-events-none');
            createModalContent.classList.remove('scale-95');
        }

        function closeCreateModal() {
            createModal.classList.add('opacity-0', 'pointer-events-none');
            createModalContent.classList.add('scale-95');
        }

        createForm.addEventListener('submit', function(e) {
            e.preventDefault(); 
            closeCreateModal();
            swalDark.fire({
                icon: 'success',
                title: 'Berhasil Disimpan!',
                text: 'Gambar baru telah ditambahkan ke galeri Anda.',
                showConfirmButton: false,
                timer: 2000
            }).then(() => {
                location.reload(); // Dummy reload
            });
        });

        // ==================== MODAL UBAH (EDIT) ====================
        const editModal = document.getElementById('editModal');
        const editModalContent = document.getElementById('editModalContent');
        const editForm = document.getElementById('editGalleryForm');
        
        function openEditModal(id, title, description, imgSrc) {
            document.getElementById('editGalleryId').value = id;
            document.getElementById('editTitle').value = title;
            document.getElementById('editDescription').value = description;
            document.getElementById('editPhotoPreview').src = imgSrc;

            closeViewModal(); // Tutup modal View bila sedang terbuka
            editModal.classList.remove('opacity-0', 'pointer-events-none');
            editModalContent.classList.remove('scale-95');
        }

        function closeEditModal() {
            editModal.classList.add('opacity-0', 'pointer-events-none');
            editModalContent.classList.add('scale-95');
        }

        editForm.addEventListener('submit', function(e) {
            e.preventDefault(); 
            closeEditModal();
            Swal.fire({
                background: '#141414',
                color: '#ffffff',
                icon: 'success',
                title: 'Perubahan Disimpan!',
                text: 'Data gambar telah berhasil diperbarui.',
                showConfirmButton: false,
                timer: 2000,
                customClass: { popup: 'border border-white/10 rounded-3xl shadow-2xl' }
            }).then(() => {
                location.reload();
            });
        });

        // ==================== MODAL LIHAT DETAIL (VIEW) ====================
        const viewModal = document.getElementById('viewModal');
        const viewModalContent = document.getElementById('viewModalContent');

        function openViewModal(title, description, imgSrc) {
            document.getElementById('viewTitle').textContent = title;
            document.getElementById('viewDescription').textContent = description;
            document.getElementById('viewImage').src = imgSrc;

            // Memastikan tombol "Ubah Data Ini" pada View membuka modal edit yang relevan
            document.getElementById('viewEditBtn').onclick = () => openEditModal('1', title, description, imgSrc);

            viewModal.classList.remove('opacity-0', 'pointer-events-none');
            viewModalContent.classList.remove('scale-95');
        }

        function closeViewModal() {
            viewModal.classList.add('opacity-0', 'pointer-events-none');
            viewModalContent.classList.add('scale-95');
        }

        // ==================== MODAL HAPUS (DELETE) ====================
        const deleteModal = document.getElementById('deleteModal');
        const deleteContent = document.getElementById('deleteModalContent');
        const deleteNameSpan = document.getElementById('deleteGalleryName');
        const deleteRowInput = document.getElementById('deleteRowId');

        function openDeleteModal(title, rowId) {
            // Singkat judul apabila terlalu panjang di dalam modal konfirmasi
            const shortTitle = title.length > 30 ? title.substring(0, 30) + '...' : title;
            deleteNameSpan.textContent = `"${shortTitle}"`;
            deleteRowInput.value = rowId;
            
            deleteModal.classList.remove('opacity-0', 'pointer-events-none');
            deleteContent.classList.remove('scale-95');
        }

        function closeDeleteModal() {
            deleteModal.classList.add('opacity-0', 'pointer-events-none');
            deleteContent.classList.add('scale-95');
        }

        document.getElementById('deleteGalleryForm').addEventListener('submit', function(e) {
            e.preventDefault(); 
            closeDeleteModal();
            swalDark.fire({
                icon: 'success',
                title: 'Dihapus!',
                text: 'Gambar telah dihapus dari galeri.',
                showConfirmButton: false,
                timer: 2000
            }).then(() => {
                // Efek animasi menghapus baris dari tabel
                const rowId = document.getElementById('deleteRowId').value;
                const rowElement = document.getElementById(rowId);
                if(rowElement) {
                    rowElement.style.transition = 'all 0.5s ease';
                    rowElement.style.opacity = '0';
                    rowElement.style.transform = 'translateX(-20px)';
                    setTimeout(() => rowElement.remove(), 500);
                }
            });
        });
    </script>
</body>
</html>