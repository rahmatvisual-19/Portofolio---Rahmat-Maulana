<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Albert+Sans:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Albert Sans', sans-serif; background-color: #0a0a0a; color: #ffffff; }
        .font-jetbrains { font-family: 'JetBrains Mono', monospace; }
    </style>
</head>
<body class="antialiased selection:bg-white selection:text-black min-h-screen flex items-center justify-center bg-[#0a0a0a] relative overflow-hidden">

    <!-- Background glow -->
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-blue-500/10 blur-[120px] rounded-full pointer-events-none"></div>
    <div class="absolute top-0 right-0 w-[300px] h-[300px] bg-purple-500/5 blur-[100px] rounded-full pointer-events-none"></div>

    <div class="w-full max-w-md px-6 relative z-10">

        <!-- Logo -->
        <div class="text-center mb-10">
            <a href="/" class="inline-flex items-center gap-3 text-white">
                <div class="w-4 h-4 rounded-full bg-blue-500 shadow-[0_0_15px_rgba(59,130,246,0.7)] animate-pulse"></div>
                <span class="text-2xl font-bold tracking-tight">Admin Panel</span>
            </a>
            <p class="text-zinc-500 text-sm mt-3">Sign in to manage your portfolio</p>
        </div>

        <!-- Card -->
        <div class="bg-[#141414] border border-white/10 rounded-3xl p-8 shadow-2xl relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-[1px] bg-gradient-to-r from-transparent via-white/20 to-transparent"></div>

            <form id="loginForm" action="/login" method="POST" class="space-y-5">
                @csrf

                @if($errors->any())
                <div class="bg-red-500/10 border border-red-500/20 rounded-xl px-4 py-3 text-sm text-red-400">
                    {{ $errors->first() }}
                </div>
                @endif

                <div>
                    <label class="block text-sm font-semibold text-zinc-300 mb-2">Email</label>
                    <input
                        type="email"
                        name="email"
                        placeholder="admin@example.com"
                        required
                        class="w-full bg-[#0a0a0a] border border-white/10 rounded-xl px-4 py-3 text-white placeholder-zinc-600 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all"
                    >
                </div>

                <div>
                    <label class="block text-sm font-semibold text-zinc-300 mb-2">Password</label>
                    <div class="relative">
                        <input
                            type="password"
                            id="passwordInput"
                            name="password"
                            placeholder="••••••••"
                            required
                            class="w-full bg-[#0a0a0a] border border-white/10 rounded-xl px-4 py-3 pr-12 text-white placeholder-zinc-600 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all"
                        >
                        <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-4 flex items-center text-zinc-500 hover:text-zinc-300 transition-colors">
                            <svg id="eyeIcon" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="flex items-center justify-between pt-1">
                    <label class="flex items-center gap-2 cursor-pointer group">
                        <div class="relative">
                            <input type="checkbox" id="rememberMe" class="sr-only peer">
                            <div class="w-4 h-4 rounded border border-white/20 bg-[#0a0a0a] peer-checked:bg-blue-500 peer-checked:border-blue-500 transition-all flex items-center justify-center">
                                <svg class="w-2.5 h-2.5 text-white hidden peer-checked:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                        </div>
                        <span class="text-sm text-zinc-400 group-hover:text-zinc-300 transition-colors">Remember me</span>
                    </label>
                    <a href="#" class="text-sm text-zinc-500 hover:text-white transition-colors">Forgot password?</a>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full px-8 py-3.5 rounded-full text-sm font-bold bg-white text-black hover:bg-gray-200 hover:scale-[1.02] transition-all shadow-[0_0_20px_rgba(255,255,255,0.15)] active:scale-[0.98]">
                        Sign In
                    </button>
                </div>

            </form>
        </div>

        <!-- Back to site -->
        <div class="text-center mt-6">
            <a href="/" class="inline-flex items-center gap-2 text-sm text-zinc-600 hover:text-zinc-400 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Back to website
            </a>
        </div>

    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById('passwordInput');
            input.type = input.type === 'password' ? 'text' : 'password';
        }

        // Simulasi: checkbox "remember me" visual toggle
        document.getElementById('rememberMe').addEventListener('change', function() {
            const box = this.nextElementSibling;
            const check = box.querySelector('svg');
            check.classList.toggle('hidden', !this.checked);
        });
    </script>
</body>
</html>
