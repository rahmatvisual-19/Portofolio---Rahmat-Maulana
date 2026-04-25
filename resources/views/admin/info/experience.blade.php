<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Experience</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Albert+Sans:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
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
                        <span class="text-white">Experience</span>
                    </div>
                    <h1 class="text-3xl md:text-4xl font-bold tracking-tight text-white">Experience</h1>
                    <p class="text-zinc-400 mt-2">Manage your work history and experience entries.</p>
                </div>
                
                <!-- Trigger Create Modal -->
                <button type="button" onclick="openCreateModal()" class="px-6 py-3 rounded-full text-sm font-bold bg-white text-black hover:bg-gray-200 transition-all flex items-center gap-2 shadow-[0_0_15px_rgba(255,255,255,0.15)] w-fit">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Add Experience
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
                @foreach($errors->all() as $error)<div>✕ {{ $error }}</div>@endforeach
            </div>
            @endif
            <div class="bg-[#141414] border border-white/10 rounded-3xl overflow-hidden shadow-2xl">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-white/[0.02] border-b border-white/10 text-xs uppercase tracking-widest text-zinc-500">
                                <th class="p-6 font-semibold">Company</th>
                                <th class="p-6 font-semibold">Role</th>
                                <th class="p-6 font-semibold">Period</th>
                                <th class="p-6 font-semibold text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="experienceTableBody" class="divide-y divide-white/5 text-sm">
                            @forelse($experiences as $exp)
                            <tr id="row-{{ $exp->id }}" class="hover:bg-white/[0.02] transition-colors group">
                                <td class="p-6">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center text-zinc-400 font-bold text-sm">{{ strtoupper(substr($exp->company, 0, 1)) }}</div>
                                        <span class="font-bold text-white">{{ $exp->company }}</span>
                                    </div>
                                </td>
                                <td class="p-6 text-zinc-300">{{ $exp->role }}</td>
                                <td class="p-6 text-zinc-500 font-jetbrains text-xs">{{ $exp->start_year }} — {{ $exp->end_year }}</td>
                                <td class="p-6">
                                    <div class="flex items-center justify-end gap-3 opacity-100 md:opacity-0 group-hover:opacity-100 transition-opacity">
                                        <button type="button" onclick="openViewModal('{{ addslashes($exp->company) }}', '{{ addslashes($exp->role) }}', '{{ $exp->start_year }} — {{ $exp->end_year }}', '{{ addslashes($exp->description) }}')" class="w-8 h-8 rounded-full bg-white/5 flex items-center justify-center text-zinc-400 hover:text-white hover:bg-white/10 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        </button>
                                        <button type="button" onclick="openEditModal('{{ $exp->id }}', '{{ addslashes($exp->company) }}', '{{ addslashes($exp->role) }}', '{{ $exp->start_year }}', '{{ $exp->end_year }}', '{{ addslashes($exp->description) }}')" class="w-8 h-8 rounded-full bg-blue-500/10 flex items-center justify-center text-blue-400 hover:text-white hover:bg-blue-500/30 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                        </button>
                                        <button type="button" onclick="openDeleteModal('{{ addslashes($exp->company) }}', '{{ $exp->id }}')" class="w-8 h-8 rounded-full bg-red-500/10 flex items-center justify-center text-red-400 hover:text-white hover:bg-red-500/30 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="p-12 text-center text-zinc-600">Belum ada experience. Klik "Add Experience".</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <!-- ==================== MODALS SECTION ==================== -->

    <!-- 1. MODAL CREATE EXPERIENCE -->
    <div id="createModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm opacity-0 pointer-events-none transition-opacity duration-300 p-4">
        <div id="createModalContent" class="bg-[#141414] border border-white/10 rounded-3xl p-8 md:p-10 w-full max-w-2xl max-h-[90vh] overflow-y-auto transform scale-95 transition-transform duration-300 shadow-2xl relative">
            <button type="button" onclick="closeCreateModal()" class="absolute top-6 right-6 w-8 h-8 rounded-full bg-white/5 flex items-center justify-center text-zinc-400 hover:text-white hover:bg-white/10 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
            
            <div class="mb-8">
                <h2 class="text-3xl font-bold tracking-tight text-white">Add Experience</h2>
                <p class="text-zinc-400 mt-2">Add a new entry to your work history.</p>
            </div>

            <form id="createForm" action="{{ route('admin.experiences.store') }}" method="POST">
                @csrf
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-semibold text-zinc-300 mb-2">Company Name</label>
                        <input type="text" name="company" placeholder="e.g. Google" required class="w-full bg-[#0a0a0a] border border-white/10 rounded-xl px-4 py-3 text-white placeholder-zinc-600 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-zinc-300 mb-2">Role / Position</label>
                        <input type="text" name="role" placeholder="e.g. Senior UI Designer" required class="w-full bg-[#0a0a0a] border border-white/10 rounded-xl px-4 py-3 text-white placeholder-zinc-600 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-zinc-300 mb-2">Start Year</label>
                            <input type="text" name="start_year" placeholder="e.g. 2022" required class="w-full bg-[#0a0a0a] border border-white/10 rounded-xl px-4 py-3 text-white placeholder-zinc-600 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-zinc-300 mb-2">End Year</label>
                            <input type="text" name="end_year" placeholder="e.g. Present" class="w-full bg-[#0a0a0a] border border-white/10 rounded-xl px-4 py-3 text-white placeholder-zinc-600 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-zinc-300 mb-2">Description <span class="text-zinc-600 font-normal">(Optional)</span></label>
                        <textarea name="description" rows="3" placeholder="Brief description of your role and responsibilities..." class="w-full bg-[#0a0a0a] border border-white/10 rounded-xl px-4 py-3 text-white placeholder-zinc-600 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all resize-none"></textarea>
                    </div>
                </div>

                <div class="flex justify-end gap-4 mt-8 pt-6 border-t border-white/10">
                    <button type="button" onclick="closeCreateModal()" class="px-6 py-3 rounded-full text-sm font-bold text-zinc-400 hover:text-white hover:bg-white/5 transition-all">Cancel</button>
                    <button type="submit" class="px-8 py-3 rounded-full text-sm font-bold bg-white text-black hover:bg-gray-200 hover:scale-105 transition-all shadow-[0_0_20px_rgba(255,255,255,0.2)]">Save Experience</button>
                </div>
            </form>
        </div>
    </div>

    <!-- 2. MODAL EDIT EXPERIENCE -->
    <div id="editModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm opacity-0 pointer-events-none transition-opacity duration-300 p-4">
        <div id="editModalContent" class="bg-[#141414] border border-white/10 rounded-3xl p-8 md:p-10 w-full max-w-2xl max-h-[90vh] overflow-y-auto transform scale-95 transition-transform duration-300 shadow-2xl relative">
            <button type="button" onclick="closeEditModal()" class="absolute top-6 right-6 w-8 h-8 rounded-full bg-white/5 flex items-center justify-center text-zinc-400 hover:text-white hover:bg-white/10 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
            
            <div class="mb-8">
                <h2 class="text-3xl font-bold tracking-tight text-white">Edit Experience</h2>
                <p class="text-zinc-400 mt-2">Update this experience entry.</p>
            </div>

            <form id="editForm" action="" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" id="editId" name="id">

                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-semibold text-zinc-300 mb-2">Company Name</label>
                        <input type="text" id="editCompany" name="company" required class="w-full bg-[#0a0a0a] border border-white/10 rounded-xl px-4 py-3 text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-zinc-300 mb-2">Role / Position</label>
                        <input type="text" id="editRole" name="role" required class="w-full bg-[#0a0a0a] border border-white/10 rounded-xl px-4 py-3 text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-zinc-300 mb-2">Start Year</label>
                            <input type="text" id="editStartYear" name="start_year" required class="w-full bg-[#0a0a0a] border border-white/10 rounded-xl px-4 py-3 text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-zinc-300 mb-2">End Year</label>
                            <input type="text" id="editEndYear" name="end_year" class="w-full bg-[#0a0a0a] border border-white/10 rounded-xl px-4 py-3 text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-zinc-300 mb-2">Description</label>
                        <textarea id="editDesc" name="description" rows="3" class="w-full bg-[#0a0a0a] border border-white/10 rounded-xl px-4 py-3 text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all resize-none"></textarea>
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
        <div id="viewModalContent" class="bg-[#141414] border border-white/10 rounded-3xl p-8 md:p-10 w-full max-w-xl transform scale-95 transition-transform duration-300 shadow-2xl relative">
            <button type="button" onclick="closeViewModal()" class="absolute top-6 right-6 w-8 h-8 rounded-full bg-white/5 flex items-center justify-center text-zinc-400 hover:text-white hover:bg-white/10 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
            
            <div class="flex items-center gap-5 mb-8 pb-8 border-b border-white/10">
                <div id="viewInitial" class="w-16 h-16 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center text-zinc-300 font-bold text-2xl"></div>
                <div>
                    <h3 id="viewRole" class="text-2xl font-bold text-white mb-1"></h3>
                    <div class="flex items-center gap-2 text-sm">
                        <span id="viewCompany" class="text-zinc-300 font-medium"></span>
                        <span class="text-zinc-600">•</span>
                        <span id="viewPeriod" class="text-zinc-500 font-jetbrains"></span>
                    </div>
                </div>
            </div>
            
            <div class="mb-8">
                <h4 class="text-sm font-semibold text-zinc-400 mb-3 uppercase tracking-wider">Description & Impact</h4>
                <p id="viewDesc" class="text-zinc-300 text-base leading-relaxed"></p>
            </div>
            
            <button type="button" id="viewEditBtn" class="w-full px-6 py-3 rounded-xl text-sm font-bold bg-white/5 text-white hover:bg-white/10 transition-all text-center border border-white/10">
                Edit this entry
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
            <p class="text-zinc-400 text-sm mb-8">You are about to delete the <span id="deleteName" class="font-bold text-white"></span> experience entry. This action cannot be undone.</p>
            
            <div class="flex gap-4 justify-center">
                <button type="button" onclick="closeDeleteModal()" class="px-6 py-2.5 rounded-full text-sm font-bold text-zinc-400 hover:text-white hover:bg-white/5 transition-all w-1/2 border border-white/5">Cancel</button>
                <form id="deleteForm" action="" method="POST" class="w-1/2">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" id="deleteRowId" value="">
                    <button type="submit" class="w-full px-6 py-2.5 rounded-full text-sm font-bold bg-red-500/20 text-red-400 border border-red-500/20 hover:bg-red-500 hover:text-white transition-all shadow-[0_0_15px_rgba(239,68,68,0.2)]">Delete</button>
                </form>
            </div>
        </div>
    </div>

    <!-- JS Logic -->
    <script>
        // --- SweetAlert Dark Theme ---
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
        const createForm = document.getElementById('createForm');

        function openCreateModal() {
            createForm.reset();
            createModal.classList.remove('opacity-0', 'pointer-events-none');
            createModalContent.classList.remove('scale-95');
        }

        function closeCreateModal() {
            createModal.classList.add('opacity-0', 'pointer-events-none');
            createModalContent.classList.add('scale-95');
        }

        // ==================== EDIT MODAL ====================
        const editModal = document.getElementById('editModal');
        const editModalContent = document.getElementById('editModalContent');
        const editForm = document.getElementById('editForm');

        function openEditModal(id, company, role, startYear, endYear, desc) {
            document.getElementById('editId').value = id;
            document.getElementById('editCompany').value = company;
            document.getElementById('editRole').value = role;
            document.getElementById('editStartYear').value = startYear;
            document.getElementById('editEndYear').value = endYear;
            document.getElementById('editDesc').value = desc;
            editForm.action = '/admin/info/experiences/' + id;

            closeViewModal();
            editModal.classList.remove('opacity-0', 'pointer-events-none');
            editModalContent.classList.remove('scale-95');
        }

        function closeEditModal() {
            editModal.classList.add('opacity-0', 'pointer-events-none');
            editModalContent.classList.add('scale-95');
        }

        // ==================== VIEW MODAL ====================
        const viewModal = document.getElementById('viewModal');
        const viewModalContent = document.getElementById('viewModalContent');

        function openViewModal(company, role, period, desc) {
            // Ambil inisial perusahaan untuk avatar logo
            document.getElementById('viewInitial').textContent = company.charAt(0).toUpperCase();
            
            document.getElementById('viewCompany').textContent = company;
            document.getElementById('viewRole').textContent = role;
            document.getElementById('viewPeriod').textContent = period;
            document.getElementById('viewDesc').textContent = desc || "No description provided.";
            
            // Set trigger tombol edit di dalam view modal
            // (Memisahkan period menjadi start & end secara sederhana untuk contoh parameter)
            let years = period.split('—').map(s => s.trim());
            document.getElementById('viewEditBtn').onclick = () => openEditModal('1', company, role, years[0], years[1] || '', desc);

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
        const deleteNameSpan = document.getElementById('deleteName');
        const deleteRowInput = document.getElementById('deleteRowId');

        function openDeleteModal(companyName, expId) {
            deleteNameSpan.textContent = companyName;
            document.getElementById('deleteForm').action = '/admin/info/experiences/' + expId;
            deleteModal.classList.remove('opacity-0', 'pointer-events-none');
            deleteContent.classList.remove('scale-95');
        }

        function closeDeleteModal() {
            deleteModal.classList.add('opacity-0', 'pointer-events-none');
            deleteContent.classList.add('scale-95');
        }

        document.getElementById('deleteForm').addEventListener('submit', function() {
            closeDeleteModal();
        });
    </script>
</body>
</html>