@extends('components.head')

@section('content')

    <body class="bg-gray-50 min-h-screen">
        <div class="flex min-h-screen flex-col">
            <!-- Header & Greeting -->
            <header
                class="bg-white px-5 pt-10 pb-6 rounded-b-[2rem] shadow-[0_4px_30px_rgb(0,0,0,0.03)] z-30 relative border-b border-gray-50">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-3.5">
                        <div
                            class="h-12 w-12 rounded-full bg-gradient-to-br from-satset-green to-teal-500 flex items-center justify-center text-white shadow-lg shadow-satset-green/30 overflow-hidden border-2 border-white">
                            <i class="fa fa-user text-xl"></i>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-0.5">Selamat Datang
                                👋</p>
                            <h2 class="text-lg font-black text-gray-900 truncate max-w-[200px]">
                                {{ ucwords(strtolower(session('user_data.namaCustomer'))) }}
                            </h2>
                        </div>
                    </div>
                    <img src="{{ asset('company-logo.png') }}" alt="SatSet Logo" class="h-10 object-contain drop-shadow-sm">
                </div>

                <!-- Search/Action Bar mock -->
                <div class="bg-gray-50 rounded-2xl flex items-center px-4 py-3 border border-gray-100">
                    <i class="fa fa-search text-gray-400 mr-3"></i>
                    <p class="text-sm text-gray-400 font-medium">Layanan apa yang kamu butuhkan?</p>
                </div>
            </header>

            <main class="flex-1 pb-24 bg-[#f8fcfb]">
                @include('components.errorAlert')

                <!-- Carousel Section -->
                <div class="pt-6 pb-6">
                    <div
                        class="carousel-container flex gap-4 overflow-x-auto snap-x snap-mandatory px-6 hide-scrollbar scroll-smooth">
                        @foreach ($banners as $banner)
                            <div class="carousel-item snap-center shrink-0 w-[85%] sm:w-[80%] max-w-[320px]">
                                <div
                                    class="relative rounded-3xl overflow-hidden shadow-[0_8px_25px_rgb(0,0,0,0.06)] border border-gray-100 bg-white group cursor-pointer">
                                    <div class="w-full h-40">
                                        <img src="{{ $banner['gambar'] }}" alt="{{ $banner['judul'] }}"
                                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                    </div>
                                    <div
                                        class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent flex flex-col justify-end p-5">
                                        <h3 class="text-white font-black text-lg leading-tight mb-1 drop-shadow-md">
                                            {{ $banner['judul'] }}</h3>
                                        <p
                                            class="text-[11px] text-gray-200 text-left leading-snug mb-3 line-clamp-2 drop-shadow-sm font-medium">
                                            {{ $banner['deskripsi'] }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="px-5 pb-6">
                    <section
                        class="bg-white p-5 rounded-3xl shadow-[0_2px_20px_rgb(0,0,0,0.04)] border border-gray-100 relative overflow-hidden">
                        <!-- Decorative background element -->
                        <div class="absolute -right-10 -top-10 w-32 h-32 bg-satset-green/5 rounded-full blur-2xl"></div>

                        <div class="flex items-center justify-between mb-5 relative z-10">
                            <div class="flex items-center gap-2">
                                <div class="w-1.5 h-6 bg-satset-green rounded-full"></div>
                                <h3 class="font-bold text-gray-800 text-lg">Kategori Layanan</h3>
                            </div>
                            <button
                                class="text-xs font-bold text-satset-green bg-satset-green/10 px-3 py-1.5 rounded-full hover:bg-satset-green/20 transition active:scale-95">Lihat
                                Semua</button>
                        </div>
                        <div class="flex gap-4 overflow-x-auto snap-x pb-2 hide-scrollbar relative z-10">
                            @foreach ($serviceParents as $sp)
                                <div class="snap-start shrink-0 w-[85px] group cursor-pointer"
                                    onclick="window.location.href='#'">
                                    <div
                                        class="h-[85px] w-[85px] rounded-2xl bg-gradient-to-br from-gray-50 to-gray-100 flex items-center justify-center mb-2 overflow-hidden shadow-sm border border-gray-100 group-hover:shadow-md group-hover:border-satset-green/30 group-hover:-translate-y-1 transition-all duration-300">
                                        <i
                                            class="{{ $sp['icon'] ?? 'fa fa-th-large' }} text-3xl text-satset-green group-hover:scale-110 transition-transform duration-300"></i>
                                    </div>
                                    <span
                                        class="text-[11px] font-bold text-gray-700 block text-center leading-tight group-hover:text-satset-green transition-colors">{{ $sp['keterangan'] }}</span>
                                </div>
                            @endforeach
                        </div>
                    </section>
                </div>

                <div class="px-5 pb-6">
                    <div class="flex items-center gap-2 mb-5">
                        <div class="w-1.5 h-6 bg-amber-500 rounded-full"></div>
                        <h3 class="font-bold text-gray-800 text-lg">Layanan Populer</h3>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        @foreach ($allChildren as $ac)
                            <div class="service-card relative bg-white rounded-2xl shadow-[0_4px_20px_rgb(0,0,0,0.05)] overflow-hidden flex flex-col cursor-pointer border border-gray-100 group"
                                onclick="window.location.href='{{ route('services.detail', $ac['kode']) }}'">
                                <div class="w-full h-32 bg-gray-100 relative overflow-hidden group-hover:shadow-inner transition-shadow">
                                    <img src="https://satsethub.satset.co.id/storage/services/hfc3.png"
                                        alt="{{ $ac['keterangan'] }}"
                                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                </div>
                                <div
                                    class="p-3.5 flex flex-col gap-2 flex-1 justify-between bg-white z-10 relative">
                                    <div>
                                        <h4 class="font-black text-gray-900 text-sm truncate mb-1">
                                            {{ $ac['kode'] }}</h4>
                                        <p class="text-[11px] text-gray-500 font-medium leading-relaxed line-clamp-2">
                                            {{ $ac['keterangan'] }}</p>
                                    </div>
                                    <div class="mt-auto pt-3 border-t border-gray-50">
                                        <button
                                            class="w-full block rounded-full bg-satset-green text-white px-4 py-2 font-black text-xs text-center shadow-md shadow-satset-green/30 hover:bg-satset-dark transition-colors duration-300">
                                            Pesan
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="px-5 pb-8">
                    <section
                        class="bg-gradient-to-b from-white to-gray-50/50 p-5 rounded-3xl shadow-[0_4px_25px_rgb(0,0,0,0.03)] border border-gray-100">
                        <div class="flex items-center justify-between mb-5">
                            <div class="flex items-center gap-2">
                                <div class="w-1.5 h-6 bg-blue-500 rounded-full"></div>
                                <h3 class="font-bold text-gray-800 text-lg">Aktivitas Terakhir</h3>
                            </div>
                            <a href="{{ route('history.index') }}"
                                class="text-xs font-bold text-satset-green bg-satset-green/10 px-3 py-1.5 rounded-full hover:bg-satset-green/20 transition">Lihat
                                Semua</a>
                        </div>

                        <div
                            class="space-y-4 relative before:absolute before:inset-0 before:ml-[1.2rem] before:-translate-x-px before:h-full before:w-0.5 before:bg-gradient-to-b before:from-gray-200 before:via-gray-200 before:to-transparent">
                            @if (!empty($lastActivities))
                                @foreach ($lastActivities as $activity)
                                    @php
                                        $status = (int) $activity['status'];
                                        $statusLabel = match ($status) {
                                            64 => 'Selesai',
                                            63 => 'Pengerjaan',
                                            62 => 'Dijadwalkan',
                                            default => 'Diproses',
                                        };
                                        $statusClass = match ($status) {
                                            64 => 'bg-green-100 text-green-700 ring-green-600/20',
                                            63 => 'bg-blue-100 text-blue-700 ring-blue-600/20',
                                            62 => 'bg-amber-100 text-amber-700 ring-amber-600/20',
                                            default => 'bg-gray-100 text-gray-700 ring-gray-600/20',
                                        };
                                    @endphp
                                    <div class="relative flex items-start gap-4 group is-active activity-item"
                                        onclick="window.location.href='{{ route('history.show', $activity['id']) }}'">

                                        <!-- Timeline dot -->
                                        <div
                                            class="flex items-center justify-center w-10 h-10 rounded-full border-[3px] border-white bg-satset-green/10 text-satset-green shadow-sm shrink-0 z-10 relative">
                                            <i class="fa fa-clipboard-list text-sm"></i>
                                        </div>

                                        <div
                                            class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 flex-1 cursor-pointer hover:shadow-md transition-all active:scale-[0.98] group-hover:border-satset-green/30">
                                            <div class="flex justify-between items-start mb-2">
                                                <div>
                                                    <h4 class="font-black text-gray-900 text-sm line-clamp-1 mb-0.5">
                                                        {{ $activity['service_name'] ?? 'Layanan' }}</h4>
                                                    <p class="text-[10px] text-gray-500 font-bold">
                                                        {{ $activity['sub_service_name'] ?? 'General Cleaning' }}</p>
                                                </div>
                                                <span
                                                    class="text-[9px] font-black px-2.5 py-1 rounded-full {{ $statusClass }} ring-1 ring-inset uppercase tracking-wider whitespace-nowrap">
                                                    {{ $statusLabel }}
                                                </span>
                                            </div>

                                            <div
                                                class="flex items-center justify-between mt-3 pt-3 border-t border-gray-50 border-dashed">
                                                <div class="flex items-center gap-1.5 text-gray-400">
                                                    <i class="fa fa-calendar-alt text-[10px]"></i>
                                                    <p class="text-[10px] font-semibold">
                                                        {{ \Carbon\Carbon::parse($activity['tglPekerjaan'] ?? $activity['tglOrder'])->translatedFormat('d M Y • H:i') }}
                                                    </p>
                                                </div>
                                                <p class="text-sm font-black text-satset-green">
                                                    Rp{{ number_format((float) data_get($activity, 'inquiry.finalPrice', 0) + 5000, 0, ',', '.') }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div
                                    class="text-center py-10 bg-white rounded-2xl border-2 border-dashed border-gray-100 relative z-10">
                                    <div
                                        class="h-12 w-12 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-3 text-gray-300">
                                        <i class="fa fa-inbox text-xl"></i>
                                    </div>
                                    <p class="text-gray-400 font-bold text-sm">Belum ada aktivitas</p>
                                </div>
                            @endif
                        </div>
                    </section>
                </div>
        </div>
        </main>

        @include('components.bottomNav')
        </div>

        @include('dashboard.scriptBottom')

        {{-- Promo Modal --}}
        @if ($promoModal)
            <div id="promoModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 hidden">
                <div class="absolute inset-0 bg-black/70 backdrop-blur-sm transition-opacity" onclick="closePromoModal()">
                </div>

                <div class="relative w-full max-w-md animate-zoom-in flex flex-col items-end max-h-full py-4">
                    {{-- Close Button (Outside Container) --}}
                    @if ($promoModal['show_close_button'] ?? true)
                        <button onclick="closePromoModal()"
                            class="mb-3 w-10 h-10 shrink-0 bg-white/20 hover:bg-white/40 backdrop-blur-md rounded-full flex items-center justify-center text-white transition-all shadow-lg border border-white/30 z-10">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                <line x1="6" y1="6" x2="18" y2="18"></line>
                            </svg>
                        </button>
                    @endif

                    <div class="bg-white rounded-[32px] shadow-2xl w-full flex-1 min-h-0 overflow-y-auto hide-scrollbar">
                        {{-- Content --}}
                        <div class="p-6">
                            {{-- Video or Image --}}
                            @if (!empty($promoModal['video_url']))
                                <div class="w-full aspect-[3/4] rounded-2xl overflow-hidden mb-5 bg-gray-100 shrink-0">
                                    <video src="{{ $promoModal['video_url'] }}" controls autoplay loop playsinline
                                        class="w-full h-full object-contain bg-black"></video>
                                </div>
                            @elseif(!empty($promoModal['gambar']))
                                <div class="w-full aspect-video rounded-2xl overflow-hidden mb-5 bg-gray-100 shrink-0">
                                    <img src="{{ $promoModal['gambar'] }}" alt="{{ $promoModal['judul'] }}"
                                        class="w-full h-full object-cover">
                                </div>
                            @endif

                            {{-- Title --}}
                            <h2 class="text-2xl font-black text-gray-900 mb-3">{{ $promoModal['judul'] }}</h2>

                            {{-- Content (HTML) --}}
                            <div class="prose prose-sm text-gray-600 mb-2">
                                {!! $promoModal['konten'] !!}
                            </div>
                        </div>
                    </div>

                    {{-- Buttons --}}
                    <div class="flex flex-col gap-3 w-full mt-4 shrink-0">
                        @if (!empty($promoModal['primary_button_text']))
                            <a href="{{ $promoModal['primary_button_link'] ?? '#' }}" target="_blank"
                                class="w-full py-4 rounded-2xl font-black text-center text-white transition-all hover:opacity-90 shadow-lg shrink-0"
                                style="background-color: {{ $promoModal['primary_button_color'] ?? '#007bff' }}">
                                {{ $promoModal['primary_button_text'] }}
                            </a>
                        @endif

                        @if (!empty($promoModal['secondary_button_text']))
                            <a href="{{ $promoModal['secondary_button_link'] ?? '#' }}" target="_blank"
                                class="w-full py-4 rounded-2xl font-bold text-center transition-all hover:bg-gray-50 bg-white shadow-lg border-2 shrink-0"
                                style="color: {{ $promoModal['secondary_button_color'] ?? '#6c757d' }}; border-color: {{ $promoModal['secondary_button_color'] ?? '#6c757d' }}">
                                {{ $promoModal['secondary_button_text'] }}
                            </a>
                        @endif
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
                    if (video) {
                        video.pause();
                        video.currentTime = 0;
                    }
                    modal.classList.add('hidden');
                    document.body.style.overflow = '';

                }

                // Auto open on page load
                document.addEventListener('DOMContentLoaded', function() {
                    setTimeout(function() {
                        openPromoModal();

                        // Auto close if enabled
                        @if (($promoModal['auto_close'] ?? false) && ($promoModal['auto_close_delay'] ?? 0) > 0)
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
        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

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
