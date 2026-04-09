@extends('components.head')

@section('content')

<body class="bg-gray-50 min-h-screen">
    <div class="flex min-h-screen flex-col">
        <main class="flex-1 pb-24">
            <div class="px-5 pt-6 pb-4 animate-fade-in">
                <h2 class="text-2xl font-bold text-gray-800">Halo, {{ session('user_data.username') }}</h2>
                <p class="text-sm text-gray-500">Selamat datang kembali di SatSet App</p>
            </div>
            @include('components.errorAlert')

            <div class="px-5 pb-6">
                <div class="carousel-container flex gap-4 overflow-x-auto snap-x">
                    @foreach ($banners as $banner)
                    <div class="carousel-item w-full">
                        <div class="relative rounded-xl overflow-hidden shadow-lg service-card">
                            <div class="w-full h-44">
                                <img src="{{ $banner['gambar'] }}" alt="{{ $banner['judul'] }}"
                                    class="w-full h-full object-cover">
                            </div>
                            <div class="absolute inset-0 bg-black/40 flex flex-col justify-end p-4">
                                <h3 class="text-xl md:text-2xl font-bold text-white">{{ $banner['judul'] }}</h3>
                                <p class="text-sm text-gray-200">{{ $banner['deskripsi'] }}</p>
                                <a href="{{ $banner['button_link'] }}" target="{{ $banner['target'] }}">
                                    <button class="mt-2 rounded-full px-4 py-2 text-white font-semibold transition"
                                        style="background-color: {{ $banner['button_color'] }}">
                                        {{ $banner['button_text'] }}
                                    </button>
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="px-5 pb-6">
                <section>
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-bold text-gray-800 text-lg">Kategori Layanan </h3>
                        <button class="text-xs font-bold text-satset-green hover:underline">Lihat Semua</button>
                    </div>
                    <div class="flex gap-4 overflow-x-auto snap-x pb-2">
                        @foreach ($serviceParents as $sp)
                        <div
                            class="snap-start shrink-0 w-36 bg-white rounded-xl p-4 flex flex-col items-center text-center shadow-sm border border-gray-50">
                            <div
                                class="h-14 w-14 rounded-full flex items-center justify-center bg-gray-100 mb-3 overflow-hidden">
                                <i class="{{ $sp['icon'] ?? 'fa fa-question' }} text-xl text-satset-green"></i>
                            </div>
                            <span class="text-sm font-bold text-gray-800">{{ $sp['keterangan'] }}</span>
                        </div>
                        @endforeach
                    </div>
                </section>
            </div>

            <div class="px-5 pb-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-bold text-gray-800 text-lg">Layanan SatSet</h3>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    @foreach ($allChildren as $ac)
                    <div class="service-card bg-white rounded-xl shadow-sm overflow-hidden flex flex-col">
                        <div class="w-full h-36 bg-gray-50 flex items-center justify-center">
                            <img src="https://satsethub.satset.co.id/storage/services/hfc3.png" alt="Service Icon"
                                class="w-full h-full object-cover opacity-80">
                        </div>
                        <div class="p-4 flex flex-col gap-2 flex-1 justify-between">
                            <div>
                                <h4 class="font-bold text-gray-800">{{ $ac['kode'] }}</h4>
                                <p class="text-xs text-gray-500 mt-1">{{ $ac['keterangan'] }}</p>
                            </div>
                            <button
                                class="mt-2 w-full rounded-full bg-satset-green px-3 py-2 text-white font-semibold hover:bg-satset-dark transition">
                                Pesan
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="px-5 space-y-6">
                <section class="pt-2">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-bold text-gray-800 text-lg">Aktivitas Terakhir</h3>
                        <button class="text-xs font-bold text-satset-green hover:underline">Lihat Semua</button>
                    </div>
                    <div class="space-y-3">
                        <!-- Activity 1 -->
                        <div
                            class="activity-item bg-white rounded-xl shadow-sm border-none p-4 flex items-center gap-4">
                            <div
                                class="h-12 w-12 rounded-full bg-blue-50 flex items-center justify-center text-satset-green">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <polyline points="12 6 12 12 16 14"></polyline>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-bold text-gray-800">Pembayaran Token Listrik</p>
                                <p class="text-xs text-gray-500">04 April 2026 • 18:30</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-black text-red-500">- Rp20.000</p>
                            </div>
                        </div>

                        <!-- Activity 2 -->
                        <div
                            class="activity-item bg-white rounded-xl shadow-sm border-none p-4 flex items-center gap-4">
                            <div
                                class="h-12 w-12 rounded-full bg-green-50 flex items-center justify-center text-satset-green">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8"></path>
                                    <polyline points="16 6 12 2 8 6"></polyline>
                                    <line x1="12" y1="2" x2="12" y2="15"></line>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-bold text-gray-800">Top Up Saldo E-Wallet</p>
                                <p class="text-xs text-gray-500">04 April 2026 • 15:20</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-black text-green-500">+ Rp100.000</p>
                            </div>
                        </div>

                        <!-- Activity 3 -->
                        <div
                            class="activity-item bg-white rounded-xl shadow-sm border-none p-4 flex items-center gap-4">
                            <div
                                class="h-12 w-12 rounded-full bg-purple-50 flex items-center justify-center text-satset-green">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="1" y="4" width="22" height="16" rx="2" ry="2">
                                    </rect>
                                    <line x1="1" y1="10" x2="23" y2="10"></line>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-bold text-gray-800">Isi Pulsa Telkomsel</p>
                                <p class="text-xs text-gray-500">03 April 2026 • 10:15</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-black text-red-500">- Rp50.000</p>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </main>

        @include('components.bottomNav')
    </div>

    @include('dashboard.scriptBottom')
</body>

</html>
@endsection

@push('style')
<style>
    /* Firefox compatibility fixes */
    @-moz-document url-prefix() {

        input[type="text"],
        input[type="email"] {
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

    /* Carousel styling */
    .carousel-container {
        scroll-snap-type: x mandatory;
        scroll-behavior: smooth;
    }

    .carousel-item {
        scroll-snap-align: start;
        flex-shrink: 0;
    }

    /* Loading spinner */
    .spinner {
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        from {
            transform: rotate(0deg);
        }

        to {
            transform: rotate(360deg);
        }
    }

    /* Card hover effects */
    .service-card {
        transition: all 0.3s ease;
    }

    .service-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

    /* Icon button hover */
    .icon-btn {
        transition: all 0.2s ease;
    }

    .icon-btn:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 12px rgba(45, 122, 110, 0.2);
    }

    /* Bottom navigation */
    .bottom-nav {
        backdrop-filter: blur(10px);
        background-color: rgba(255, 255, 255, 0.95);
    }

    /* Activity item animation */
    .activity-item {
        animation: slideIn 0.5s ease-out backwards;
    }

    .activity-item:nth-child(1) {
        animation-delay: 0.1s;
    }

    .activity-item:nth-child(2) {
        animation-delay: 0.2s;
    }

    .activity-item:nth-child(3) {
        animation-delay: 0.3s;
    }

</style>
@endpush

@push('script_head')
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
                    'slide-in': 'slideIn 0.5s ease-out',
                    'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite'
                },
                keyframes: {
                    fadeIn: {
                        '0%': {
                            opacity: '0',
                            transform: 'scale(0.95)'
                        },
                        '100%': {
                            opacity: '1',
                            transform: 'scale(1)'
                        }
                    },
                    slideIn: {
                        '0%': {
                            opacity: '0',
                            transform: 'translateX(-20px)'
                        },
                        '100%': {
                            opacity: '1',
                            transform: 'translateX(0)'
                        }
                    }
                }
            }
        }
    }

</script>
@endpush
