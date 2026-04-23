<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Tools & Tech Stack</title>
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
<body class="antialiased selection:bg-white selection:text-black flex h-screen overflow-hidden">

    @include('admin.partials.sidebar')

    <main class="flex-1 overflow-y-auto bg-[#0a0a0a] relative">
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full max-w-3xl h-[300px] bg-blue-500/10 blur-[120px] rounded-full pointer-events-none -z-10"></div>

        <div class="p-6 md:p-12 lg:p-16 max-w-6xl mx-auto">
            
            <div class="mb-10 flex flex-col md:flex-row md:items-end justify-between gap-6">
                <div>
                    <div class="flex items-center gap-2 text-sm text-zinc-500 font-medium mb-3">
                        <span class="text-white">Admin</span>
                        <span>/</span>
                        <span class="text-white">Tools</span>
                    </div>
                    <h1 class="text-3xl md:text-4xl font-bold tracking-tight text-white">Tools & Tech Stack</h1>
                    <p class="text-zinc-400 mt-2">Manage the list of technologies you are proficient in.</p>
                </div>
                
                <a href="/admin/friends/create" class="px-6 py-3 rounded-full text-sm font-bold bg-white text-black hover:bg-gray-200 transition-all flex items-center gap-2 shadow-[0_0_15px_rgba(255,255,255,0.15)] w-fit">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Add Tool
                </a>
            </div>

            <div class="bg-[#141414] border border-white/10 rounded-3xl overflow-hidden shadow-2xl">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-white/[0.02] border-b border-white/10 text-xs uppercase tracking-widest text-zinc-500">
                                <th class="p-6 font-semibold w-2/3">Tool Name</th>
                                <th class="p-6 font-semibold text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="toolsTableBody" class="divide-y divide-white/5 text-sm">
                            
                            <tr id="row-1" class="hover:bg-white/[0.02] transition-colors group">
                                <td class="p-6">
                                    <div class="font-bold text-white text-lg font-jetbrains">React</div>
                                </td>
                                <td class="p-6">
                                    <div class="flex items-center justify-end gap-3 opacity-100 md:opacity-0 group-hover:opacity-100 transition-opacity">
                                        <a href="/admin/friends/1/edit" class="w-8 h-8 rounded-full bg-blue-500/10 flex items-center justify-center text-blue-400 hover:text-white hover:bg-blue-500/30 transition-colors" title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                        </a>
                                        <button type="button" onclick="openDeleteModal('React', 'row-1')" class="w-8 h-8 rounded-full bg-red-500/10 flex items-center justify-center text-red-400 hover:text-white hover:bg-red-500/30 transition-colors" title="Delete">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <tr id="row-2" class="hover:bg-white/[0.02] transition-colors group">
                                <td class="p-6">
                                    <div class="font-bold text-white text-lg font-jetbrains">Laravel</div>
                                </td>
                                <td class="p-6">
                                    <div class="flex items-center justify-end gap-3 opacity-100 md:opacity-0 group-hover:opacity-100 transition-opacity">
                                        <a href="/admin/friends/2/edit" class="w-8 h-8 rounded-full bg-blue-500/10 flex items-center justify-center text-blue-400 hover:text-white hover:bg-blue-500/30 transition-colors" title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                        </a>
                                        <button type="button" onclick="openDeleteModal('Laravel', 'row-2')" class="w-8 h-8 rounded-full bg-red-500/10 flex items-center justify-center text-red-400 hover:text-white hover:bg-red-500/30 transition-colors" title="Delete">
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

    <div id="deleteModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm opacity-0 pointer-events-none transition-opacity duration-300">
        <div id="deleteModalContent" class="bg-[#141414] border border-white/10 rounded-3xl p-8 w-full max-w-md transform scale-95 transition-transform duration-300 shadow-2xl text-center">
            <div class="w-16 h-16 rounded-full bg-red-500/10 flex items-center justify-center text-red-500 mx-auto mb-6">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            </div>
            <h3 class="text-2xl font-bold text-white mb-2">Are you sure?</h3>
            <p class="text-zinc-400 text-sm mb-8">You are about to remove <span id="deleteToolName" class="font-bold text-white font-jetbrains"></span> from your tech stack.</p>
            
            <div class="flex gap-4 justify-center">
                <button type="button" onclick="closeDeleteModal()" class="px-6 py-2.5 rounded-full text-sm font-bold text-zinc-400 hover:text-white hover:bg-white/5 transition-all w-1/2 border border-white/5">Cancel</button>
                <form id="deleteToolForm" action="#" method="POST" class="w-1/2">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" id="deleteRowId" value="">
                    <button type="submit" class="w-full px-6 py-2.5 rounded-full text-sm font-bold bg-red-500/20 text-red-400 border border-red-500/20 hover:bg-red-500 hover:text-white transition-all shadow-[0_0_15px_rgba(239,68,68,0.2)]">Delete</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        const swalDark = Swal.mixin({
            background: '#141414', color: '#ffffff',
            customClass: { popup: 'border border-white/10 rounded-3xl shadow-2xl' }
        });

        // --- Delete Modal ---
        const deleteModal = document.getElementById('deleteModal');
        const deleteContent = document.getElementById('deleteModalContent');
        const deleteNameSpan = document.getElementById('deleteToolName');
        const deleteRowInput = document.getElementById('deleteRowId');

        function openDeleteModal(name, rowId) {
            deleteNameSpan.textContent = name;
            deleteRowInput.value = rowId;
            deleteModal.classList.remove('opacity-0', 'pointer-events-none');
            deleteContent.classList.remove('scale-95');
        }

        function closeDeleteModal() {
            deleteModal.classList.add('opacity-0', 'pointer-events-none');
            deleteContent.classList.add('scale-95');
        }

        document.getElementById('deleteToolForm').addEventListener('submit', function(e) {
            e.preventDefault(); 
            closeDeleteModal();
            swalDark.fire({
                icon: 'success', title: 'Deleted!', text: 'Tool removed from your stack.',
                showConfirmButton: false, timer: 2000
            }).then(() => {
                const rowId = document.getElementById('deleteRowId').value;
                const row = document.getElementById(rowId);
                if(row) { row.style.opacity = '0'; setTimeout(() => row.remove(), 300); }
            });
        });
    </script>
</body>
</html>