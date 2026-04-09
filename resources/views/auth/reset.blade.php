<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SatSet - Login Mockup</title>

    <!-- Tailwind CDN -->
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
            <div class="mb-4 flex justify-center">
                <img 
                    src="https://api.satset.co.id/asset/logo.png" 
                    alt="Logo SatSet"
                    class="w-32 h-32 object-contain"
                />
            </div>
            @include('components.errorAlert')
            <h2 class="text-2xl font-bold text-gray-800">
               Berhasil Memverifikasi OTP!
            </h2>
            <p class="text-center text-sm font-medium text-green-600">
                Silahkan Reset Password Anda
            </p>
        </div>

        <!-- Form -->
        <form class="space-y-6" action="{{ route('password.update') }}" method="POST">
            @csrf
            
            <div class="space-y-2">
                <label for="password" class="font-bold text-gray-700 block">
                    Password Baru
                </label>
                <input 
                    id="password" 
                    name="password"
                    type="password"
                    placeholder="Type Password Here"
                    value="{{ old('password') }}"
                    class="h-12 w-full rounded-xl border border-gray-300 px-4 py-3 text-base text-black placeholder:text-gray-500 focus:border-green-500 focus:outline-none focus:ring-2 focus:ring-green-500"
                    required
                />
            </div>

            <input type="hidden" name="noHp" id="noHp" value="{{ old('noHp', session('noHp')) }}">

            <!-- Submit Button (FIXED) -->
            <button 
                type="submit" 
                class="h-12 w-full bg-green-600 hover:bg-green-700 text-white font-bold text-lg rounded-xl transition-colors"
            >
                Submit
            </button>
        </form>

        <!-- Back Button -->
        <div class="pt-4">
            <a href="/login" 
               class="h-12 w-full border-2 border-green-600 text-green-600 font-bold hover:bg-green-100 rounded-xl transition-colors flex items-center justify-center text-lg no-underline">
                Kembali ke halaman Login
            </a>
        </div>

    </div>

</body>
</html>