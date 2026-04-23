<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Edit Experience</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Albert+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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

        <div class="p-6 md:p-12 lg:p-16 max-w-3xl mx-auto">

            <div class="mb-10">
                <div class="flex items-center gap-2 text-sm text-zinc-500 font-medium mb-3">
                    <a href="/admin/experience" class="hover:text-white transition-colors">Experience</a>
                    <span>/</span>
                    <span class="text-white">Edit</span>
                </div>
                <h1 class="text-3xl md:text-4xl font-bold tracking-tight text-white">Edit Experience</h1>
                <p class="text-zinc-400 mt-2">Update this experience entry.</p>
            </div>

            <form id="editForm" action="#" method="POST" class="bg-[#141414] border border-white/10 rounded-3xl p-8 md:p-10 shadow-2xl relative overflow-hidden">
                @csrf
                @method('PUT')
                <div class="absolute top-0 left-0 w-full h-[1px] bg-gradient-to-r from-transparent via-white/20 to-transparent"></div>

                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-semibold text-zinc-300 mb-2">Company Name</label>
                        <input type="text" name="company" value="Google" required class="w-full bg-[#0a0a0a] border border-white/10 rounded-xl px-4 py-3 text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-zinc-300 mb-2">Role / Position</label>
                        <input type="text" name="role" value="Senior UI Designer" required class="w-full bg-[#0a0a0a] border border-white/10 rounded-xl px-4 py-3 text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-zinc-300 mb-2">Start Year</label>
                            <input type="text" name="start_year" value="2022" required class="w-full bg-[#0a0a0a] border border-white/10 rounded-xl px-4 py-3 text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-zinc-300 mb-2">End Year</label>
                            <input type="text" name="end_year" value="Present" class="w-full bg-[#0a0a0a] border border-white/10 rounded-xl px-4 py-3 text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-zinc-300 mb-2">Description</label>
                        <textarea name="description" rows="3" class="w-full bg-[#0a0a0a] border border-white/10 rounded-xl px-4 py-3 text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all resize-none">Led design systems and product UI across multiple teams.</textarea>
                    </div>
                </div>

                <div class="h-px w-full bg-gradient-to-r from-transparent via-white/10 to-transparent my-8"></div>

                <div class="flex justify-end gap-4">
                    <a href="/admin/experience" class="px-6 py-3 rounded-full text-sm font-bold text-zinc-400 hover:text-white hover:bg-white/5 transition-all">Cancel</a>
                    <button type="submit" class="px-8 py-3 rounded-full text-sm font-bold bg-blue-600 text-white hover:bg-blue-500 hover:scale-105 transition-all shadow-[0_0_20px_rgba(37,99,235,0.4)]">Save Changes</button>
                </div>
            </form>
        </div>
    </main>

    <script>
        const swalDark = Swal.mixin({
            background: '#141414', color: '#ffffff',
            customClass: { popup: 'border border-white/10 rounded-3xl shadow-2xl', confirmButton: 'px-8 py-3 rounded-full text-sm font-bold bg-blue-600 text-white transition-all focus:outline-none focus:ring-0' },
            buttonsStyling: false
        });

        document.getElementById('editForm').addEventListener('submit', function(e) {
            e.preventDefault();
            swalDark.fire({ icon: 'success', title: 'Changes Saved!', text: 'Experience entry has been updated.', showConfirmButton: false, timer: 2000 })
                .then(() => { window.location.href = '/admin/experience'; });
        });
    </script>
</body>
</html>
