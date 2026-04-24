<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - About Me</title>
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

    @include('admin.partials.sidebar')

    <main class="flex-1 overflow-y-auto bg-[#0a0a0a] relative">
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full max-w-3xl h-[300px] bg-blue-500/10 blur-[120px] rounded-full pointer-events-none -z-10"></div>

        <div class="p-6 md:p-12 lg:p-16 max-w-6xl mx-auto">
            
            <!-- Header Section -->
            <div class="mb-10 flex flex-col md:flex-row md:items-end justify-between gap-6">
                <div>
                    <div class="flex items-center gap-2 text-sm text-zinc-500 font-medium mb-3">
                        <span class="text-white">Admin</span>
                        <span>/</span>
                        <span class="text-white">About Me</span>
                    </div>
                    <h1 class="text-3xl md:text-4xl font-bold tracking-tight text-white">My Story Blocks</h1>
                    <p class="text-zinc-400 mt-2">Manage the zig-zag story sections on your Info page.</p>
                </div>
                
                <!-- Trigger Create Modal -->
                <button type="button" onclick="openCreateModal()" class="px-6 py-3 rounded-full text-sm font-bold bg-white text-black hover:bg-gray-200 transition-all flex items-center gap-2 shadow-[0_0_15px_rgba(255,255,255,0.15)] w-fit">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Add Story Block
                </button>
            </div>

            <!-- Table Section -->
            <div class="bg-[#141414] border border-white/10 rounded-3xl overflow-hidden shadow-2xl">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-white/[0.02] border-b border-white/10 text-xs uppercase tracking-widest text-zinc-500">
                                <th class="p-6 font-semibold w-24">Photo</th>
                                <th class="p-6 font-semibold">Heading Title</th>
                                <th class="p-6 font-semibold hidden md:table-cell">Content Snippet</th>
                                <th class="p-6 font-semibold text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="aboutTableBody" class="divide-y divide-white/5 text-sm">
                            
                            <!-- Dummy Data Row -->
                            <tr id="row-1" class="hover:bg-white/[0.02] transition-colors group">
                                <td class="p-6">
                                    <div class="w-16 h-20 rounded-xl overflow-hidden border border-white/10 bg-white/5">
                                        <img src="https://images.unsplash.com/photo-1490806843957-31f4c9a91c65?q=80&w=200" class="w-full h-full object-cover opacity-90" alt="Japan Street">
                                    </div>
                                </td>
                                <td class="p-6 font-bold text-white text-base">My background in Architecture.</td>
                                <td class="p-6 text-zinc-400 max-w-xs truncate hidden md:table-cell">
                                    In June of 2022, I graduated from architecture school at the University of Toronto...
                                </td>
                                <td class="p-6">
                                    <div class="flex items-center justify-end gap-3 opacity-100 md:opacity-0 group-hover:opacity-100 transition-opacity">
                                        <!-- View Button -->
                                        <button type="button" onclick="openViewModal('My background in Architecture.', 'In June of 2022, I graduated from architecture school at the University of Toronto. There, I became obsessed with architectural visualization.\n\nI was deeply fascinated in the concepts of modularity and adaptability.', 'https://images.unsplash.com/photo-1490806843957-31f4c9a91c65?q=80&w=600')" class="w-8 h-8 rounded-full bg-white/5 flex items-center justify-center text-zinc-400 hover:text-white hover:bg-white/10 transition-colors" title="View Details">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        </button>
                                        <!-- Edit Button -->
                                        <button type="button" onclick="openEditModal('1', 'My background in Architecture.', 'In June of 2022, I graduated from architecture school at the University of Toronto. There, I became obsessed with architectural visualization.\n\nI was deeply fascinated in the concepts of modularity and adaptability.', 'https://images.unsplash.com/photo-1490806843957-31f4c9a91c65?q=80&w=300')" class="w-8 h-8 rounded-full bg-blue-500/10 flex items-center justify-center text-blue-400 hover:text-white hover:bg-blue-500/30 transition-colors" title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                        </button>
                                        <!-- Delete Button -->
                                        <button type="button" onclick="openDeleteModal('My background in Architecture.', 'row-1')" class="w-8 h-8 rounded-full bg-red-500/10 flex items-center justify-center text-red-400 hover:text-white hover:bg-red-500/30 transition-colors" title="Delete">
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

    <!-- ==================== MODALS SECTION ==================== -->

    <!-- 1. MODAL CREATE STORY BLOCK -->
    <div id="createModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm opacity-0 pointer-events-none transition-opacity duration-300 p-4">
        <div id="createModalContent" class="bg-[#141414] border border-white/10 rounded-3xl p-8 md:p-10 w-full max-w-4xl max-h-[90vh] overflow-y-auto transform scale-95 transition-transform duration-300 shadow-2xl relative">
            <button type="button" onclick="closeCreateModal()" class="absolute top-6 right-6 w-8 h-8 rounded-full bg-white/5 flex items-center justify-center text-zinc-400 hover:text-white hover:bg-white/10 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
            
            <div class="mb-8">
                <h2 class="text-3xl font-bold tracking-tight text-white">Add Story Block</h2>
                <p class="text-zinc-400 mt-2">Add a new photo and story paragraph. Max 6 blocks recommended for the best layout.</p>
            </div>

            <form id="createAboutForm" action="#" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-semibold text-zinc-300 mb-2">Heading Title (Optional)</label>
                            <input type="text" id="createTitle" name="title" placeholder="e.g. My background in Architecture." class="w-full bg-[#0a0a0a] border border-white/10 rounded-xl px-4 py-3 text-white placeholder-zinc-600 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-zinc-300 mb-2">Story Content</label>
                            <textarea id="createContent" name="content" rows="8" placeholder="Write your story paragraph here. Press Enter to create new paragraphs..." required class="w-full bg-[#0a0a0a] border border-white/10 rounded-xl px-4 py-3 text-white placeholder-zinc-600 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all resize-none"></textarea>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-zinc-300 mb-2">Portrait Photo</label>
                        <div class="relative group border-2 border-dashed border-white/10 rounded-xl bg-[#0a0a0a] hover:bg-white/5 hover:border-white/20 transition-all p-6 text-center cursor-pointer h-[calc(100%-2rem)] min-h-[250px] flex flex-col items-center justify-center">
                            <input type="file" id="createPhoto" name="photo" accept="image/*" required class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                            
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

                <div class="flex justify-end gap-4 mt-8 pt-6 border-t border-white/10">
                    <button type="button" onclick="closeCreateModal()" class="px-6 py-3 rounded-full text-sm font-bold text-zinc-400 hover:text-white hover:bg-white/5 transition-all">Cancel</button>
                    <button type="submit" class="px-8 py-3 rounded-full text-sm font-bold bg-white text-black hover:bg-gray-200 hover:scale-105 transition-all shadow-[0_0_20px_rgba(255,255,255,0.2)]">Publish Block</button>
                </div>
            </form>
        </div>
    </div>

    <!-- 2. MODAL EDIT STORY BLOCK -->
    <div id="editModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm opacity-0 pointer-events-none transition-opacity duration-300 p-4">
        <div id="editModalContent" class="bg-[#141414] border border-white/10 rounded-3xl p-8 md:p-10 w-full max-w-4xl max-h-[90vh] overflow-y-auto transform scale-95 transition-transform duration-300 shadow-2xl relative">
            <button type="button" onclick="closeEditModal()" class="absolute top-6 right-6 w-8 h-8 rounded-full bg-white/5 flex items-center justify-center text-zinc-400 hover:text-white hover:bg-white/10 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
            
            <div class="mb-8">
                <h2 class="text-3xl font-bold tracking-tight text-white">Edit Story Block</h2>
                <p class="text-zinc-400 mt-2">Update the photo or text content for this section.</p>
            </div>

            <form id="editAboutForm" action="#" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" id="editBlockId" name="id">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-semibold text-zinc-300 mb-2">Heading Title (Optional)</label>
                            <input type="text" id="editTitle" name="title" class="w-full bg-[#0a0a0a] border border-white/10 rounded-xl px-4 py-3 text-white focus:border-blue-500 outline-none transition-all">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-zinc-300 mb-2">Story Content</label>
                            <textarea id="editContent" name="content" rows="8" required class="w-full bg-[#0a0a0a] border border-white/10 rounded-xl px-4 py-3 text-white focus:border-blue-500 outline-none transition-all resize-none"></textarea>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-zinc-300 mb-2">Portrait Photo (Current)</label>
                        
                        <div class="mb-3 w-32 mx-auto h-40 rounded-xl overflow-hidden border border-white/10 flex items-center justify-center relative bg-white/5">
                            <img id="editPhotoPreview" src="" alt="Current Photo" class="w-full h-full object-cover opacity-80">
                            <span class="absolute top-2 right-2 text-[8px] uppercase tracking-widest font-bold bg-black/50 backdrop-blur-md px-2 py-1 rounded-md text-white">Current</span>
                        </div>

                        <div class="relative group border-2 border-dashed border-white/10 rounded-xl bg-[#0a0a0a] hover:bg-white/5 transition-all p-6 text-center cursor-pointer max-w-sm mx-auto flex flex-col justify-center items-center">
                            <input type="file" name="photo" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                            <p class="text-sm text-zinc-400 font-medium group-hover:text-white transition-colors mb-1">Select new image to replace</p>
                            <p class="text-[10px] text-zinc-600">Leave blank to keep current photo.</p>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-4 mt-8 pt-6 border-t border-white/10">
                    <button type="button" onclick="closeEditModal()" class="px-6 py-3 rounded-full text-sm font-bold text-zinc-400 hover:text-white hover:bg-white/5 transition-all">Cancel</button>
                    <button type="submit" class="px-8 py-3 rounded-full text-sm font-bold bg-blue-600 text-white hover:bg-blue-500 hover:scale-105 transition-all shadow-[0_0_20px_rgba(37,99,235,0.4)]">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    <!-- 3. MODAL VIEW DETAILS -->
    <div id="viewModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm opacity-0 pointer-events-none transition-opacity duration-300 p-4">
        <div id="viewModalContent" class="bg-[#141414] border border-white/10 rounded-3xl p-0 w-full max-w-4xl transform scale-95 transition-transform duration-300 shadow-2xl overflow-hidden flex flex-col md:flex-row max-h-[90vh]">
            <div class="w-full md:w-5/12 h-64 md:h-auto relative">
                <img id="viewImage" src="" alt="Story Image" class="w-full h-full object-cover opacity-90">
                <div class="absolute inset-0 bg-gradient-to-t from-[#141414] to-transparent md:bg-gradient-to-r md:from-transparent md:to-[#141414]"></div>
            </div>
            
            <div class="p-8 md:p-12 w-full md:w-7/12 flex flex-col justify-center relative overflow-y-auto hide-scrollbar">
                <button type="button" onclick="closeViewModal()" class="absolute top-6 right-6 w-8 h-8 rounded-full bg-white/5 flex items-center justify-center text-zinc-400 hover:text-white hover:bg-white/10 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
                
                <span class="text-[10px] font-bold tracking-widest text-zinc-500 uppercase mb-4 block">Story Preview</span>
                <h3 id="viewTitle" class="text-3xl font-bold text-white mb-6 leading-tight"></h3>
                
                <p id="viewContent" class="text-zinc-400 text-sm leading-relaxed mb-8 whitespace-pre-line"></p>
                
                <button type="button" id="viewEditBtn" class="px-6 py-3 rounded-full text-sm font-bold bg-white text-black hover:bg-gray-200 transition-all text-center shadow-[0_0_15px_rgba(255,255,255,0.15)] w-fit mt-auto">
                    Edit Block
                </button>
            </div>
        </div>
    </div>

    <!-- 4. MODAL DELETE CONFIRMATION -->
    <div id="deleteModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm opacity-0 pointer-events-none transition-opacity duration-300 p-4">
        <div id="deleteModalContent" class="bg-[#141414] border border-white/10 rounded-3xl p-8 w-full max-w-md transform scale-95 transition-transform duration-300 shadow-2xl text-center">
            <div class="w-16 h-16 rounded-full bg-red-500/10 flex items-center justify-center text-red-500 mx-auto mb-6">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            </div>
            <h3 class="text-2xl font-bold text-white mb-2">Are you sure?</h3>
            <p class="text-zinc-400 text-sm mb-8">You are about to delete the <span id="deleteBlockName" class="font-bold text-white"></span> story block.</p>
            
            <div class="flex gap-4 justify-center">
                <button type="button" onclick="closeDeleteModal()" class="px-6 py-2.5 rounded-full text-sm font-bold text-zinc-400 hover:text-white hover:bg-white/5 transition-all w-1/2 border border-white/5">Cancel</button>
                <form id="deleteBlockForm" action="#" method="POST" class="w-1/2">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" id="deleteRowId" value="">
                    <button type="submit" class="w-full px-6 py-2.5 rounded-full text-sm font-bold bg-red-500/20 text-red-400 border border-red-500/20 hover:bg-red-500 hover:text-white transition-all shadow-[0_0_15px_rgba(239,68,68,0.2)]">Delete</button>
                </form>
            </div>
        </div>
    </div>

    <!-- JS Logic & SweetAlert -->
    <script>
        const swalDark = Swal.mixin({
            background: '#141414',
            color: '#ffffff',
            customClass: {
                popup: 'border border-white/10 rounded-3xl shadow-2xl',
                confirmButton: 'px-8 py-3 rounded-full text-sm font-bold bg-white text-black hover:bg-gray-200 transition-all focus:outline-none focus:ring-0',
            },
            buttonsStyling: false
        });

        // ==================== CREATE MODAL ====================
        const createModal = document.getElementById('createModal');
        const createModalContent = document.getElementById('createModalContent');
        const createForm = document.getElementById('createAboutForm');

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
                title: 'Block Added!',
                text: 'Your story block has been saved.',
                showConfirmButton: false,
                timer: 2000
            }).then(() => {
                location.reload();
            });
        });

        // ==================== EDIT MODAL ====================
        const editModal = document.getElementById('editModal');
        const editModalContent = document.getElementById('editModalContent');
        const editForm = document.getElementById('editAboutForm');
        
        function openEditModal(id, title, content, imgSrc) {
            document.getElementById('editBlockId').value = id;
            document.getElementById('editTitle').value = title;
            document.getElementById('editContent').value = content;
            document.getElementById('editPhotoPreview').src = imgSrc;

            closeViewModal();
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
                title: 'Changes Saved!',
                text: 'Your story block has been updated.',
                showConfirmButton: false,
                timer: 2000,
                customClass: { popup: 'border border-white/10 rounded-3xl shadow-2xl' }
            }).then(() => {
                location.reload();
            });
        });

        // ==================== VIEW MODAL ====================
        const viewModal = document.getElementById('viewModal');
        const viewModalContent = document.getElementById('viewModalContent');

        function openViewModal(title, content, imgSrc) {
            document.getElementById('viewTitle').textContent = title;
            document.getElementById('viewContent').textContent = content;
            document.getElementById('viewImage').src = imgSrc;

            // Atur tombol Edit yang ada di dalam modal View agar membuka modal Edit
            document.getElementById('viewEditBtn').onclick = () => openEditModal('1', title, content, imgSrc);

            viewModal.classList.remove('opacity-0', 'pointer-events-none');
            viewModalContent.classList.remove('scale-95');
        }

        function closeViewModal() {
            viewModal.classList.add('opacity-0', 'pointer-events-none');
            viewModalContent.classList.add('scale-95');
        }

        // ==================== DELETE MODAL ====================
        const deleteModal = document.getElementById('deleteModal');
        const deleteContent = document.getElementById('deleteModalContent');
        const deleteNameSpan = document.getElementById('deleteBlockName');
        const deleteRowInput = document.getElementById('deleteRowId');

        function openDeleteModal(title, rowId) {
            // Persingkat judul jika terlalu panjang di dalam konfirmasi hapus
            const shortTitle = title.length > 30 ? title.substring(0, 30) + '...' : title;
            deleteNameSpan.textContent = shortTitle;
            deleteRowInput.value = rowId;
            deleteModal.classList.remove('opacity-0', 'pointer-events-none');
            deleteContent.classList.remove('scale-95');
        }

        function closeDeleteModal() {
            deleteModal.classList.add('opacity-0', 'pointer-events-none');
            deleteContent.classList.add('scale-95');
        }

        document.getElementById('deleteBlockForm').addEventListener('submit', function(e) {
            e.preventDefault(); 
            closeDeleteModal();
            swalDark.fire({
                icon: 'success',
                title: 'Deleted!',
                text: 'Story block removed.',
                showConfirmButton: false,
                timer: 2000
            }).then(() => {
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

