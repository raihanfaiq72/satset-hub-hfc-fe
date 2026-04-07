<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SatSet - Login Mockup</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Firefox compatibility fixes */
        @-moz-document url-prefix() {
            input[type="text"],
            input[type="password"] {
                -moz-appearance: none !important;
                appearance: none !important;
                color: #000000 !important;
                background-color: #ffffff !important;
            }
        }

        /* General input fixes */
        input {
            -webkit-appearance: none !important;
            -moz-appearance: none !important;
            appearance: none !important;
            color: #000000 !important;
            background-color: #ffffff !important;
        }
    </style>
</head>
<body class="bg-white min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-[400px] space-y-8">
        <!-- Header -->
        <div class="flex flex-col items-center space-y-2">
            <div class="mb-4 flex justify-center animate-fade-in">
                <img 
                    src="https://api.satset.co.id/asset/logo.png" 
                    alt="Logo SatSet"
                    class="w-32 h-32 object-contain"
                />
            </div>

            <h2 class="text-2xl font-bold text-gray-800">
                Selamat Datang Kembali!
            </h2>
            <p class="text-center text-sm font-medium text-satset-green">
                Silahkan Login Menggunakan Username Dan Password Anda
            </p>
        </div>

        @include('components.errorAlert')

        <form class="space-y-6 animate-fade-in" action="{{ route('login.post') }}" method="POST">
            @csrf
            <div class="space-y-2">
                <label for="username" class="font-bold text-gray-700 block">
                    Username
                </label>
                <input 
                    id="username" 
                    name="username"
                    type="text"
                    placeholder="Type Username Here"
                    class="h-12 w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-base text-black transition-colors placeholder:text-gray-500 focus:border-satset-green focus:outline-none focus:ring-2 focus:ring-satset-green focus:ring-offset-2"
                    required
                    autocomplete="off"
                    value="{{ old('username') }}"
                    autofocus
                />
            </div>

            <!-- Password Field -->
            <div class="space-y-2">
                <label for="password" class="font-bold text-gray-700 block">
                    Password
                </label>
                <div class="relative">
                    <input 
                        id="password" 
                        name="password"
                        type="password"
                        placeholder="Type Password Here"
                        class="h-12 w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-base text-black transition-colors placeholder:text-gray-500 focus:border-satset-green focus:outline-none focus:ring-2 focus:ring-satset-green focus:ring-offset-2 pr-10"
                        required
                        autocomplete="current-password"
                    />
                    <button 
                        type="button" 
                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700 bg-transparent border-none p-1 cursor-pointer"
                        onclick="togglePassword()"
                    >
                        <svg id="eyeIcon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Submit Button -->
            <button 
                type="submit" 
                class="h-12 w-full bg-satset-green hover:bg-satset-dark text-white font-bold text-lg rounded-xl transition-colors border-none cursor-pointer"
            >
                Login
            </button>
        </form>

        <!-- Forgot Password Link -->
        <div class="flex items-center justify-between px-1">
            <a href="/forgot-password" class="text-sm font-semibold text-satset-green hover:underline">
                Lupa password?
            </a>
        </div>

        <!-- Register Section -->
        <div class="pt-8 space-y-4">
            <p class="text-center text-sm font-bold text-gray-700">
                Belum punya akun?
            </p>
            <a href="/register" class="h-12 w-full border-2 border-satset-green text-satset-green font-bold hover:bg-satset-green/5 rounded-xl transition-colors flex items-center justify-center text-lg no-underline">
                Daftar Sekarang!
            </a>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.innerHTML = `
                    <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8"></path>
                    <line x1="1" y1="1" x2="23" y2="23"></line>
                `;
            } else {
                passwordInput.type = 'password';
                eyeIcon.innerHTML = `
                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                    <circle cx="12" cy="12" r="3"></circle>
                `;
            }
        }
    </script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'satset-green': '#2d7a6e',
                        'satset-dark': '#246359'
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.7s ease-out',
                        'pulse-slow': 'pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite'
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0', transform: 'scale(0.95)' },
                            '100%': { opacity: '1', transform: 'scale(1)' }
                        }
                    }
                }
            }
        }
    </script>
</body>
</html>
