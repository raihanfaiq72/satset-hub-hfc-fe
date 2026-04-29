@extends('components.head')

@section('content')

    <body class="bg-gray-50 min-h-screen">
        <div class="flex min-h-screen flex-col">

            <!-- Header -->
            <header class="fixed top-0 z-30 w-full px-5 py-4 flex items-center justify-between">
                <a href="{{ url('dashboard') }}">
                    <button
                        class="pointer-events-auto flex h-10 w-10 items-center justify-center rounded-full bg-white/90 backdrop-blur-md text-gray-800 shadow-lg hover:bg-white transition-all btn-active">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="19" y1="12" x2="5" y2="12"></line>
                            <polyline points="12 19 5 12 12 5"></polyline>
                        </svg>
                    </button>
                </a>
            </header>

            <!-- Main -->
            <main class="flex-1 pb-32">

                <!-- Banner -->
                <div class="w-full h-[220px] bg-gradient-to-br from-satset-green to-satset-dark"></div>

                <!-- Card -->
                <div class="relative px-5 -mt-36">
                    <div class="bg-white rounded-[30px] p-6 shadow-xl">

                        <!-- Foto (Static Placeholder as requested) -->
                        <div class="flex flex-col items-center mb-8">
                            <div
                                class="w-24 h-24 rounded-full bg-satset-green/10 flex items-center justify-center text-satset-green text-3xl mb-1 border-4 border-white shadow-sm">
                                👤
                            </div>
                            <h2 class="text-xl font-black text-gray-800">{{ $user['nama'] ?? 'User' }}</h2>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">{{ $user['username'] ?? 'username' }}</p>
                        </div>

                        @include('components.errorAlert')
                        @if(session('success'))
                            <div class="mb-4 p-4 bg-green-50 text-green-600 rounded-2xl text-sm font-bold border border-green-100 animate-fade-in">
                                {{ session('success') }}
                            </div>
                        @endif

                        <!-- Form -->
                        <form id="profileForm" action="{{ route('profile.update') }}" method="POST" class="space-y-5">
                            @csrf
                            <div>
                                <label class="text-xs font-black text-gray-400 uppercase tracking-widest ml-1">Nama Lengkap</label>
                                <input type="text" name="nama" value="{{ old('nama', $user['nama'] ?? '') }}"
                                    class="w-full mt-1.5 p-4 rounded-2xl border border-gray-100 bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-satset-green transition-all font-bold text-gray-800">
                            </div>

                            <div>
                                <label class="text-xs font-black text-gray-400 uppercase tracking-widest ml-1">Username</label>
                                <input type="text" name="username" value="{{ old('username', $user['username'] ?? '') }}"
                                    class="w-full mt-1.5 p-4 rounded-2xl border border-gray-100 bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-satset-green transition-all font-bold text-gray-800">
                            </div>

                            <div>
                                <label class="text-xs font-black text-gray-400 uppercase tracking-widest ml-1">Email</label>
                                <input type="email" name="email" value="{{ old('email', $user['email'] ?? '') }}"
                                    class="w-full mt-1.5 p-4 rounded-2xl border border-gray-100 bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-satset-green transition-all font-bold text-gray-800">
                            </div>

                            <div>
                                <label class="text-xs font-black text-gray-400 uppercase tracking-widest ml-1">No. HP</label>
                                <input type="text" name="noHp" value="{{ old('noHp', $user['noHp'] ?? '') }}"
                                    class="w-full mt-1.5 p-4 rounded-2xl border border-gray-100 bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-satset-green transition-all font-bold text-gray-800">
                            </div>

                        </form>

                    </div>
                </div>

            </main>

            <!-- Footer -->
            <div class="fixed bottom-0 left-0 right-0 bg-white/80 backdrop-blur-md p-6 border-t border-gray-100 z-20">
                <button type="submit" form="profileForm" class="w-full h-16 bg-satset-green hover:bg-satset-dark text-white font-black text-lg rounded-3xl shadow-xl shadow-satset-green/30 uppercase tracking-widest transition-all active:scale-[0.98]">
                    Simpan Perubahan
                </button>
            </div>

        </div>

    </body>
@endsection
