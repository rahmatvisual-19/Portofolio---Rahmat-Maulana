<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Resume File</title>
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

    <!-- Memanggil Sidebar -->
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
                        <span class="text-white">Resume</span>
                    </div>
                    <h1 class="text-3xl md:text-4xl font-bold tracking-tight text-white">Resume Settings</h1>
                    <p class="text-zinc-400 mt-2">Manage the PDF resume file connected to your website's navbar.</p>
                </div>
                
                <!-- Tombol Panggil Modal Create -->
                <button type="button" onclick="openModal('createModal')" class="px-6 py-3 rounded-full text-sm font-bold bg-white text-black hover:bg-gray-200 transition-all flex items-center gap-2 shadow-[0_0_15px_rgba(255,255,255,0.15)] w-fit">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                    Upload Resume
                </button>
            </div>

            <!-- Tabel Data -->
            <div class="bg-[#141414] border border-white/10 rounded-3xl overflow-hidden shadow-2xl">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-white/[0.02] border-b border-white/10 text-xs uppercase tracking-widest text-zinc-500">
                                <th class="p-6 font-semibold w-1/4">Document Type</th>
                                <th class="p-6 font-semibold w-1/2">Active File</th>
                                <th class="p-6 font-semibold text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="resumeTableBody" class="divide-y divide-white/5 text-sm">
                            
                            <!-- Item Dummy -->
                            <tr id="row-1" class="hover:bg-white/[0.02] transition-colors group">
                                <td class="p-6">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-red-500/10 flex items-center justify-center text-red-400 border border-red-500/20">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                        </div>
                                        <div class="font-bold text-white text-base">PDF Resume</div>
                                    </div>
                                </td>
                                <td class="p-6">
                                    <div class="flex items-center gap-2">
                                        <span class="px-2 py-1 rounded bg-white/5 text-xs text-zinc-400 font-jetbrains border border-white/10">.pdf</span>
                                        <a href="/resume.pdf" target="_blank" class="text-zinc-300 hover:text-blue-400 transition-colors font-medium">
                                            my_resume_2024.pdf
                                        </a>
                                    </div>
                                </td>
                                <td class="p-6">
                                    <div class="flex items-center justify-end gap-3 opacity-100 md:opacity-0 group-hover:opacity-100 transition-opacity">
                                        <!-- View -->
                                        <button type="button" onclick="openViewModal('my_resume_2024.pdf', '/resume.pdf')" class="w-8 h-8 rounded-full bg-white/5 flex items-center justify-center text-zinc-400 hover:text-white hover:bg-white/10 transition-colors" title="View Details">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        </button>
                                        <!-- Edit -->
                                        <button type="button" onclick="openEditModal('my_resume_2024.pdf', 'row-1')" class="w-8 h-8 rounded-full bg-blue-500/10 flex items-center justify-center text-blue-400 hover:text-white hover:bg-blue-500/30 transition-colors" title="Edit/Replace">
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
    <div id="createModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm opacity-0 pointer-events-none transition-opacity duration-300 p-4">
        <div class="bg-[#141414] border border-white/10 rounded-3xl p-8 w-full max-w-md transform scale-95 transition-transform duration-300 shadow-2xl relative modal-content">
            <button type="button" onclick="closeModal('createModal')" class="absolute top-6 right-6 w-8 h-8 rounded-full bg-white/5 flex items-center justify-center text-zinc-400 hover:text-white hover:bg-white/10 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
            <h3 class="text-2xl font-bold text-white mb-2">Upload Resume</h3>
            <p class="text-zinc-400 text-sm mb-6">Upload your latest PDF resume.</p>
            
            <form id="formCreate" onsubmit="handleCreate(event)" enctype="multipart/form-data">
                @csrf
                <div class="mb-8">
                    <label class="block text-sm font-semibold text-zinc-300 mb-2">PDF Document</label>
                    <div class="relative group border-2 border-dashed border-white/10 rounded-2xl bg-[#0a0a0a] hover:bg-white/5 hover:border-white/20 transition-all p-8 text-center cursor-pointer flex items-center justify-center min-h-[160px]">
                        <!-- Input File dibatasi hanya PDF -->
                        <input type="file" id="createFileInput" name="resume_file" accept="application/pdf" required class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" onchange="updateFileName(this, 'createFileName')">
                        
                        <div class="flex flex-col items-center justify-center space-y-3 pointer-events-none">
                            <div class="w-12 h-12 rounded-full bg-blue-500/10 flex items-center justify-center text-blue-400 group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                            </div>
                            <div>
                                <p id="createFileName" class="text-sm text-white font-medium">Click to upload PDF</p>
                                <p class="text-xs text-zinc-500 mt-1 uppercase tracking-wider">MAX. 5MB</p>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" class="w-full px-6 py-3.5 rounded-xl text-sm font-bold bg-white text-black hover:bg-gray-200 transition-all shadow-[0_0_15px_rgba(255,255,255,0.15)]">Save File</button>
            </form>
        </div>
    </div>

    <!-- 2. MODAL UPDATE/EDIT -->
    <div id="editModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm opacity-0 pointer-events-none transition-opacity duration-300 p-4">
        <div class="bg-[#141414] border border-white/10 rounded-3xl p-8 w-full max-w-md transform scale-95 transition-transform duration-300 shadow-2xl relative modal-content">
            <button type="button" onclick="closeModal('editModal')" class="absolute top-6 right-6 w-8 h-8 rounded-full bg-white/5 flex items-center justify-center text-zinc-400 hover:text-white hover:bg-white/10 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
            <h3 class="text-2xl font-bold text-white mb-2">Replace Resume</h3>
            <p class="text-zinc-400 text-sm mb-6">Upload a new PDF to replace the current one.</p>
            
            <form id="formEdit" onsubmit="handleEdit(event)" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" id="editRowId">
                
                <div class="mb-4">
                    <span class="text-xs font-semibold text-zinc-500 uppercase tracking-widest block mb-2">Current File:</span>
                    <div class="px-4 py-3 bg-[#0a0a0a] border border-white/10 rounded-xl text-zinc-300 font-jetbrains text-sm flex items-center gap-3">
                        <svg class="w-4 h-4 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                        <span id="currentFileName">my_resume_2024.pdf</span>
                    </div>
                </div>

                <div class="mb-8">
                    <label class="block text-sm font-semibold text-zinc-300 mb-2 mt-4">Upload New File</label>
                    <div class="relative group border-2 border-dashed border-white/10 rounded-xl bg-[#0a0a0a] hover:bg-white/5 hover:border-white/20 transition-all p-6 text-center cursor-pointer flex items-center justify-center">
                        <input type="file" id="editFileInput" name="resume_file" accept="application/pdf" required class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" onchange="updateFileName(this, 'editFileName')">
                        <div class="pointer-events-none">
                            <p id="editFileName" class="text-sm text-zinc-400 font-medium group-hover:text-white transition-colors">Select new PDF to replace</p>
                        </div>
                    </div>
                </div>
                <button type="submit" class="w-full px-6 py-3.5 rounded-xl text-sm font-bold bg-blue-600 text-white hover:bg-blue-500 transition-all shadow-[0_0_15px_rgba(37,99,235,0.4)]">Update File</button>
            </form>
        </div>
    </div>

    <!-- 3. MODAL VIEW -->
    <div id="viewModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm opacity-0 pointer-events-none transition-opacity duration-300 p-4">
        <div class="bg-[#141414] border border-white/10 rounded-3xl p-8 w-full max-w-sm transform scale-95 transition-transform duration-300 shadow-2xl relative text-center modal-content">
            <button type="button" onclick="closeModal('viewModal')" class="absolute top-4 right-4 w-8 h-8 rounded-full bg-white/5 flex items-center justify-center text-zinc-400 hover:text-white hover:bg-white/10 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>

            <!-- PDF Document Icon -->
            <div class="w-20 h-20 rounded-2xl bg-red-500/10 flex items-center justify-center text-red-400 border border-red-500/20 mx-auto mb-6">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
            </div>
            
            <h3 class="text-xl font-bold text-white mb-2 line-clamp-2" id="viewDisplayFileName"></h3>
            <p class="text-[10px] uppercase tracking-widest text-zinc-500 font-bold mb-8">PDF Document</p>
            
            <!-- Link to open PDF in new tab -->
            <a id="viewDownloadBtn" href="#" target="_blank" class="w-full px-6 py-3.5 rounded-xl text-sm font-bold bg-white text-black hover:bg-gray-200 transition-all shadow-[0_0_15px_rgba(255,255,255,0.15)] flex justify-center items-center gap-2">
                Open Full PDF
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
            </a>
        </div>
    </div>

    <!-- 4. MODAL DELETE -->
    <div id="deleteModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm opacity-0 pointer-events-none transition-opacity duration-300 p-4">
        <div class="bg-[#141414] border border-white/10 rounded-3xl p-8 w-full max-w-md transform scale-95 transition-transform duration-300 shadow-2xl text-center modal-content">
            <div class="w-16 h-16 rounded-full bg-red-500/10 flex items-center justify-center text-red-500 mx-auto mb-6">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            </div>
            <h3 class="text-2xl font-bold text-white mb-2">Are you sure?</h3>
            <p class="text-zinc-400 text-sm mb-8">You are about to permanently delete this resume file from your server.</p>
            
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

        // Live text update saat file PDF dipilih
        function updateFileName(inputElement, displayId) {
            const displayEl = document.getElementById(displayId);
            if (inputElement.files && inputElement.files.length > 0) {
                displayEl.textContent = inputElement.files[0].name;
                displayEl.classList.add('text-blue-400');
                displayEl.classList.remove('text-white', 'text-zinc-400');
            } else {
                displayEl.textContent = displayId === 'createFileName' ? 'Click to upload PDF' : 'Select new PDF to replace';
                displayEl.classList.remove('text-blue-400');
                displayEl.classList.add(displayId === 'createFileName' ? 'text-white' : 'text-zinc-400');
            }
        }

        // --- View Logic ---
        function openViewModal(fileName, fileUrl) {
            document.getElementById('viewDisplayFileName').textContent = fileName;
            document.getElementById('viewDownloadBtn').href = fileUrl;
            openModal('viewModal');
        }

        // --- Edit Logic ---
        function openEditModal(currentFileName, rowId) {
            document.getElementById('currentFileName').textContent = currentFileName;
            document.getElementById('editRowId').value = rowId;
            
            // Reset input file state
            document.getElementById('editFileInput').value = '';
            document.getElementById('editFileName').textContent = 'Select new PDF to replace';
            document.getElementById('editFileName').classList.remove('text-blue-400');
            document.getElementById('editFileName').classList.add('text-zinc-400');

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
                icon: 'success', title: 'Resume Uploaded!', text: 'Your PDF resume has been uploaded successfully.',
                showConfirmButton: false, timer: 1500
            }).then(() => location.reload()); // Refresh page di environment nyata
        }

        function handleEdit(e) {
            e.preventDefault();
            closeModal('editModal');
            swalDark.fire({
                icon: 'success', title: 'Resume Replaced!', text: 'Your new PDF resume has been updated.',
                showConfirmButton: false, timer: 1500
            }).then(() => location.reload());
        }

        function handleDelete(e) {
            e.preventDefault();
            closeModal('deleteModal');
            swalDark.fire({
                icon: 'success', title: 'Deleted!', text: 'The resume file has been removed.',
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