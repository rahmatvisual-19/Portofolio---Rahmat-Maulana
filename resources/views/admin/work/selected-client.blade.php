<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Selected Clients</title>
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

        <div class="p-6 md:p-12 lg:p-16 max-w-6xl mx-auto">
            
            <!-- Header Section -->
            <div class="mb-10 flex flex-col md:flex-row md:items-end justify-between gap-6">
                <div>
                    <div class="flex items-center gap-2 text-sm text-zinc-500 font-medium mb-3">
                        <span class="text-white">Admin</span>
                        <span>/</span>
                        <span class="text-white">Selected Clients</span>
                    </div>
                    <h1 class="text-3xl md:text-4xl font-bold tracking-tight text-white">Selected Clients</h1>
                    <p class="text-zinc-400 mt-2">Manage the clients & partners displayed on your homepage.</p>
                </div>
                
                <!-- Trigger Create Modal -->
                <button type="button" onclick="openCreateModal()" class="px-6 py-3 rounded-full text-sm font-bold bg-white text-black hover:bg-gray-200 transition-all flex items-center gap-2 shadow-[0_0_15px_rgba(255,255,255,0.15)] w-fit">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Add New Client
                </button>
            </div>

            {{-- Flash Messages --}}
            @if(session('success'))
            <div class="mb-6 px-5 py-4 bg-green-500/10 border border-green-500/20 rounded-2xl text-green-400 text-sm font-medium">
                ✓ {{ session('success') }}
            </div>
            @endif
            @if($errors->any())
            <div class="mb-6 px-5 py-4 bg-red-500/10 border border-red-500/20 rounded-2xl text-red-400 text-sm">
                @foreach($errors->all() as $error)
                <div>✕ {{ $error }}</div>
                @endforeach
            </div>
            @endif
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-white/[0.02] border-b border-white/10 text-xs uppercase tracking-widest text-zinc-500">
                                <th class="p-6 font-semibold w-24">Logo</th>
                                <th class="p-6 font-semibold">Client Name</th>
                                <th class="p-6 font-semibold text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="clientTableBody" class="divide-y divide-white/5 text-sm">
                            @forelse($clients as $c)
                            <tr id="row-{{ $c->id }}" class="hover:bg-white/[0.02] transition-colors group">
                                <td class="p-6">
                                    <div class="w-12 h-12 rounded-xl overflow-hidden bg-white/5 border border-white/10 flex items-center justify-center p-2">
                                        @if($c->logo_path)
                                            <img src="{{ asset('storage/' . $c->logo_path) }}" class="w-full h-full object-contain filter invert opacity-80" alt="{{ $c->name }}">
                                        @else
                                            <span class="text-zinc-600 text-[10px] uppercase font-bold text-center leading-tight">No<br>Logo</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="p-6">
                                    <div class="font-bold text-white text-base">{{ $c->name ?: '—' }}</div>
                                </td>
                                <td class="p-6">
                                    <div class="flex items-center justify-end gap-3 opacity-100 md:opacity-0 group-hover:opacity-100 transition-opacity">
                                        <button type="button" onclick="openViewModal('{{ addslashes($c->name) }}', '{{ $c->logo_path ? asset('storage/' . $c->logo_path) : '' }}')" class="w-8 h-8 rounded-full bg-white/5 flex items-center justify-center text-zinc-400 hover:text-white hover:bg-white/10 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        </button>
                                        <button type="button" onclick="openEditModal('{{ $c->id }}', '{{ addslashes($c->name) }}', '{{ $c->logo_path ? asset('storage/' . $c->logo_path) : '' }}')" class="w-8 h-8 rounded-full bg-blue-500/10 flex items-center justify-center text-blue-400 hover:text-white hover:bg-blue-500/30 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                        </button>
                                        <button type="button" onclick="openDeleteModal('{{ addslashes($c->name ?: 'this client') }}', '{{ $c->id }}')" class="w-8 h-8 rounded-full bg-red-500/10 flex items-center justify-center text-red-400 hover:text-white hover:bg-red-500/30 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="p-12 text-center text-zinc-600">Belum ada client. Klik "Add New Client" untuk menambahkan.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <!-- ==================== MODALS SECTION ==================== -->

    <!-- 1. MODAL CREATE CLIENT -->
    <div id="createModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm opacity-0 pointer-events-none transition-opacity duration-300 p-4">
        <div id="createModalContent" class="bg-[#141414] border border-white/10 rounded-3xl p-8 md:p-10 w-full max-w-4xl max-h-[90vh] overflow-y-auto transform scale-95 transition-transform duration-300 shadow-2xl relative">
            <button type="button" onclick="closeCreateModal()" class="absolute top-6 right-6 w-8 h-8 rounded-full bg-white/5 flex items-center justify-center text-zinc-400 hover:text-white hover:bg-white/10 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
            
            <div class="mb-8">
                <h2 class="text-3xl font-bold tracking-tight text-white">Add New Client</h2>
                <p class="text-zinc-400 mt-2">You can add a client by providing just their name, just their logo, or both.</p>
            </div>

            <form id="createClientForm" action="{{ route('admin.clients.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                    <!-- Kiri: Client Name -->
                    <div class="flex flex-col justify-center">
                        <label class="block text-sm font-semibold text-zinc-300 mb-2">Client Name <span class="text-zinc-600 font-normal">(Optional)</span></label>
                        <input type="text" id="createClientName" name="name" placeholder="e.g. Spotify" class="w-full bg-[#0a0a0a] border border-white/10 rounded-xl px-4 py-3 text-white placeholder-zinc-600 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all">
                        <p class="text-xs text-zinc-500 mt-3 leading-relaxed">Leave blank if you only want to display the company's logo.</p>
                    </div>

                    <!-- Kanan: Client Logo -->
                    <div>
                        <label class="block text-sm font-semibold text-zinc-300 mb-2">Client Logo <span class="text-zinc-600 font-normal">(Optional)</span></label>
                        <div class="relative group border-2 border-dashed border-white/10 rounded-xl bg-[#0a0a0a] hover:bg-white/5 hover:border-white/20 transition-all p-8 text-center cursor-pointer aspect-[3/2] flex items-center justify-center">
                            <input type="file" id="createClientLogo" name="logo" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                            <div class="flex flex-col items-center justify-center space-y-3 pointer-events-none">
                                <div class="w-12 h-12 rounded-full bg-blue-500/10 flex items-center justify-center text-blue-400 group-hover:scale-110 transition-transform">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                </div>
                                <div>
                                    <p class="text-sm text-white font-medium">Upload Logo</p>
                                    <p class="text-[10px] text-zinc-500 mt-1 uppercase tracking-wider">SVG, PNG (Transparent)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-4 mt-10 pt-6 border-t border-white/10">
                    <button type="button" onclick="closeCreateModal()" class="px-6 py-3 rounded-full text-sm font-bold text-zinc-400 hover:text-white hover:bg-white/5 transition-all">Cancel</button>
                    <button type="submit" class="px-8 py-3 rounded-full text-sm font-bold bg-white text-black hover:bg-gray-200 hover:scale-105 transition-all shadow-[0_0_20px_rgba(255,255,255,0.2)]">Save Client</button>
                </div>
            </form>
        </div>
    </div>

    <!-- 2. MODAL EDIT CLIENT -->
    <div id="editModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm opacity-0 pointer-events-none transition-opacity duration-300 p-4">
        <div id="editModalContent" class="bg-[#141414] border border-white/10 rounded-3xl p-8 md:p-10 w-full max-w-4xl max-h-[90vh] overflow-y-auto transform scale-95 transition-transform duration-300 shadow-2xl relative">
            <button type="button" onclick="closeEditModal()" class="absolute top-6 right-6 w-8 h-8 rounded-full bg-white/5 flex items-center justify-center text-zinc-400 hover:text-white hover:bg-white/10 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
            
            <div class="mb-8">
                <h2 class="text-3xl font-bold tracking-tight text-white">Edit Client</h2>
                <p class="text-zinc-400 mt-2">Update the information for this client.</p>
            </div>

            <form id="editClientForm" action="" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" id="editClientId" name="id">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                    <!-- Kiri: Client Name -->
                    <div class="flex flex-col justify-center">
                        <label class="block text-sm font-semibold text-zinc-300 mb-2">Client Name <span class="text-zinc-600 font-normal">(Optional)</span></label>
                        <input type="text" id="editClientName" name="name" placeholder="e.g. Spotify" class="w-full bg-[#0a0a0a] border border-white/10 rounded-xl px-4 py-3 text-white placeholder-zinc-600 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all">
                        <p class="text-xs text-zinc-500 mt-3 leading-relaxed">Leave blank if you only want to display the company's logo.</p>
                    </div>

                    <!-- Kanan: Client Logo Update -->
                    <div>
                        <label class="block text-sm font-semibold text-zinc-300 mb-2">Client Logo</label>
                        
                        <!-- Menampilkan Logo Aktif -->
                        <div id="editLogoPreviewContainer" class="mb-3 w-full h-24 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center p-3 relative overflow-hidden">
                            <img id="editLogoPreview" src="" alt="Current Logo" class="h-full object-contain filter invert opacity-70">
                            <span id="editLogoBadge" class="absolute top-2 right-2 text-[8px] uppercase tracking-widest font-bold bg-white/10 px-2 py-1 rounded-md text-zinc-400">Current</span>
                            <span id="editNoLogoText" class="text-zinc-500 text-xs italic hidden">No current logo</span>
                        </div>

                        <div class="relative group border-2 border-dashed border-white/10 rounded-xl bg-[#0a0a0a] hover:bg-white/5 hover:border-white/20 transition-all p-4 text-center cursor-pointer">
                            <input type="file" id="editClientLogo" name="logo" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                            <p class="text-sm text-zinc-400 font-medium group-hover:text-white transition-colors">Select new logo to replace</p>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-4 mt-10 pt-6 border-t border-white/10">
                    <button type="button" onclick="closeEditModal()" class="px-6 py-3 rounded-full text-sm font-bold text-zinc-400 hover:text-white hover:bg-white/5 transition-all">Cancel</button>
                    <button type="submit" class="px-8 py-3 rounded-full text-sm font-bold bg-blue-600 text-white hover:bg-blue-500 hover:scale-105 transition-all shadow-[0_0_20px_rgba(37,99,235,0.4)]">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    <!-- 3. MODAL VIEW DETAILS CLIENT -->
    <div id="viewModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm opacity-0 pointer-events-none transition-opacity duration-300 p-4">
        <div id="viewModalContent" class="bg-[#141414] border border-white/10 rounded-3xl p-8 w-full max-w-sm transform scale-95 transition-transform duration-300 shadow-2xl relative text-center">
            
            <button type="button" onclick="closeViewModal()" class="absolute top-4 right-4 w-8 h-8 rounded-full bg-white/5 flex items-center justify-center text-zinc-400 hover:text-white hover:bg-white/10 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>

            <!-- Menampilkan Logo (Jika ada) -->
            <div id="viewLogoContainer" class="w-32 h-32 mx-auto rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center p-4 mb-6">
                <img id="viewImage" src="" alt="Client Logo" class="w-full h-full object-contain filter invert opacity-80">
            </div>

            <!-- Menampilkan Nama -->
            <h3 id="viewTitle" class="text-2xl font-bold text-white mb-2"></h3>
            <p class="text-zinc-500 text-xs uppercase tracking-widest font-bold mb-6">Selected Client</p>

            <button type="button" id="viewEditBtn" class="w-full px-6 py-2.5 rounded-xl text-sm font-bold bg-white/5 text-white hover:bg-white/10 transition-all text-center border border-white/10">
                Edit Client
            </button>
        </div>
    </div>

    <!-- 4. MODAL DELETE CONFIRMATION -->
    <div id="deleteModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm opacity-0 pointer-events-none transition-opacity duration-300 p-4">
        <div id="deleteModalContent" class="bg-[#141414] border border-white/10 rounded-3xl p-8 w-full max-w-md transform scale-95 transition-transform duration-300 shadow-2xl text-center">
            <div class="w-16 h-16 rounded-full bg-red-500/10 flex items-center justify-center text-red-500 mx-auto mb-6">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            </div>
            <h3 class="text-2xl font-bold text-white mb-2">Are you sure?</h3>
            <p class="text-zinc-400 text-sm mb-8">You are about to delete <span id="deleteClientName" class="font-bold text-white"></span>. This action cannot be undone.</p>
            
            <div class="flex gap-4 justify-center">
                <button type="button" onclick="closeDeleteModal()" class="px-6 py-2.5 rounded-full text-sm font-bold text-zinc-400 hover:text-white hover:bg-white/5 transition-all w-1/2 border border-white/5">Cancel</button>
                <form id="deleteClientForm" action="" method="POST" class="w-1/2">
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
        const createForm = document.getElementById('createClientForm');

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
            const name = document.getElementById('createClientName').value.trim();
            const logo = document.getElementById('createClientLogo').value;

            if (name === '' && logo === '') {
                e.preventDefault();
                swalDark.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Please provide either a Client Name or upload a Logo!',
                    confirmButtonText: 'Understood'
                });
                return;
            }
            // Submit normal ke server
        });

        // ==================== EDIT MODAL ====================
        const editModal = document.getElementById('editModal');
        const editModalContent = document.getElementById('editModalContent');
        const editForm = document.getElementById('editClientForm');
        
        function openEditModal(id, name, logoSrc) {
            document.getElementById('editClientId').value = id;
            document.getElementById('editClientName').value = name === 'Logo Only' ? '' : name;

            // Set action form ke route update yang benar
            editForm.action = '/admin/work/clients/' + id;

            const previewImg = document.getElementById('editLogoPreview');
            const previewBadge = document.getElementById('editLogoBadge');
            const noLogoText = document.getElementById('editNoLogoText');

            if (logoSrc && logoSrc !== '') {
                previewImg.src = logoSrc;
                previewImg.classList.remove('hidden');
                previewBadge.classList.remove('hidden');
                noLogoText.classList.add('hidden');
            } else {
                previewImg.classList.add('hidden');
                previewBadge.classList.add('hidden');
                noLogoText.classList.remove('hidden');
            }

            closeViewModal();
            editModal.classList.remove('opacity-0', 'pointer-events-none');
            editModalContent.classList.remove('scale-95');
        }

        function closeEditModal() {
            editModal.classList.add('opacity-0', 'pointer-events-none');
            editModalContent.classList.add('scale-95');
        }

        editForm.addEventListener('submit', function() {
            // Submit normal ke server
        });

        // ==================== VIEW MODAL ====================
        const viewModal = document.getElementById('viewModal');
        const viewModalContent = document.getElementById('viewModalContent');
        const viewImage = document.getElementById('viewImage');
        const viewLogoContainer = document.getElementById('viewLogoContainer');

        function openViewModal(name, imgSrc) {
            document.getElementById('viewTitle').textContent = name;
            
            if (imgSrc && imgSrc !== '') {
                viewImage.src = imgSrc;
                viewLogoContainer.style.display = 'flex';
            } else {
                viewLogoContainer.style.display = 'none';
            }

            // Set trigger edit
            document.getElementById('viewEditBtn').onclick = () => openEditModal('1', name, imgSrc);

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
        const deleteNameSpan = document.getElementById('deleteClientName');

        function openDeleteModal(clientName, clientId) {
            deleteNameSpan.textContent = clientName;
            document.getElementById('deleteClientForm').action = '/admin/work/clients/' + clientId;
            deleteModal.classList.remove('opacity-0', 'pointer-events-none');
            deleteContent.classList.remove('scale-95');
        }

        function closeDeleteModal() {
            deleteModal.classList.add('opacity-0', 'pointer-events-none');
            deleteContent.classList.add('scale-95');
        }

        document.getElementById('deleteClientForm').addEventListener('submit', function() {
            closeDeleteModal();
        });
    </script>
</body>
</html>