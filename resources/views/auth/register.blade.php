@extends('components.head')

@section('content')

    <body class="bg-white min-h-screen flex items-center justify-center p-6">

        <div class="w-full max-w-md px-10 space-y-6">

            <!-- Title -->
            <div class="text-center space-y-2">
                <h2 class="text-2xl font-bold text-gray-800">
                    Buat Akun Baru
                </h2>
                <p class="text-sm text-gray-500">
                    Silakan isi data di bawah ini
                </p>
            </div>

            <!-- Alert Success -->
            @if (session('success'))
                <div class="bg-green-100 text-green-700 p-3 rounded-lg text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Alert Error -->
            @if ($errors->any())
                <div class="bg-red-100 text-red-700 p-3 rounded-lg text-sm">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form -->
            <form method="POST" action="{{ route('register.post') }}" class="space-y-4">
                @csrf

                <!-- Username -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">
                        Username
                    </label>
                    <input type="text" name="username" value="{{ old('username') }}" placeholder="Masukkan username"
                        class="w-full h-12 px-4 border border-gray-300 rounded-xl focus:ring-2 focus:ring-satset-green focus:outline-none"
                        required>
                </div>

                <!-- No HP -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">
                        No Handphone
                    </label>
                    <input type="text" name="noHp" value="{{ old('noHp') }}" placeholder="08xxxxxxxxxx"
                        class="w-full h-12 px-4 border border-gray-300 rounded-xl focus:ring-2 focus:ring-satset-green focus:outline-none"
                        required>
                </div>

                <!-- Password -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">
                        Password
                    </label>
                    <input type="password" name="password" placeholder="Masukkan password"
                        class="w-full h-12 px-4 border border-gray-300 rounded-xl focus:ring-2 focus:ring-satset-green focus:outline-none"
                        required>
                </div>

                <!-- Confirm Password -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">
                        Konfirmasi Password
                    </label>
                    <input type="password" name="password_confirmation" placeholder="Ulangi password"
                        class="w-full h-12 px-4 border border-gray-300 rounded-xl focus:ring-2 focus:ring-satset-green focus:outline-none"
                        required>
                </div>

                <!-- Submit -->
                <button type="submit"
                    class="w-full h-12 bg-satset-green hover:bg-satset-dark text-white font-bold rounded-xl transition">
                    Daftar
                </button>
            </form>

            <!-- Login Link -->
            <p class="text-center text-sm text-gray-500">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="text-satset-green font-semibold">
                    Login
                </a>
            </p>

        </div>

    </body>
@endsection