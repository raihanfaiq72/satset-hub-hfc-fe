@extends('components.head')

@section('content')
    @php
        $galleryItems = json_decode($service['gambar'], true) ?? [];
    @endphp

    <body class="bg-gray-50 min-h-screen">
        <div class="flex min-h-screen flex-col">
            <!-- Floating Header -->
            <header class="fixed top-0 z-30 w-full px-5 py-4 flex items-center justify-between pointer-events-none">
                <a href="{{ url('services') }}">
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

            <!-- Main Content -->
            <main class="flex-1 pb-32 animate-fade-in">
                <!-- Banner Hero -->
                <div class="relative w-full h-[400px] lg:h-[500px]">
                    <div class="w-full h-full bg-gray-60 flex items-center justify-center p-1">
                        <img src="{{ $service['thumbnail'] ?? 'https://api.satset.co.id/asset/logo.png' }}"
                            alt="Service Icon" class="h-full object-contain opacity-80">
                    </div>
                </div>

                <!-- Floating Profile/Info Card -->
                <div class="px-5 -mt-24 relative z-10 lg:max-w-4xl lg:mx-auto">
                    <div class="profile-card border-none bg-white rounded-[40px] overflow-hidden">
                        <div class="p-8 text-center">
                            <div class="flex justify-center mb-3">
                                <div class="bg-satset-green/10 px-4 py-1.5 rounded-full">
                                    <span
                                        class="text-[10px] font-black text-satset-green uppercase tracking-widest">{{ $service['kode'] }}
                                        - Rp {{ number_format($service['harga'], 0, ',', '.') ?? 150.0 }}</span>
                                </div>
                            </div>

                            <h2 class="text-3xl font-black text-gray-900 mb-1">{{ $service['keterangan'] }}</h2>

                        </div>
                    </div>
                </div>

                <!-- Gallery Section -->
                <div class="mt-10 lg:max-w-6xl lg:mx-auto">
                    <div class="px-6 flex items-center justify-between mb-5">
                        <h3 class="font-black text-gray-800 text-xl tracking-tight">Galeri Layanan</h3>
                        <button class="text-xs font-bold text-satset-green hover:underline">Lihat Semua</button>
                    </div>
                    <div class="flex gap-4 overflow-x-auto px-6 pb-6 no-scrollbar lg:flex-wrap lg:justify-center">
                        @foreach ($galleryItems as $index => $item)
                            <div class="gallery-item relative flex-shrink-0 w-36 h-36 lg:w-48 lg:h-48 rounded-[28px] overflow-hidden shadow-md cursor-pointer border-2 border-white"
                                onclick="openZoom({{ $index }})">
                                @if ($item['type'] === 'image')
                                    <img src="{{ $item['path'] }}" alt="Gallery Image" class="w-full h-full object-cover">
                                @elseif($item['type'] === 'video')
                                    <video class="w-full h-full object-cover" muted>
                                        <source src="{{ $item['path'] }}" type="video/mp4">
                                    </video>
                                @endif
                                <div
                                    class="absolute bottom-3 right-3 h-8 w-8 bg-black/40 backdrop-blur-md rounded-full flex items-center justify-center text-white border border-white/20">
                                    @if ($item['type'] === 'image')
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2">
                                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2">
                                            </rect>
                                            <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                            <polyline points="21 15 16 10 5 21"></polyline>
                                        </svg>
                                    @else
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"
                                            stroke="none">
                                            <polygon points="5 3 19 12 5 21 5 3"></polygon>
                                        </svg>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- About Section -->
                <div class="px-6 mt-4 space-y-4 lg:max-w-4xl lg:mx-auto">
                    <h3 class="font-black text-gray-800 text-xl tracking-tight">Tentang Layanan</h3>
                    <p class="text-sm text-gray-500 leading-relaxed font-medium">
                        {!! $service['deskripsi'] !!}
                    </p>
                </div>
            </main>

            <!-- Footer CTA -->
            <div class="footer-cta fixed bottom-0 left-0 right-0 bg-white/90 p-6 border-t border-gray-100 z-20 lg:max-w-6xl lg:left-1/2 lg:-translate-x-1/2 lg:rounded-t-3xl">
                <a href="{{ route('services.book', $service['kode']) }}" class="block lg:max-w-md lg:mx-auto">
                    <button
                        class="w-full h-16 bg-satset-green hover:bg-satset-dark text-white font-black text-lg rounded-3xl shadow-xl shadow-satset-green/30 uppercase tracking-widest transition-all btn-active">
                        Pesan Sekarang
                    </button>
                </a>
            </div>

            <!-- Fullscreen Zoom Modal -->
            <div id="zoomModal" class="fixed inset-0 z-50 flex items-center justify-center p-6 overflow-hidden hidden">
                <div class="modal-backdrop absolute inset-0 bg-black/80 backdrop-blur-xl" onclick="closeZoom()"></div>

                <!-- Modal Controls -->
                <button onclick="closeZoom()"
                    class="absolute top-8 right-8 z-[60] text-white p-3 rounded-full bg-white/10 hover:bg-white/20 backdrop-blur-md transition-all">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>

                <button onclick="prevZoom()"
                    class="absolute left-6 top-1/2 -translate-y-1/2 z-[60] text-white p-4 rounded-full bg-white/10 hover:bg-white/20 backdrop-blur-md transition-all shadow-lg">
                    <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="15 18 9 12 15 6"></polyline>
                    </svg>
                </button>

                <div
                    class="modal-content relative w-full max-w-5xl h-[70vh] flex flex-col items-center justify-center z-[55]">
                    <div class="relative w-full h-full rounded-3xl overflow-hidden shadow-2xl" id="mediaContainer"></div>
                    <div class="mt-8 text-center px-4">
                        <p class="inline-block bg-white/10 backdrop-blur-md text-white px-8 py-3 rounded-full text-sm font-bold border border-white/20 shadow-xl"
                            id="mediaCaption"></p>
                    </div>
                </div>

                <button onclick="nextZoom()"
                    class="absolute right-6 top-1/2 -translate-y-1/2 z-[60] text-white p-4 rounded-full bg-white/10 hover:bg-white/20 backdrop-blur-md transition-all shadow-lg">
                    <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="9 18 15 12 9 6"></polyline>
                    </svg>
                </button>
            </div>
        </div>
        </div>

        @include('services.scriptBottomDetail')
    </body>

    </html>
@endsection
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
                        'zoom-in': 'zoomIn 0.3s ease-out',
                        'slide-up': 'slideUp 0.5s ease-out'
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': {
                                opacity: '0'
                            },
                            '100%': {
                                opacity: '1'
                            }
                        },
                        zoomIn: {
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

        /* No scrollbar for gallery */
        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        /* Gallery item hover */
        .gallery-item {
            transition: all 0.3s ease;
        }

        .gallery-item:hover {
            transform: scale(1.05);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }

        /* Modal backdrop animation */
        .modal-backdrop {
            animation: fadeIn 0.3s ease-out;
        }

        /* Modal content animation */
        .modal-content {
            animation: zoomIn 0.3s ease-out;
        }

        /* Button active state */
        .btn-active:active {
            transform: scale(0.98);
        }

        /* Floating header */
        .floating-header {
            backdrop-filter: blur(12px);
        }

        /* Stats card */
        .stats-card {
            transition: all 0.2s ease;
        }

        .stats-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        /* Profile card shadow */
        .profile-card {
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        /* Footer CTA */
        .footer-cta {
            backdrop-filter: blur(16px);
        }
    </style>
@endpush
