@extends('components.head')
@section('content')

    <body class="bg-gray-50 min-h-screen">
        <div class="flex min-h-screen flex-col">
            <header class="bg-white px-5 py-8 flex items-center justify-between shadow-sm">
                <div>
                    <h1 class="text-3xl font-black text-gray-800 uppercase tracking-tighter italic">Semua Layanan</h1>
                    <p class="text-sm text-gray-500 mt-1">Pilih layanan yang kamu butuhkan.</p>
                </div>
                <div class="h-10 w-10 bg-satset-green/10 rounded-full flex items-center justify-center text-satset-green">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="3" width="7" height="7"></rect>
                        <rect x="14" y="3" width="7" height="7"></rect>
                        <rect x="14" y="14" width="7" height="7"></rect>
                        <rect x="3" y="14" width="7" height="7"></rect>
                    </svg>
                </div>
            </header>

            <main class="flex-1 pb-24 mt-6">
                <div class="px-5 pb-6">
                    <div class="grid grid-cols-2 gap-4">
                        @foreach ($serviceParents as $parent)
                            <div class="service-card bg-white rounded-xl shadow-[0_4px_20px_rgb(0,0,0,0.05)] border border-gray-100 overflow-hidden flex flex-col">
                                <div class="w-full h-32 bg-gray-50 flex items-center justify-center relative overflow-hidden group">
                                    <img src="{{ $parent['thumbnail'] ?? 'https://satsethub.satset.co.id/storage/services/hfc3.png' }}"
                                        alt="{{ $parent['keterangan'] }}" class="w-full h-full object-cover opacity-90 group-hover:scale-110 transition-transform duration-500">
                                </div>
                                <div class="p-4 flex flex-col gap-3 flex-1 justify-between">
                                    <div>
                                        <h4 class="font-black text-gray-800 text-sm truncate">{{ $parent['kode'] }}</h4>
                                        <p class="text-[11px] text-gray-500 font-medium mt-1 leading-relaxed line-clamp-2">{{ $parent['keterangan'] }}</p>
                                    </div>
                                    <a href="{{ route('services.detail', ['kode' => $parent['kode']]) }}"
                                        class="mt-1 block w-full rounded-full bg-satset-green px-3 py-2 text-white font-bold text-xs text-center shadow-md shadow-satset-green/30 hover:bg-satset-dark transition-colors duration-300 z-10">
                                        Pesan
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </main>

            <!-- Bottom Navigation -->
            @include('components.bottomNav')
        </div>

        @include('services.scriptBottom')
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

        /* Service card hover effects */
        .service-card {
            transition: all 0.3s ease;
        }

        .service-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        /* Category section animation */
        .category-section {
            animation: slideUp 0.5s ease-out backwards;
        }

        .category-section:nth-child(1) {
            animation-delay: 0.1s;
        }

        .category-section:nth-child(2) {
            animation-delay: 0.2s;
        }

        /* Service item animation */
        .service-item {
            animation: fadeIn 0.7s ease-out backwards;
        }

        .service-item:nth-child(1) {
            animation-delay: 0.3s;
        }

        .service-item:nth-child(2) {
            animation-delay: 0.4s;
        }

        .service-item:nth-child(3) {
            animation-delay: 0.5s;
        }

        .service-item:nth-child(4) {
            animation-delay: 0.6s;
        }

        /* Bottom navigation */
        .bottom-nav {
            backdrop-filter: blur(10px);
            background-color: rgba(255, 255, 255, 0.95);
        }

        /* Header shadow */
        .header-shadow {
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1), 0 1px 2px rgba(0, 0, 0, 0.06);
        }

        /* Text clamp for description */
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
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
                        'slide-up': 'slideUp 0.5s ease-out'
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
                        slideUp: {
                            '0%': {
                                opacity: '0',
                                transform: 'translateY(20px)'
                            },
                            '100%': {
                                opacity: '1',
                                transform: 'translateY(0)'
                            }
                        }
                    }
                }
            }
        }
    </script>
@endpush
