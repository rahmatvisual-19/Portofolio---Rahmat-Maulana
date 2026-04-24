<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Showcase List</title>
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
                        <span class="text-white">Showcase</span>
                    </div>
                    <h1 class="text-3xl md:text-4xl font-bold tracking-tight text-white">Showcase Projects</h1>
                    <p class="text-zinc-400 mt-2">Manage your portfolio showcase items.</p>
                </div>
                
                <!-- Trigger Create Modal -->
                <button type="button" onclick="openCreateModal()" class="px-6 py-3 rounded-full text-sm font-bold bg-white text-black hover:bg-gray-200 transition-all flex items-center gap-2 shadow-[0_0_15px_rgba(255,255,255,0.15)] w-fit">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Add New Project
                </button>
            </div>

            <!-- Table Section -->
            <div class="bg-[#141414] border border-white/10 rounded-3xl overflow-hidden shadow-2xl">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-white/[0.02] border-b border-white/10 text-xs uppercase tracking-widest text-zinc-500">
                                <th class="p-6 font-semibold">Project</th>
                                <th class="p-6 font-semibold">Company & Year</th>
                                <th class="p-6 font-semibold">Category</th>
                                <th class="p-6 font-semibold text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="projectTableBody" class="divide-y divide-white/5 text-sm">
                            
                            <!-- Item Dummy 1 -->
                            <tr id="row-1" class="hover:bg-white/[0.02] transition-colors group">
                                <td class="p-6">
                                    <div class="flex items-center gap-4">
                                        <div class="w-16 h-12 rounded-lg overflow-hidden border border-white/10">
                                            <img src="https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?q=80&w=200" class="w-full h-full object-cover" alt="Nexus">
                                        </div>
                                        <div>
                                            <div class="font-bold text-white text-base">Nexus Platform</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-6 text-zinc-400 font-jetbrains">Google, '23</td>
                                <td class="p-6">
                                    <span class="px-3 py-1 bg-white/5 border border-white/10 rounded-full text-xs text-white/80">Design</span>
                                </td>
                                <td class="p-6">
                                    <div class="flex items-center justify-end gap-3 opacity-100 md:opacity-0 group-hover:opacity-100 transition-opacity">
                                        <!-- View -->
                                        <button type="button" onclick="openViewModal('Nexus Platform', 'Google, \'23', 'Design', 'Membangun ekosistem yang berkelanjutan.', 'https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?q=80&w=800')" class="w-8 h-8 rounded-full bg-white/5 flex items-center justify-center text-zinc-400 hover:text-white hover:bg-white/10 transition-colors" title="View Details">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        </button>
                                        <!-- Edit -->
                                        <button type="button" onclick="openEditModal('1', 'Nexus Platform', 'Google, \'23', 'design', 'Membangun ekosistem yang berkelanjutan.', 'https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?q=80&w=400')" class="w-8 h-8 rounded-full bg-blue-500/10 flex items-center justify-center text-blue-400 hover:text-white hover:bg-blue-500/30 transition-colors" title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                        </button>
                                        <!-- Delete -->
                                        <button type="button" onclick="openDeleteModal('Nexus Platform', 'row-1')" class="w-8 h-8 rounded-full bg-red-500/10 flex items-center justify-center text-red-400 hover:text-white hover:bg-red-500/30 transition-colors" title="Delete">
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

    <!-- 1. MODAL CREATE PROJECT -->
    <div id="createModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm opacity-0 pointer-events-none transition-opacity duration-300 p-4">
        <div id="createModalContent" class="bg-[#141414] border border-white/10 rounded-3xl p-8 md:p-10 w-full max-w-4xl max-h-[90vh] overflow-y-auto transform scale-95 transition-transform duration-300 shadow-2xl relative">
            <button type="button" onclick="closeCreateModal()" class="absolute top-6 right-6 w-8 h-8 rounded-full bg-white/5 flex items-center justify-center text-zinc-400 hover:text-white hover:bg-white/10 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
            
            <div class="mb-8">
                <h2 class="text-3xl font-bold tracking-tight text-white">Add New Project</h2>
                <p class="text-zinc-400 mt-2">Publish a new project to your portfolio showcase.</p>
            </div>

            <form id="createProjectForm" action="#" method="POST" enctype="multipart/form-data">
                @csrf
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
                                    <select id="createCategorySelect" name="category" required class="w-full bg-[#0a0a0a] border border-white/10 rounded-xl px-4 py-3 text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all appearance-none cursor-pointer">
                                        <option value="" disabled selected>Select category...</option>
                                        <option value="design">Design</option>
                                        <option value="dev">Development</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none text-zinc-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </div>
                                </div>
                                <button type="button" onclick="openCategoryModal('createCategorySelect')" class="px-4 bg-white/5 hover:bg-white/10 border border-white/10 rounded-xl text-sm font-medium transition-colors text-white whitespace-nowrap flex items-center gap-2">
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
                <div class="flex justify-end gap-4 mt-8 pt-6 border-t border-white/10">
                    <button type="button" onclick="closeCreateModal()" class="px-6 py-3 rounded-full text-sm font-bold text-zinc-400 hover:text-white hover:bg-white/5 transition-all">Cancel</button>
                    <button type="submit" class="px-8 py-3 rounded-full text-sm font-bold bg-white text-black hover:bg-gray-200 hover:scale-105 transition-all shadow-[0_0_20px_rgba(255,255,255,0.2)]">Publish Project</button>
                </div>
            </form>
        </div>
    </div>

    <!-- 2. MODAL EDIT PROJECT -->
    <div id="editModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm opacity-0 pointer-events-none transition-opacity duration-300 p-4">
        <div id="editModalContent" class="bg-[#141414] border border-white/10 rounded-3xl p-8 md:p-10 w-full max-w-4xl max-h-[90vh] overflow-y-auto transform scale-95 transition-transform duration-300 shadow-2xl relative">
            <button type="button" onclick="closeEditModal()" class="absolute top-6 right-6 w-8 h-8 rounded-full bg-white/5 flex items-center justify-center text-zinc-400 hover:text-white hover:bg-white/10 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
            
            <div class="mb-8">
                <h2 class="text-3xl font-bold tracking-tight text-white">Edit Project</h2>
                <p class="text-zinc-400 mt-2">Update the details of your portfolio showcase.</p>
            </div>

            <form id="editProjectForm" action="#" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" id="editProjectId" name="id">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-semibold text-zinc-300 mb-2">Project Title</label>
                            <input type="text" id="editTitle" name="title" required class="w-full bg-[#0a0a0a] border border-white/10 rounded-xl px-4 py-3 text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-zinc-300 mb-2">Company & Year</label>
                            <input type="text" id="editCompany" name="company" required class="w-full bg-[#0a0a0a] border border-white/10 rounded-xl px-4 py-3 text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all font-jetbrains text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-zinc-300 mb-2">Category</label>
                            <div class="flex gap-3">
                                <div class="relative flex-1">
                                    <select id="editCategorySelect" name="category" required class="w-full bg-[#0a0a0a] border border-white/10 rounded-xl px-4 py-3 text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all appearance-none cursor-pointer">
                                        <option value="design">Design</option>
                                        <option value="dev">Development</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none text-zinc-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </div>
                                </div>
                                <button type="button" onclick="openCategoryModal('editCategorySelect')" class="px-4 bg-white/5 hover:bg-white/10 border border-white/10 rounded-xl text-sm font-medium transition-colors text-white flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                    New
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-semibold text-zinc-300 mb-2">Short Description</label>
                            <textarea id="editDesc" name="desc" rows="4" required class="w-full bg-[#0a0a0a] border border-white/10 rounded-xl px-4 py-3 text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all resize-none"></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-zinc-300 mb-2">Project Image (Current)</label>
                            <div class="mb-3 w-full h-24 rounded-lg overflow-hidden border border-white/10">
                                <img id="editImagePreview" src="" alt="Current Image" class="w-full h-full object-cover opacity-60">
                            </div>
                            <div class="relative group border-2 border-dashed border-white/10 rounded-xl bg-[#0a0a0a] hover:bg-white/5 transition-all p-4 text-center cursor-pointer">
                                <input type="file" name="img" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                                <p class="text-sm text-zinc-400 font-medium group-hover:text-white transition-colors">Select new image to replace</p>
                            </div>
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
        <div id="viewModalContent" class="bg-[#141414] border border-white/10 rounded-3xl p-0 w-full max-w-3xl transform scale-95 transition-transform duration-300 shadow-2xl overflow-hidden flex flex-col md:flex-row">
            <div class="w-full md:w-1/2 h-48 md:h-auto relative">
                <img id="viewImage" src="" alt="Project Image" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-[#141414] to-transparent md:bg-gradient-to-r md:from-transparent md:to-[#141414]"></div>
            </div>
            
            <div class="p-8 w-full md:w-1/2 flex flex-col justify-center relative">
                <button type="button" onclick="closeViewModal()" class="absolute top-4 right-4 w-8 h-8 rounded-full bg-white/5 flex items-center justify-center text-zinc-400 hover:text-white hover:bg-white/10 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
                
                <span id="viewCategory" class="px-3 py-1 bg-white/5 border border-white/10 rounded-full text-[10px] font-bold uppercase tracking-widest text-white w-fit mb-4"></span>
                <h3 id="viewTitle" class="text-3xl font-bold text-white mb-2"></h3>
                <p id="viewCompany" class="text-zinc-400 font-jetbrains text-sm mb-6"></p>
                
                <p id="viewDesc" class="text-zinc-300 text-sm leading-relaxed mb-8"></p>
                
                <!-- Tombol ini sekarang memicu modal Edit, bukan link halaman -->
                <button type="button" id="viewEditBtn" class="px-6 py-3 rounded-full text-sm font-bold bg-white text-black hover:bg-gray-200 transition-all text-center shadow-[0_0_15px_rgba(255,255,255,0.15)]">Edit Project</button>
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
            <p class="text-zinc-400 text-sm mb-8">You are about to delete <span id="deleteProjectName" class="font-bold text-white"></span>. This action cannot be undone.</p>
            
            <div class="flex gap-4 justify-center">
                <button type="button" onclick="closeDeleteModal()" class="px-6 py-2.5 rounded-full text-sm font-bold text-zinc-400 hover:text-white hover:bg-white/5 transition-all w-1/2 border border-white/5">Cancel</button>
                <form id="deleteProjectForm" action="#" method="POST" class="w-1/2">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" id="deleteRowId" value="">
                    <button type="submit" class="w-full px-6 py-2.5 rounded-full text-sm font-bold bg-red-500/20 text-red-400 border border-red-500/20 hover:bg-red-500 hover:text-white transition-all shadow-[0_0_15px_rgba(239,68,68,0.2)]">Delete</button>
                </form>
            </div>
        </div>
    </div>

    <!-- 5. MODAL ADD CATEGORY (Shared for Create & Edit) -->
    <div id="categoryModal" class="fixed inset-0 z-[60] flex items-center justify-center bg-black/80 backdrop-blur-sm opacity-0 pointer-events-none transition-opacity duration-300 p-4">
        <div id="categoryModalContent" class="bg-[#141414] border border-white/10 rounded-3xl p-8 w-full max-w-sm transform scale-95 transition-transform duration-300 shadow-[0_20px_50px_rgba(0,0,0,0.5)]">
            <h3 class="text-xl font-bold text-white mb-4">Add New Category</h3>
            <div class="mb-6">
                <label class="block text-sm font-medium text-zinc-400 mb-2">Category Name</label>
                <input type="text" id="newCategoryInput" placeholder="e.g. 3D Art" class="w-full bg-[#0a0a0a] border border-white/10 rounded-xl px-4 py-3 text-white focus:border-blue-500 outline-none transition-all">
            </div>
            <div class="flex gap-3 justify-end">
                <button type="button" onclick="closeCategoryModal()" class="px-5 py-2.5 rounded-xl text-sm font-medium text-zinc-400 hover:text-white hover:bg-white/5 transition-all">Cancel</button>
                <button type="button" onclick="saveCategory()" class="px-5 py-2.5 rounded-xl text-sm font-bold bg-blue-500/20 text-blue-400 hover:bg-blue-500 hover:text-white border border-blue-500/20 transition-all">Save Category</button>
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
        const createForm = document.getElementById('createProjectForm');

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
                title: 'Project Published!',
                text: 'Your new showcase project has been successfully created.',
                showConfirmButton: false,
                timer: 2000
            }).then(() => {
                // Di dunia nyata, reload page atau add baris ke tabel via DOM
                location.reload();
            });
        });

        // ==================== EDIT MODAL ====================
        const editModal = document.getElementById('editModal');
        const editModalContent = document.getElementById('editModalContent');
        const editForm = document.getElementById('editProjectForm');

        // Parameter bisa disesuaikan dengan data riil dari database (ID, title, etc)
        function openEditModal(id, title, company, category, desc, imgSrc) {
            document.getElementById('editProjectId').value = id;
            document.getElementById('editTitle').value = title;
            document.getElementById('editCompany').value = company;
            document.getElementById('editCategorySelect').value = category;
            document.getElementById('editDesc').value = desc;
            document.getElementById('editImagePreview').src = imgSrc;

            // Jika modal View sedang terbuka, tutup dulu agar tidak tumpang tindih
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
                text: 'Your project details have been successfully updated.',
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

        function openViewModal(title, company, category, desc, imgSrc) {
            document.getElementById('viewTitle').textContent = title;
            document.getElementById('viewCompany').textContent = company;
            document.getElementById('viewCategory').textContent = category;
            document.getElementById('viewDesc').textContent = desc;
            document.getElementById('viewImage').src = imgSrc;
            
            // Set trigger tombol edit di dalam view modal
            document.getElementById('viewEditBtn').onclick = () => openEditModal('1', title, company, category.toLowerCase(), desc, imgSrc);

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
        const deleteNameSpan = document.getElementById('deleteProjectName');
        const deleteRowInput = document.getElementById('deleteRowId');

        function openDeleteModal(projectName, rowId) {
            deleteNameSpan.textContent = projectName;
            deleteRowInput.value = rowId;
            deleteModal.classList.remove('opacity-0', 'pointer-events-none');
            deleteContent.classList.remove('scale-95');
        }

        function closeDeleteModal() {
            deleteModal.classList.add('opacity-0', 'pointer-events-none');
            deleteContent.classList.add('scale-95');
        }

        document.getElementById('deleteProjectForm').addEventListener('submit', function(e) {
            e.preventDefault(); 
            closeDeleteModal();

            swalDark.fire({
                icon: 'success',
                title: 'Deleted!',
                text: 'The project has been permanently removed.',
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

        // ==================== CATEGORY MODAL ====================
        const categoryModal = document.getElementById('categoryModal');
        const categoryModalContent = document.getElementById('categoryModalContent');
        const newCategoryInput = document.getElementById('newCategoryInput');
        let activeSelectId = ''; // Untuk menyimpan ID select yang memanggil modal

        function openCategoryModal(selectId) {
            activeSelectId = selectId;
            newCategoryInput.value = '';
            categoryModal.classList.remove('opacity-0', 'pointer-events-none');
            categoryModalContent.classList.remove('scale-95');
            setTimeout(() => newCategoryInput.focus(), 100);
        }

        function closeCategoryModal() {
            categoryModal.classList.add('opacity-0', 'pointer-events-none');
            categoryModalContent.classList.add('scale-95');
        }

        function saveCategory() {
            const newCat = newCategoryInput.value.trim();
            if (newCat !== '' && activeSelectId !== '') {
                const newCatValue = newCat.toLowerCase().replace(/[^a-z0-9]/g, '-');
                const selectBox = document.getElementById(activeSelectId);
                const newOption = new Option(newCat, newCatValue);
                
                selectBox.add(newOption);
                selectBox.value = newCatValue; 
                closeCategoryModal();

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
    </script>
</body>
</html>