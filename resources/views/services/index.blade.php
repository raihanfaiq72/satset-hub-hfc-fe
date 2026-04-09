@extends('components.head')
@section('content')

<body class="bg-gray-50 min-h-screen">
    <div class="flex min-h-screen flex-col">
        <header class="sticky top-0 z-20 bg-white px-5 py-4 header-shadow flex items-center gap-4">
            <a href="{{ route('dashboard') }}" class="text-gray-800 hover:text-satset-green transition-colors">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
            </a>
            <h1 class="text-xl font-bold text-gray-800">Semua Layanan</h1>
        </header>

        <main class="flex-1 pb-24 pt-4">
            @foreach($serviceParents as $parent)
            <div class="px-5 pb-6">
                <h3 class="font-bold text-gray-800 text-lg mb-2">{{ $parent['keterangan'] }}</h3>
                <div class="grid grid-cols-2 gap-4">
                    @foreach($parent['children'] as $child)
                    <div class="service-card bg-white rounded-xl shadow-sm overflow-hidden flex flex-col">
                        <div class="w-full h-36 bg-gray-50 flex items-center justify-center">
                            <img src="{{ $child['thumbnail'] ?? 'https://api.satset.co.id/asset/logo.png' }}"
                                alt="Service Icon" class="w-full h-full object-cover opacity-80">
                        </div>
                        <div class="p-4 flex flex-col gap-2 flex-1 justify-between">
                            <div>
                                <h4 class="font-bold text-gray-800">{{ $child['kode'] }}</h4>
                                <p class="text-xs text-gray-500 mt-1">{{ $child['keterangan'] }}</p>
                            </div>
                            <a href="{{ route('services.detail', ['kode' => $child['kode']]) }}"
                                class="mt-2 block w-full rounded-full bg-satset-green px-3 py-2 text-white font-semibold text-center hover:bg-satset-dark transition z-10">
                                Pesan
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
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
