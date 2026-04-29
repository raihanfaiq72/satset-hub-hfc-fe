@extends('components.head')

@section('content')

    <body class="bg-gray-50 min-h-screen">
        <div class="flex min-h-screen flex-col">
            <main class="flex-1 pb-24">
                <div class="px-5 pt-6 pb-4 animate-fade-in">
                    <h2 class="text-2xl font-bold text-gray-800">Halo, {{ session('user_data.username') }}</h2>
                    <p class="text-sm text-gray-500">Siap bikin rumah bersih?</p>
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
                                    <div
                                        class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/10 to-transparent flex items-end justify-between p-4 gap-4">
                                        <a href="{{ $banner['button_link'] }}" target="{{ $banner['target'] }}"
                                            class="shrink-0 mb-1">
                                            <button
                                                class="rounded-full px-5 py-2 text-white font-bold transition text-sm shadow-md"
                                                style="background-color: {{ $banner['button_color'] }}">
                                                {{ $banner['button_text'] }}
                                            </button>
                                        </a>
                                        <p class="text-[10px] text-white text-left leading-tight w-[55%]">
                                            {{ $banner['deskripsi'] }}
                                        </p>
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
                            <div class="service-card bg-white rounded-xl shadow-sm overflow-hidden flex flex-col cursor-pointer" onclick="window.location.href='{{ route('services.detail', $ac['kode']) }}'">
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
                            <a href="{{ route('history.index') }}" class="text-xs font-bold text-satset-green hover:underline">Lihat Semua</a>
                        </div>
                        <div class="space-y-3">
                            @if(!empty($lastActivities))
                                @foreach($lastActivities as $activity)
                                    @php
                                        $status = (int)$activity['status'];
                                        $statusLabel = match($status) {
                                            64 => 'Selesai',
                                            63 => 'Pengerjaan',
                                            62 => 'Dijadwalkan',
                                            default => 'Diproses'
                                        };
                                        $statusClass = match($status) {
                                            64 => 'bg-green-100 text-green-600',
                                            63 => 'bg-blue-100 text-blue-600',
                                            62 => 'bg-amber-100 text-amber-600',
                                            default => 'bg-gray-100 text-gray-500'
                                        };
                                    @endphp
                                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 flex items-center gap-4 cursor-pointer hover:shadow-md transition-all active:scale-[0.98]" 
                                         onclick="window.location.href='{{ route('history.show', $activity['id']) }}'">
                                        
                                        <div class="h-14 w-14 rounded-2xl bg-satset-green/10 flex items-center justify-center text-satset-green shrink-0">
                                            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                                <polyline points="14 2 14 8 20 8"></polyline>
                                                <line x1="16" y1="13" x2="8" y2="13"></line>
                                                <line x1="16" y1="17" x2="8" y2="17"></line>
                                                <polyline points="10 9 9 9 8 9"></polyline>
                                            </svg>
                                        </div>

                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center justify-between mb-1">
                                                <h4 class="font-black text-gray-900 truncate">{{ $activity['service_name'] ?? 'Layanan' }}</h4>
                                                <span class="text-[10px] font-black px-2 py-0.5 rounded-full {{ $statusClass }} uppercase tracking-wider">
                                                    {{ $statusLabel }}
                                                </span>
                                            </div>
                                            <p class="text-xs text-gray-500 font-bold mb-2">{{ $activity['sub_service_name'] ?? 'General Cleaning' }}</p>
                                            <div class="flex items-center justify-between">
                                                <p class="text-[11px] text-gray-400 font-medium">
                                                    {{ \Carbon\Carbon::parse($activity['tglPekerjaan'] ?? $activity['tglOrder'])->translatedFormat('d F Y • H:i') }}
                                                </p>
                                                <p class="text-sm font-black text-satset-green">
                                                    Rp{{ number_format((float)data_get($activity, 'inquiry.finalPrice', 0) + 5000, 0, ',', '.') }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="text-center py-10 bg-white rounded-2xl border-2 border-dashed border-gray-100">
                                    <div class="h-12 w-12 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-3 text-gray-300">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                            <polyline points="14 2 14 8 20 8"></polyline>
                                            <line x1="16" y1="13" x2="8" y2="13"></line>
                                            <line x1="16" y1="17" x2="8" y2="17"></line>
                                            <polyline points="10 9 9 9 8 9"></polyline>
                                        </svg>
                                    </div>
                                    <p class="text-gray-400 font-bold text-sm">Belum ada aktivitas</p>
                                </div>
                            @endif
                        </div>
                        </div>
                    </section>
                </div>
            </main>

            @include('components.bottomNav')
        </div>

        @include('dashboard.scriptBottom')

        {{-- Promo Modal --}}
        @if($promoModal)
        <div id="promoModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 hidden">
            <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" onclick="closePromoModal()"></div>
            <div class="relative bg-white rounded-[32px] shadow-2xl w-full max-w-md max-h-[90vh] overflow-y-auto animate-zoom-in">
                {{-- Close Button --}}
                @if($promoModal['show_close_button'] ?? true)
                <button onclick="closePromoModal()" class="absolute top-4 right-4 z-10 w-10 h-10 bg-gray-100 hover:bg-gray-200 rounded-full flex items-center justify-center text-gray-600 transition-all">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
                @endif

                {{-- Content --}}
                <div class="p-6">
                    {{-- Video or Image --}}
                    @if(!empty($promoModal['video_url']))
                    <div class="w-full aspect-[3/4] rounded-2xl overflow-hidden mb-5 bg-gray-100">
                        <video src="{{ $promoModal['video_url'] }}" controls autoplay loop playsinline class="w-full h-full object-contain bg-black"></video>
                    </div>
                    @elseif(!empty($promoModal['gambar']))
                    <div class="w-full aspect-video rounded-2xl overflow-hidden mb-5 bg-gray-100">
                        <img src="{{ $promoModal['gambar'] }}" alt="{{ $promoModal['judul'] }}" class="w-full h-full object-cover">
                    </div>
                    @endif

                    {{-- Title --}}
                    <h2 class="text-2xl font-black text-gray-900 mb-3">{{ $promoModal['judul'] }}</h2>

                    {{-- Content (HTML) --}}
                    <div class="prose prose-sm text-gray-600 mb-6">
                        {!! $promoModal['konten'] !!}
                    </div>

                    {{-- Buttons --}}
                    <div class="flex flex-col gap-3">
                        @if(!empty($promoModal['primary_button_text']))
                        <a href="{{ $promoModal['primary_button_link'] ?? '#' }}" target="_blank"
                           class="w-full py-4 rounded-2xl font-black text-center text-white transition-all hover:opacity-90"
                           style="background-color: {{ $promoModal['primary_button_color'] ?? '#007bff' }}">
                            {{ $promoModal['primary_button_text'] }}
                        </a>
                        @endif

                        @if(!empty($promoModal['secondary_button_text']))
                        <a href="{{ $promoModal['secondary_button_link'] ?? '#' }}" target="_blank"
                           class="w-full py-4 rounded-2xl font-bold text-center transition-all hover:opacity-80 border-2"
                           style="color: {{ $promoModal['secondary_button_color'] ?? '#6c757d' }}; border-color: {{ $promoModal['secondary_button_color'] ?? '#6c757d' }}">
                            {{ $promoModal['secondary_button_text'] }}
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <script>
            function openPromoModal() {
                const modal = document.getElementById('promoModal');
                if (!modal) return;
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }

            function closePromoModal() {
                const modal = document.getElementById('promoModal');
                if (!modal) return;
                const video = modal.querySelector('video');
                if(video) {
                    video.pause();
                    video.currentTime = 0;
                }
                modal.classList.add('hidden');
                document.body.style.overflow = '';
                
                // Set flag to not show again
                localStorage.setItem('promo_modal_dismissed', 'true');
            }

            // Auto open on page load
            document.addEventListener('DOMContentLoaded', function() {
                const dismissed = localStorage.getItem('promo_modal_dismissed');
                if (dismissed) return;

                setTimeout(function() {
                    openPromoModal();

                    // Auto close if enabled
                    @if(($promoModal['auto_close'] ?? false) && ($promoModal['auto_close_delay'] ?? 0) > 0)
                    setTimeout(function() {
                        closePromoModal();
                    }, {{ ($promoModal['auto_close_delay'] ?? 0) * 1000 }});
                    @endif
                }, 500);
            });
        </script>
        @endif
    </body>

    </html>
@endsection

@push('style')
    <style>
        /* Promo Modal Animation */
        @keyframes zoomIn {
            from {
                opacity: 0;
                transform: scale(0.9) translateY(20px);
            }
            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }
        .animate-zoom-in {
            animation: zoomIn 0.4s ease-out;
        }

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
